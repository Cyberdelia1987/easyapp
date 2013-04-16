<?php
/**
 * Фильтр Савицкого-Голея
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Lib_Main_Filter_SavGolay extends Lib_Main_Filter_Abstract
{
	/**
	 * Матрица взвешенных коэффициентов (сверточных чисел)
	 * @var array
	 */
	protected $_matrix = array(
		5	=> array(
			0	=> 17,
			1	=> 12,
			2	=> -3
		),
		7	=> array(
			0	=> 7,
			1	=> 6,
			2	=> 3,
			3	=> 2
		),
		9	=> array(
			0	=> 59,
			1	=> 54,
			2	=> 39,
			3	=> 14,
			4	=> -21
		),
		11	=> array(
			0	=> 89,
			1	=> 84,
			2	=> 69,
			3	=> 44,
			4	=> 9,
			5	=> -36
		)
	);

	/**
	 * Количество точек для окна
	 * @var bool
	 */
	protected $_points;

	/**
	 * Конструктор
	 * @param array $params
	 */
	public function __construct(array $params = null)
	{
		$this->_points = setif($params, 'points', 5);
	}

	/**
	 * Абстрактный метод, обязательный для всех фильтров
	 * @param array $data    - Массив данных, которые нужно отфильтровать
	 * @return array
	 */
	public function filter(array $data)
	{
		$this->_validate();

		$mini = -$maxi = floor($this->_points / 2);

		$tmp = array();
		foreach ($data as $key => $value)
		{
			$topsum = 0;
			$botsum = 0;

			for ($i = $mini; $i <= $maxi; $i++)
			{
				$topsum += $this->_getCoef($i) * setif($data, ($key + $i), 0);
				$botsum += $this->_getCoef($i);
			}
			$tmp[] = $topsum / $botsum;
		}

		return $tmp;
	}

	/**
	 * Валидация количества точек
	 * @throws MLib_Exception_WrongArgument
	 */
	protected function _validate()
	{
		if (!in_array($this->_points, array_keys($this->_matrix)))
		{
			throw new MLib_Exception_WrongArgument('Передано неверное количество точек. Передано: '.$this->_points.', доступно: '.print_r(array_keys($this->_matrix), true));
		}
	}

	/**
	 * Получение коэффициента из набора взвешенных коэффициентов (сверточных чисел)
	 * @param $i
	 * @return bool
	 */
	protected function _getCoef($i)
	{
		return setif($this->_matrix[$this->_points], abs($i));
	}
}