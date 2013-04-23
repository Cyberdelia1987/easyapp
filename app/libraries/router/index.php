<?php
/**
 * Author: Alexandr Sibov aka "Cyber"
 * Created: 08.10.12 23:52
 */
class MLib_Router extends MLib_Base_Singleton
{
	/**
	 * Сегменты строки запроса (без учета _GET-параметров)
	 * @var array
	 */
	protected $_segments = array();

	/**
	 * @var array
	 */
	protected $_route = array(
		'model'			=> 'main',
		'controller'	=> 'index',
		'action'		=> 'index'
	);

	/**
	 * @var array
	 */
	protected $_right_segments = array();

	/**
	 *
	 */
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
	 *
	 */
	public function route()
	{
		$segments = $this->_segments;

		/**
		 * Попытка определить медель и контроллер
		 */
		if (sizeof($segments) > 0)
		{
			$segment = reset($segments);
			$controller_name = 'Controller_'.ucfirst($this->_route['model']).'_'.ucfirst($segment);

			if (module_exists($segment))
			{
				$this->_route['model'] = $segment;
				array_shift($segments);
			}
			elseif (class_exists($controller_name))
			{
				$this->_route['controller'] = $segment;
				array_shift($segments);
			}
		}

		/**
		 * Попытка определить метод контроллера, который нужно вызвать
		 */
		if (sizeof($segments) > 0)
		{
			$segment = reset($segments);
			$controller_name = 'Controller_'.ucfirst($this->_route['model']).'_'.ucfirst($this->_route['controller']);

			if (class_exists($controller_name))
			{
				$controller = new $controller_name();
				if (method_exists($controller, $segment))
				{
					$this->_route['action'] = $segment;
					array_shift($segments);
				}
			}
		}

		$this->_right_segments = $segments;
		unset($segments, $segment);

		// Определение наличия класса контроллера в проекте
		$controller_name = 'Controller_'.ucfirst($this->_route['model']).'_'.ucfirst($this->_route['controller']);
		if (!class_exists($controller_name))
		{
			throw new MLib_Session_Exception_WrongArgument('Контроллер "'.$controller_name.'" не найден');
		}

		// Создание объекта коентроллера и проверка наличия у него необходимого метода
		$controller = new $controller_name();
		if (!method_exists($controller, $this->_route['action']))
		{
			throw new MLib_Exception_WrongArgument('Метод "'.$this->_route['action'].'" не найден в контроллере "'.$controller_name.'"');
		}

		// Вызов метода найденного контроллера
		call_user_func_array(array($controller, $this->_route['action']), $this->_right_segments);
	}

	/**
	 * Получение всех сегментов адреса
	 * @return array
	 */
	public function getSegments()
	{
		return $this->_segments;
	}

	/**
	 * Получение пути (модель|контроллер|действие)
	 * @return array
	 */
	public function getRoute()
	{
		return $this->_route;
	}

	/**
	 * Получение сегментов, которые находятся справа от сегментов модели/контроллера/представления
	 * @return array
	 */
	public function getRightSegments()
	{
		return $this->_right_segments;
	}

	public function getPath()
	{
		return '/'.implode('/', $this->getRoute()+$this->getRightSegments());
	}
}