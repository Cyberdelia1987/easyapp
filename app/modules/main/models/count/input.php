<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Model_Main_Count_Input
{
	/**
	 * Название файла
	 * @var string
	 */
	protected $_file_name = '';

	/**
	 * Массив объектов данных рядов
	 * @var Lib_Main_Serie_List
	 */
	protected $_series_list;

	/**
	 * Инстанс вьюера
	 * @var MLib_Viewer
	 */
	protected $_view;

	/**
	 * Объект работы с сессией
	 * @var MLib_Session
	 */
	protected $_session;

	/**
	 * Ручной или автоматический режим
	 * @var bool
	 */
	protected $_manual_mode;

	/**
	 * Конструктор
	 * @param string $file_name
	 */
	public function __construct($file_name)
	{
		$this->_file_name = $file_name;
		$this->_view = MLib_Viewer::instance();
		$this->_session = MLib_Session::instance();
		$this->_manual_mode = (bool) MLib_Session::instance()->get('preferences.manual_mode');
	}

	/**
	 * Отображение данных по столюцам
	 */
	public function display()
	{
		$this->_series_list = $this->_getObjectsArray();
		$this->_prepareJson();
		$this->_saveToSession();

		$this->_view->assign('series_list', $this->_series_list);

		return $this->_view->fetch('decompose/view_main.tpl');
	}

	/**
	 * Сохранение объектов в сессию
	 */
	protected function _saveToSession()
	{
		$this->_session->remove('decompose');
		$this->_session->set('decompose.0', $this->_series_list);
	}

	/**
	 * Получение масива объектов рядов данных
	 * @return mixed
	 */
	protected function _getObjectsArray()
	{
		$model_storage = new Model_Main_Input_Files_Storage();

		if ($this->_session->get('last_file_name') == $this->_file_name)
		{
			return $this->_session->get('decompose.0');
		}

		$this->_session->set('last_file_name', $this->_file_name);

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