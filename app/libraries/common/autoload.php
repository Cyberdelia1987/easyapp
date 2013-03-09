<?php
/**
 * Alexandr Sibov aka Cyber (cyberdelia1987@gmail.com)
 * Дата создания: 06.10.12 14:25
 */
spl_autoload_register(array('Autoloader', 'loadClass'));

class Autoloader
{
	protected static $_file_path;

	protected static $_reserved_names = array(
		'config',
		'fasade',
		'libraries',
		'models',
		'controller'
	);

	public static function loadClass($class_name)
	{
		if (class_exists($class_name))
		{
			return true;
		}

		self::$_file_path = PROJECT_BASE_PATH;

		$class_path = explode('_', $class_name);

		if (!is_array($class_path) || empty($class_path)) return false;

		$class_type = array_shift($class_path);

		switch ($class_type)
		{
			case 'MLib' :
				self::_includeMainLib($class_path);
				break;
			case 'MModel' :
				self::_includeMainModel($class_path);
				break;
			case 'Lib' :
				self::_includeModelLib($class_path);
				break;
			case 'Model' :
				self::_includeModuleModel($class_path);
				break;
			case 'Fasade' :
				self::_includeModuleFasade($class_path);
				break;
			case 'Routine' :
				self::_includeModuleRoutine($class_path);
				break;
			case 'Controller' :
				self::_includeModuleController($class_path);
				break;
			default :
				return false;
		}

		$file_path = self::$_file_path.implode('/', array_map('strtolower', $class_path)).'.php';

		if (is_file($file_path) && is_readable($file_path))
		{
			require_once($file_path);
			spl_autoload($class_name);
			return true;
		}

		$file_path = self::$_file_path.implode('/', array_map('strtolower', $class_path)).'/index.php';
		if (is_file($file_path) && is_readable($file_path))
		{
			require_once($file_path);
			spl_autoload($class_name);
			return true;
		}

		return false;
	}

	/**
	 * Подгрузка основных библиотек
	 * @param $path_array
	 */
	protected static function _includeMainLib(&$path_array)
	{
		self::$_file_path .= 'app/libraries/';
	}

	/**
	 * Подгрузка основных моделей
	 * @param $path_array
	 */
	protected static function _includeMainModel(&$path_array)
	{
		self::$_file_path .= 'app/models/';
	}

	/**
	 * Подключение папки модуля
	 * @param $path_array
	 * @return bool
	 */
	protected static function _includeModule(&$path_array)
	{
		self::$_file_path .= 'app/modules/';
		if (!is_array($path_array) && !empty($path_array)) return false;

		$module_name = strtolower(array_shift($path_array));
		self::$_file_path .= $module_name.'/';

		$submodule_path = strtolower(first($path_array));

		if (is_dir(self::$_file_path.$submodule_path.'/') && !in_array($submodule_path, self::$_reserved_names))
		{
			array_shift($path_array);
			self::$_file_path .= $submodule_path.'/';
		}
		return true;
	}

	/**
	 * Подгрузка библиотек модуля
	 * @param $path_array
	 * @return bool
	 */
	protected static function _includeModelLib(&$path_array)
	{
		self::_includeModule($path_array);
		self::$_file_path .= 'libraries/';
	}

	/**
	 * Подгрузка моделей модуля
	 * @param $path_array
	 * @return bool
	 */
	protected static function _includeModuleModel(&$path_array)
	{
		self::_includeModule($path_array);
		self::$_file_path .= 'models/';
	}

	/**
	 * Подгрузка фасадов модуля
	 * @param $path_array
	 * @return bool
	 */
	protected static function _includeModuleFasade(&$path_array)
	{
		self::_includeModule($path_array);
		self::$_file_path .= 'fasade/';
	}

	protected static function _includeModuleRoutine(&$path_array)
	{
		self::_includeModule($path_array);
		self::$_file_path .= 'routines/';
	}

	/**
	 * @param $path_array
	 */
	protected static function _includeModuleController(&$path_array)
	{
		self::_includeModule($path_array);
		self::$_file_path .= 'controllers/';
	}
}