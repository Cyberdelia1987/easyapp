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
	 * @return bool
	 */
	static public function getMain($variable, $file = 'config')
	{
		$file_path = APP_PATH.'config'.DS.$file.'.php';

		if (file_exists($file_path) && is_readable($file_path))
		{
			require_once($file_path);
			if (isset($$variable)) return $$variable;
		}

		return false;
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

		if (file_exists($file_path) && is_readable($file_path))
		{
			require_once($file_path);
			if (isset($$variable)) return $$variable;
		}

		return false;
	}
}