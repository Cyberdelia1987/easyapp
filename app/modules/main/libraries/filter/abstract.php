<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<sib@avantajprim.com>
 */
abstract class Lib_Main_Filter_Abstract
{
	public function __construct(array $params = null)
	{}

	/**
	 * Абстрактный метод, обязательный для всех фильтров
	 * @param array $data	- Массив данных, которые нужно отфильтровать
	 * @param array $params	- Массив параметров фильтрации
	 * @return array
	 */
	abstract public function filter(array $data, array $params = null);
}