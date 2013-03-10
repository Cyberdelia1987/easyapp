<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Model_Main_Input_Files_Parse
{
	protected $_file_name;

	public function __construct($file_name)
	{
		$this->_file_name = $file_name;
	}

	/**
	 *
	 */
	public function parse()
	{
		$this->_validate();
		$data = $this->_parseToArray();
		return $this->_switchArrayToObjects($data);
	}

	/**
	 * @throws MLib_Exception_WrongArgument
	 */
	protected function _validate()
	{
		if (!file_exists($this->_file_name) || !is_readable($this->_file_name))
		{
			throw new MLib_Exception_WrongArgument('Файл не существует или нечитабелен');
		}
	}

	protected function _parseToArray()
	{
		$fp = fopen($this->_file_name, 'r');
		if (!$fp)
		{
			throw new MLib_Exception_BadUsage('Не удалось открыть файл для чтения');
		}

		$data = array();

		while (!feof($fp))
		{
			$line_array = fgetcsv($fp, 4096, '	');

			if (!is_array($line_array) || !sizeof($line_array)) continue;

			foreach($line_array as $key => $cell_value)
			{
				if (empty($cell_value))
				{
					unset($line_array[$key]);
				}
			}

			if (!sizeof($line_array)) continue;
			$data[] = $line_array;
		}
		unset($line_array);

		return $data;
	}

	/**
	 * Раскидываем все это дело по объектам:
	 * - Столбец значений длин волн (по оси X)
	 * - Столбцы значений по оси Y
	 * - Объект заголовков всего этого дела (хотя, может, каждый столбец будет иметь свой заголовок)
	 * @param $data
	 * @return array|bool
	 */
	protected function _switchArrayToObjects($data)
	{
		if (!sizeof($data)) return false;

		$captions = array_shift($data);

		$tmp = array();

		// Извлечение заголовков и создание объектов под каждый столбец с данными
		foreach ($captions as $key => $value)
		{
			$object = ($key == 0) ? new Lib_Main_Input_XAxis() : new Lib_Main_Input_Serie();
			$object->setCaption($value);

			$tmp[$key] = $object;
		}

		// Добавление данных в каждый объект
		foreach($data as $line)
		{
			foreach ($line as $key => $cell_value)
			{
				$object = $tmp[$key];
				$object[] = $cell_value;
			}
		}

		return array('xAxis' => array_shift($tmp), 'yAxis'	=> $tmp);
	}
}