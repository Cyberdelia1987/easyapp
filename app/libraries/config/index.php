<?php
/**
 * Alexandr Sibov aka Cyber (cyberdelia1987@gmail.com)
 * Дата создания: 07.10.12 1:11
 */
class MLib_Config
{
	/**
	 * Получение переменной из общего конфига
	 * @param        $variable
	 * @param string $file
	 * @return mixed
	 */
	static public function getMain($variable, $file = 'config')
	{
		$file_path = APP_PATH.'config'.DS.$file.'.php';

		return self::_getVar($file_path, $variable);
	}

	/**
	 * Получение переменной из конфига модуля
	 * @param string $module
	 * @param string $variable
	 * @param string $file
	 * @return mixed
	 */
	static public function getModule($module, $variable, $file = 'config')
	{
		$file_path = APP_PATH.'modules'.DS.$module.DS.'config'.DS.$file.'.php';

		return self::_getVar($file_path, $variable);
	}

	/**
	 * @param $path
	 * @param $var
	 * @return mixed
	 */
	static protected function _getVar($path, $var)
	{
		if (!file_exists($path)) return false;

		include($path);
		$result = compact($var);

		if (!is_array($result) || !sizeof($result))
		{
			return false;
		}

		return (!is_array($var)) ? $result[$var] : $result;
	}
}