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
		$this->_points = setif($params, 'points', 5);
	}

	/**
	 * Абстрактный метод, обязательный для всех фильтров
	 * @param array $data      - Массив данных, которые нужно отфильтровать
	 * @return array
	 */
	public function filter(array $data)
	{
		$points_before	= intval($this->_points/2);
		$points_after	= $this->_points - $points_before - $this->_points % 2;

		$max_idx = sizeof($data) - 1;

		foreach ($data as $key => $val)
		{
			$idx_start = $key - $points_before;
			if ($idx_start < 0) $idx_start = 0;

			$idx_end = $key + $points_after;
			if ($idx_end > $max_idx) $idx_end = $max_idx;

			$avg = 0;

			for ($i = $idx_start; $i <= $idx_end; $i++)
			{
				if ($i == $key) continue;
				$avg += $data[$i];
			}

			if (abs(($val - $avg) / $avg) > 20)
			{
				$data[$key] = $avg; 
			}
		}

		return $data;
	}
}