<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Lib_Main_ArrayAccess implements ArrayAccess, Iterator, Countable
{
	protected $_position = 0;
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

	/**
	 * Установка значения в массиве по ключу.
	 * Все устанавливаемые значения принудительно приводятся к вещественному числу
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value)
	{
		if (is_null($offset))
		{
			$this->_data[] = $value;
		}
		else
		{
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

	/**
	 * Возврат массива даных в "сыром" виде
	 * @return array|null
	 */
	public function toArray()
	{
		return $this->_data;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 */
	public function current()
	{
		return $this->_data[$this->_position];
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 */
	public function key()
	{
		return $this->_position;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next()
	{
		++$this->_position;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind()
	{
		$this->_position = 0;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 *       Returns true on success or false on failure.
	 */
	public function valid()
	{
		return isset($this->_data[$this->_position]);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Count elements of an object
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 *       The return value is cast to an integer.
	 */
	public function count()
	{
		return sizeof($this->_data);
	}
}