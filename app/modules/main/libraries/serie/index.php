<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Lib_Main_Serie extends Lib_Main_ArrayAccess
{
	/**
	 * Заголовок столбца
	 * @var string
	 */
	protected $_caption = '';

	/**
	 * Объект-делимое
	 * @var Lib_Main_Serie|null
	 */
	protected $_numerator = null;

	/**
	 * Объект-делитель
	 * @var Lib_Main_Serie|null
	 */
	protected $_denominator = null;

	/**
	 * Массив линейных участков столбца данных
	 * @var array|null
	 */
	protected $_linear_parts = null;

	/**
	 * @var Lib_Main_Serie_List|Lib_Main_Serie[]
	 */
	protected $_list;

	/**
	 * Конструктор
	 * @param null $data
	 */
	public function __construct($data = null)
	{
		if ($data !== null)
		{
			$this->_data = $data;
		}
	}

	/**
	 * @param Lib_Main_Serie_List $list
	 * @return $this
	 */
	public function setList(Lib_Main_Serie_List $list)
	{
		$this->_list = $list;
		return $this;
	}

	/**
	 * Установка данных
	 * @param array $data
	 */
	public function setData(array $data)
	{
		$this->_data = $data;
	}

	/**
	 * Реверс внутреннего массива данных
	 */
	public function reverse()
	{
		$this->_data = array_reverse($this->_data);
	}

	/**
	 * Установка заголовка толбцу данных
	 * @param $caption
	 * @throws MLib_Exception_WrongArgument
	 * @return $this
	 */
	public function setCaption($caption)
	{
		if (!is_string($caption))
		{
			throw new MLib_Exception_WrongArgument('Кто такой умный, что решил в заголовок столбца передать не строку?');
		}

		$this->_caption = $caption;
		return $this;
	}

	/**
	 * Получение заголовка столбца
	 * @return string
	 */
	public function getCaption()
	{
		return $this->_caption;
	}

	/**
	 * Установка объекта-делимого
	 * @param Lib_Main_Serie $serie
	 * @throws MLib_Exception_BadUsage
	 * @return $this
	 */
	public function setNumerator(Lib_Main_Serie $serie)
	{
		if (!$serie instanceof Lib_Main_Serie)
		{
			throw new MLib_Exception_BadUsage('Передан неверный объект столбца даных');
		}

		$this->_numerator = $serie;
		return $this;
	}

	/**
	 * Получение объекта-делимого
	 * @return Lib_Main_Serie|null
	 */
	public function getNumerator()
	{
		return $this->_numerator;
	}

	/**
	 * Установка объекта-делителя
	 * @param Lib_Main_Serie $serie
	 * @throws MLib_Exception_BadUsage
	 * @return $this
	 */
	public function setDenominator(Lib_Main_Serie $serie)
	{
		if (!$serie instanceof Lib_Main_Serie)
		{
			throw new MLib_Exception_BadUsage('Передан неверный объект столбца даных');
		}

		$this->_denominator = $serie;
		return $this;
	}

	/**
	 * Получение объекта-делителя
	 * @return Lib_Main_Serie|null
	 */
	public function getDenominator()
	{
		return $this->_denominator;
	}

	/**
	 * Деление объекта-делителя на объект-делимое и возврат объекта данных
	 * @throws MLib_Exception_BadUsage
	 * @throws MLib_Exception_WrongArgument
	 * @return $this
	 */

	public function divide()
	{
		if (sizeof($this->_numerator) != sizeof($this->_denominator))
		{
			throw new MLib_Exception_WrongArgument('Количество данных в делимом столбце не равно количеству данных в столбце-делителе');
		}

		$prev_value = $this->_denominator[0] == 0 ? 0 : round($this->_numerator[0] / $this->_denominator[0], 5);

		foreach ($this->_numerator as $key=>$value)
		{
			$tmp = $this->_denominator[$key] == 0 ? 0 : round($value / $this->_denominator[$key], 5);

			if (($prev_value == 0 ? 0 : abs(($tmp - $prev_value) / $prev_value)) > 50)
			{
				$tmp = $prev_value;
			}
			else
			{
				$prev_value = $tmp;
			}

			$this[] = $tmp;
		}

		return $this;
	}

	/**
	 * @param float $max_spread_percent
	 * @param int $max_dots_per_jump
	 * @return $this
	 */
	public function analyzeLineParts($max_spread_percent, $max_dots_per_jump)
	{
		$max_spread_percent = floatval($max_spread_percent);
		$max_dots_per_jump = intval($max_dots_per_jump);

		$spread = abs(max($this->_data) - min($this->_data));
		$max_spread = $spread * $max_spread_percent / 100 / 2;

		$line_parts = array();

		$tmp = array (
			'value'		=> reset($this->_data),
			'average'	=> reset($this->_data),
			'start'		=> 0,
			'end'		=> null,
			'count'		=> 0,
			'selected'	=> false
		);

		$jumped = 0;
		foreach ($this->_data as $key => $value)
		{
			if (abs($value - $tmp['value']) <= $max_spread)
			{
				$tmp['average'] = round(($value + $tmp['average']) / 2, 5);
				$tmp['end']		= $key;
				$tmp['count']++;
			}
			elseif ($jumped < $max_dots_per_jump)
			{
				$jumped++;
			}
			else
			{
				if ($tmp['count'] > $max_dots_per_jump)
				{
					$line_parts[] = $tmp;
				}

				$tmp = array(
					'value'		=> $value,
					'average'	=> $value,
					'start'		=> $key,
					'end'		=> null,
					'count'		=> 0,
					'selected'	=> false
				);
			}
		}

		if ($tmp['count'] > $max_dots_per_jump)
		{
			$line_parts[] = $tmp;
		}

		$line_parts = $this->_sortLinearParts($line_parts);
		$this->_linear_parts = $line_parts;
		$this->reselect();

		return $this;
	}

	/**
	 * Вычитание из числителя знаменателя, помноженного на значение самого длинного линейного коэффициента
	 * @return $this
	 */
	public function excludeDenominator()
	{
		$coef = $this->getLongestLinePartValue();

		foreach (array_keys($this->_data) as $key)
		{
			$this->_data[$key] = round($coef * $this->_denominator[$key] - $this->_numerator[$key], 5);
		}

		return $this;
	}

	/**
	 * Фильтровать результат
	 * @param Model_Main_Filter_Calman|bool $filter	- Использовать ли фильтр Калмана для фильтрации деления
	 * @return $this
	 */
	public function filter($filter = false)
	{
		if ($filter instanceof Lib_Main_Filter_Abstract)
		{
			$this->_data = $filter->filter($this->_data);
		}

		return $this;
	}

	/**
	 * Полуение линейных участков
	 * @return array|null
	 * @throws MLib_Exception_BadUsage
	 */
	public function getLineParts()
	{
		if ($this->_linear_parts === null)
		{
			throw new MLib_Exception_BadUsage('Сначала линейные участки надо рассчитать');
		}

		return $this->_linear_parts;
	}

	/**
	 * Метод установки массива линейных участков графику
	 * @param array $line_parts
	 */
	public function setLineParts(array $line_parts)
	{
		$this->_linear_parts = $line_parts;
	}

	/**
	 * @return bool
	 */
	public function hasLinearParts()
	{
		if (!is_null($this->_linear_parts))
		{
			return true;
		}
		return false;
	}

	/**
	 * Получение значения самого длинного участка
	 * @return bool
	 * @throws MLib_Exception_BadUsage
	 */
	public function getLongestLinePartValue()
	{
		/** @var Lib_Main_Serie $serie */
		if ($this->_linear_parts === null)
		{
			throw new MLib_Exception_BadUsage('Сначала линейные участки надо рассчитать');
		}

		if ($serie = setif($this->_list, 0))
		{
			foreach ($this->_linear_parts as $line_part)
			{
				if ($line_part['selected']) return $line_part['average'];
			}
		}

		return $this->_linear_parts[0]['average'];
	}

	/**
	 * Перераспределить автоматически выбранные линейные участки
	 */
	public function reselect()
	{
		/** @var Lib_Main_Serie $serie */
		if ($this->_linear_parts === null) return;

		if ($serie = setif($this->_list, 0))
		{
			$line_parts = $serie->getLineParts();

			$etalon = $line_parts[0];
			foreach ($this->_linear_parts as $key =>$line_part)
			{
				if (($line_part['start'] >= $etalon['start'] && $line_part['start'] <= $etalon['end']) || ($line_part['end'] >= $etalon['start'] && $line_part['end'] <= $etalon['end']))
				{
					$this->_linear_parts[$key]['selected'] = true;
					return;
				}
			}
		}

		$this->_linear_parts[0]['selected'] = true;
	}

	/**
	 * @return int
	 * @throws MLib_Exception_BadUsage
	 */
	public function getNextLinePartValue()
	{
		if ($this->_linear_parts === null)
		{
			throw new MLib_Exception_BadUsage('Сначала линейные участки надо рассчитать');
		}

		foreach ($this->_linear_parts as $val)
		{
			if ($val['selected'] == true) continue;
			return $val['average'];
		}

		return 1;
	}

	/**
	 * Сортировка по убыванию
	 * @param $line_parts
	 * @return mixed
	 */
	protected function _sortLinearParts($line_parts)
	{
		foreach (array_keys($line_parts) as $key1 )
		{
			foreach(array_keys($line_parts) as $key2)
			{
				if ($line_parts[$key1]['count'] > $line_parts[$key2]['count'])
				{
					$tmp = $line_parts[$key1];
					$line_parts[$key1] = $line_parts[$key2];
					$line_parts[$key2] = $tmp;
				}
			}
		}

		return $line_parts;
	}
}