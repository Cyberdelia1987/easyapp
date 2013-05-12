<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
abstract class Lib_Main_Filter_Abstract
{
	public function __construct(array $params = null)
	{}

	/**
	 * Абстрактный метод, обязательный для всех фильтров
	 * @param array $data	- Массив данных, которые нужно отфильтровать
	 * @return array
	 */
	abstract public function filter(array $data);
}