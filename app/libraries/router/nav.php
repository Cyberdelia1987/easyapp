<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class MLib_Router_Nav extends MLib_Base_Singleton
{
	/**
	 * Получение верхней навигации
	 * @return string
	 */
	public function getTopNav()
	{
		$config = MLib_Config::getMain('topnav', 'nav');
		$url = MLib_Router::instance()->getPath();

		foreach ($config as &$row)
		{
			$this->_passThroughPlugin($row);
			$strict = setif($row, 'strict');
			$row['active'] = $this->_getIsActive($url, $row, $strict);
		}

		MLib_Viewer::instance()->assign('topnav_config', $config);
		return MLib_Viewer::instance()->fetch('main/nav/top.tpl');
	}

	/**
	 * Определить, если ссылка должна быть подсвечена
	 * @param string	$url
	 * @param array		$val
	 * @param bool		$strict
	 * @return bool
	 */
	protected function _getIsActive($url, $val, $strict = false)
	{
		$expr = '/^'.str_replace('/', '\/', setif($val, 'regexp')).($strict ? '/' : '.*/');
		return (bool) preg_match($expr, $url);
	}

	/**
	 * Обработка ряда плагином
	 * @param $row
	 */
	protected function _passThroughPlugin(&$row)
	{
		$class_name = setif($row, 'plugin');
		if (!$class_name) return;
		if (!class_exists($class_name)) return;

		$plugin = new $class_name($row);
		if (!$plugin instanceof MLib_Router_Nav_Plugin_Abstract) return;

		$row = $plugin->process();
	}
}