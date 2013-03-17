<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
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

		foreach ($this->_numerator as $key=>$value)
		{
			$this[] = $value / $this->_denominator[$key];
		}

		return $this;
	}
}