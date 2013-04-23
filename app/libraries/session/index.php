<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class MLib_Session extends MLib_Base_Singleton
{

	protected $_is_started = false;

	/**
	 * Инициализация сессии
	 */
	public function start()
	{
		$this->_is_started = session_start();
	}

	/**
	 * Получение состояния инициализации сессии
	 * @return bool
	 */
	public function isStarted()
	{
		return $this->_is_started;
	}

	/**
	 * Установка значения в сессии по ключу
	 * Ключ может быть многоуровневым. Уровни разделяются знаком '.'
	 * Разрешенные символы в названии ключа - [a-zA-Z0-9_-]
	 * @param $index
	 * @param $value
	 */
	public function set($index, $value)
	{
		$index_array = $this->_prepareIndexArray($index);

		$session_elem = &$_SESSION;

		foreach ($index_array as $key => $index)
		{
			if ($key == sizeof($index_array) - 1) break;

			$this->_checkIndex($index);

			if (!isset($session_elem[$index]))
			{
				$session_elem[$index] = array();
			}
			$session_elem = &$session_elem[$index];
		}

		$session_elem[$index] = $value;
	}

	/**
	 * Получение значения из сессии по ключу
	 * Ключ может быть многоуровневым. Уровни разделяются знаком '.'
	 * Разрешенные символы в названии ключа - [a-zA-Z0-9_-]
	 * @param $index
	 * @return mixed
	 */
	public function get($index)
	{
		$index_array = $this->_prepareIndexArray($index);

		$session_elem = &$_SESSION;

		foreach ($index_array as $index)
		{
			$this->_checkIndex($index);
			if (!isset($session_elem[$index])) return false;
			$session_elem = &$session_elem[$index];
		}

		return $session_elem;
	}

	/**
	 * Удаление записи из сессии под определенным индексом
	 * @param $index
	 * @return bool
	 */
	public function remove($index)
	{
		$index_array = $this->_prepareIndexArray($index);

		$session_elem = &$_SESSION;

		foreach ($index_array as $key => $index)
		{
			if ($key == sizeof($index_array) - 1) break;
			$this->_checkIndex($index);
			if (!isset($session_elem[$index])) return false;
			$session_elem = &$session_elem[$index];
		}

		if (!isset($session_elem[$index])) return false;

		unset ($session_elem[$index]);
		return true;
	}

	/**
	 * Очистка массива сессии
	 * @return bool
	 */
	public function clear()
	{
		$_SESSION = array();
		return true;
	}

	/**
	 * Подготовка массива индексов для разборки
	 * @param $index
	 * @return array
	 * @throws MLib_Session_Exception_BasUsage
	 */
	protected function _prepareIndexArray($index)
	{
		if (!is_string($index))
		{
			throw new MLib_Session_Exception_BasUsage('Индекс поля сессии должен быть строкой!');
		}

		$index = trim($index, ' .');

		if (strpos($index, '.'))
		{
			$index_array = explode('.', $index);
		}
		else
		{
			$index_array = array($index);
		}

		return $index_array;
	}

	/**
	 * Проверка индекса на паттерн. Если не соответствует - бросаем эксепшн
	 * @param $index
	 * @throws MLib_Session_Exception_WrongArgument
	 */
	protected function _checkIndex($index)
	{
		if (!preg_match('/^[a-zA-Z0-9_-]*$/', $index))
		{
			throw new MLib_Session_Exception_WrongArgument('Ключ не соответствует паттерну: "'.$index.'"');
		}
	}
}