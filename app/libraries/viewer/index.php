<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
include_once(PROJECT_BASE_PATH.'external/smarty/Smarty.class.php');

class MLib_Viewer extends Smarty
{
	/**
	 * @var MLib_Viewer
	 */
	static protected $_viewer;

	public function __construct()
	{
		parent::__construct();

		$this->setCacheDir(APP_PATH.'cache/smarty/cache/')
			->setTemplateDir(APP_PATH.'view/')
			->setCompileDir(APP_PATH.'cache/smarty/compile/');
	}

	/**
	 * @return MLib_Viewer
	 */
	static public function getInstance()
	{
		if (!static::$_viewer)
		{
			static::$_viewer = new static();
		}

		return static::$_viewer;
	}

	/**
	 * @param $path
	 */
	public function view($path)
	{
		echo($this->getInstance()->fetch($path));
	}
}