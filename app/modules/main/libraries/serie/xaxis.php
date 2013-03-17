<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Lib_Main_Serie_XAxis extends Lib_Main_Serie
{
	/**
	 * Проверяет, если порядок следования значений по оси X - прямой или обратный
	 * @return bool
	 */
	public function isDIrectOrder()
	{
		if ($this->_data[0] < $this->_data[1]) return true;
		return false;
	}
}