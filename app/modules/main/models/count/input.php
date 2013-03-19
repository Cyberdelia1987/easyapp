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
	 * @var Lib_Main_Serie_List
	 */
	protected $_series_list;

	/**
	 * @var MLib_Viewer
	 */
	protected $_view;

	public function __construct($file_name)
	{
		$this->_file_name = $file_name;
		$this->_view = MLib_Viewer::getInstance();
	}

	/**
	 * Отображение данных по столюцам
	 */
	public function display()
	{
		$this->_series_list = $this->_getObjectsArray();
		$this->_prepareJson();

		$this->_view->assign('series_list', $this->_series_list);

		return $this->_view->fetch('decompose/view_main.tpl');
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

	/**
	 * @return string
	 */
	protected function _prepareJson()
	{
		$tmp = array();

		$tmp['xAxis'] = array(
			'caption'	=> $this->_series_list->getXAxis()->getCaption(),
			'data'		=> $this->_series_list->getXAxis()->toArray()
		);
		$tmp['series'] = array();

		/**
		 * @var Lib_Main_Serie $serie
		 */
		foreach ($this->_series_list->toArray() as $serie)
		{
			$tmp['series'][] = array(
				'caption'	=> $serie->getCaption(),
				'data'		=> $serie->toArray()
			);
		}

		$this->_view->assign('chart_data',	json_encode($tmp));
	}
}