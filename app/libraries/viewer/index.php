<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
include_once(PROJECT_BASE_PATH.'external/smarty/Smarty.class.php');

class MLib_Viewer extends Smarty implements MLib_Base_Singleton_Interface
{
	/**
	 * @var MLib_Viewer
	 */
	static protected $_viewer;

	/**
	 * Массив сохранённых шаблонов
	 * @var array
	 */
	protected $_saved_templates = array();

	/**
	 * Использованные ID шаблонов
	 * @var array
	 */
	protected $_used_template_ids = array();

	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		$this->setCacheDir(APP_PATH.'cache/smarty/cache/')
			->setTemplateDir(APP_PATH.'view/')
			->setCompileDir(APP_PATH.'cache/smarty/compile/');

		//$this->caching = 1;
		$this->compile_check = true;
		$this->muteExpectedErrors();
	}

	/**
	 * @return MLib_Viewer
	 */
	static public function instance()
	{
		if (static::$_viewer === null)
		{
			static::$_viewer = new static();
		}

		return static::$_viewer;
	}

	/**
	 * @param $path
	 */
	/*public function view($path)
	{
		echo($this->fetch($path));
	}*/

	/**
	 * Метод установки шаблона в стек для отображения
	 * @param string $resource_name
	 * @param array $params holds params that will be passed to the template
	 * @return boolean
	 */
	public function view($resource_name, $params = array())
	{
		if (strpos($resource_name, '.') === false)
		{
			$resource_name .= '.tpl';
		}

		if (is_array($params) && count($params))
		{
			foreach ($params as $key => $value)
			{
				$this->assign($key, $value);
			}
		}

		// check if the template file exists.
		/*if (!is_file($this->getTemplateDir().$resource_name))
		{
			die ('Smarty template: ['.$resource_name.'] cannot be found.');
		}*/

		$this->_saved_templates[] = $resource_name;
		return true;
	}

	/**
	 * Метод вывода всех созранённых шаблонов
	 * @return void
	 */
	public function viewAll()
	{
		if (!sizeof($this->_saved_templates)) return;

		$tpls = array();
		foreach ($this->_saved_templates as $key => $tpl)
		{
			if (in_array($key, $this->_used_template_ids)) continue;

			$tpls[] = $tpl;
		}

		$this->_used_template_ids = array_merge($this->_used_template_ids, array_keys($this->_saved_templates));

		foreach ($tpls as $key => $tpl)
		{
			parent::display($tpl);
		}
	}
}