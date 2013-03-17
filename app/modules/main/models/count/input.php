<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Model_Main_Count_Input
{
	/**
	 * Название файла
	 * @var string
	 */
	protected $_file_name = '';

	/**
	 * Массив объектов данных столбцов
	 * @var array
	 */
	protected $_series;

	public function __construct($file_name)
	{
		$this->_file_name = $file_name;
	}

	/**
	 * Отображение данных по столюцам
	 */
	public function display()
	{
		$this->_series = $this->_getObjectsArray();
	}

	/**
	 * Получение масива объектов столбцов данных
	 * @return mixed
	 */
	protected function _getObjectsArray()
	{
		$model_storage = new Model_Main_Input_Files_Storage();

		return unserialize($model_storage->getFileObject($this->_file_name)->read());
	}
}