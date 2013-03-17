<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Lib_Main_ArrayAccess implements ArrayAccess
{
	/**
	 * Данные столбца
	 * @var array|null
	 */
	protected $_data = array();

	/**
	 * Провекрка, если значение по ключу есть в массиве
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return isset($this->_data[$offset]);
	}

	/**
	 * Получение значения из массива по ключу
	 * @param mixed $offset
	 * @return bool|mixed
	 */
	public function offsetGet($offset)
	{
		return setif($this->_data, $offset, null);
	}

	/**Установка значения в массиве по ключу.
	 * Все устанавливаемые значения принудительно приводятся к вещественному числу
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value)
	{
		if (is_null($offset)) {
			$this->_data[] = $value;
		} else {
			$this->_data[$offset] = $value;
		}
	}

	/**
	 * Удаление из массива значения по ключу
	 * @param mixed $offset
	 */
	public function offsetUnset($offset)
	{
		unset($this->_data[$offset]);
	}
}