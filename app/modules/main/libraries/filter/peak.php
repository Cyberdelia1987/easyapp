<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Lib_Main_Filter_Peak extends Lib_Main_Filter_Abstract
{
	protected $_points;

	public function __construct(array $params = null)
	{
		$this->_points = setif($params, 'points', 3);
	}

	/**
	 * Абстрактный метод, обязательный для всех фильтров
	 * @param array $data      - Массив данных, которые нужно отфильтровать
	 * @param array $params    - Массив параметров фильтрации
	 * @return array
	 */
	public function filter(array $data, array $params = null)
	{

	}
}