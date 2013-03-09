<?php
/**
 * Author: Alexandr Sibov aka "Cyber"
 * Created: 08.10.12 23:52
 */
class MLib_Router
{
	/**
	 * Инстанция маршрутизатора
	 * @var null
	 */
	static protected $_instance = null;

	/**
	 * Сегменты строки запроса (без учета _GET-параметров)
	 * @var array
	 */
	protected $_segments = array();

    protected function __construct()
    {
        $path = setif($_SERVER, 'REDIRECT_URL', '');
		$path = str_replace('\\', '/', $path);
		$this->_segments = explode('/', trim($path, ' /'));

		$segments = array();

		foreach($this->_segments as $value)
		{
			if ($value) $segments[] = $value;
		}

		$this->_segments = $segments;
    }

	/**
	 * Получение инстанции маршрутизатора
	 * @return MLib_Router
	 */
	static public function getInstance()
	{
		if (self::$_instance == null)
		{
			self::$_instance = new MLib_Router();
		}

		return self::$_instance;
	}

	/**
	 *
	 */
	public function route()
	{
		$module = 'main';
		$controller = 'index';
		$method = 'index';

		if (sizeof($this->_segments) > 0)
		{
			$module = $this->_segments[0];
		}

		if (sizeof($this->_segments) > 1)
		{
			$controller = $this->_segments[1];
		}

		if (sizeof($this->_segments) > 2)
		{
			$method = $this->_segments[2];
		}

		$controller_name = 'Controller_'.ucfirst($module).'_'.ucfirst($controller);

		if (!class_exists($controller_name))
		{
			throw new Exception('Контроллер "'.$controller_name.'" не существует');
		}

		$controller = new $controller_name();
		call_user_func_array(array($controller, $method), array());
	}

	/**
	 * @return array
	 */
	public function getSegments()
	{
		return $this->_segments;
	}

	final protected function __clone() {}
}