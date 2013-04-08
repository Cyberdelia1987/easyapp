<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Lib_Main_Serie_List extends Lib_Main_ArrayAccess
{
	/**
	 * Объект значений по оси X
	 * @var Lib_Main_Serie_XAxis
	 */
	protected $_xaxis;

	/**
	 * Установка объекта значений по оси X
	 * @param Lib_Main_Serie_XAxis $xaxis
	 * @throws MLib_Exception_BadUsage
	 * @return $this
	 */
	public function setXAxis(Lib_Main_Serie_XAxis $xaxis)
	{
		if (!$xaxis instanceof Lib_Main_Serie_XAxis)
		{
			throw new MLib_Exception_BadUsage('Передан неверный объект оси X');
		}

		$this->_xaxis = $xaxis;
		return $this;
	}

	/**
	 * Возвращает объект значений по оси X
	 * @return Lib_Main_Serie_XAxis
	 */
	public function getXAxis()
	{
		return $this->_xaxis;
	}
}