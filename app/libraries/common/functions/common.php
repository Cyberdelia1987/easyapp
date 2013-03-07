<?php
/**
 * Alexandr Sibov aka Cyber (cyberdelia1987@gmail.com)
 * Дата создания: 06.10.12 14:40
 */

/**
 * Удобная обертка для isset
 * @param array  $array
 * @param string $elem
 * @param bool   $default
 * @return bool
 */
function setif(array $array, $elem = '', $default = false)
{
	return isset($array[$elem]) ? $array[$elem] : $default;
}

/**
 * Метод получения первого элемента массива
 * @param array $array
 * @return bool
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