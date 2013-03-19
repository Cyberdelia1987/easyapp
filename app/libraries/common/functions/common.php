<?php
/**
 * Alexandr Sibov aka Cyber (cyberdelia1987@gmail.com)
 * Дата создания: 06.10.12 14:40
 */

/**
 * Удобная обертка для isset
 * @param array|mixed  $array
 * @param string $elem
 * @param bool   $default
 * @return bool
 */
function setif($array, $elem = '', $default = false)
{
	return isset($array[$elem]) ? $array[$elem] : $default;
}

/**
 * Метод получения первого элемента массива
 * @param array $array
 * @return mixed|bool
 */
function first(array $array)
{
	if (is_array($array) && sizeof($array) > 0)
	{
		foreach ($array as $value)
		{
			return $value;
		}
	}
	return false;
}

/**
 * var_dump в pre
 */
function vre()
{
	$args = func_get_args();

	echo '<pre>';
	if (sizeof($args))
	{
		foreach ($args as $arg)
		{
			var_dump($arg);
		}
	}
	echo '</pre>';
}

/**
 * var_dump в pre с die()
 */
function vred()
{
	$args = func_get_args();

	echo '<pre>';
	if (sizeof($args))
	{
		foreach ($args as $arg)
		{
			var_dump($arg);
		}
	}
	echo '</pre>';
	die;
}

/**
 * Проверка ан то, что модуль существует
 * @param $module_name
 * @return bool
 */
function module_exists($module_name)
{
	$path = APP_PATH.'modules'.DS.$module_name.DS;
	if (is_dir($path)) return true;
	return false;
}