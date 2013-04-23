<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Model_Main_Input_Files_View_List
{
	/**
	 * Объект вида
	 * @var MLib_Viewer
	 */
	protected $_view;

	public function __construct()
	{
		$this->_view = MLib_Viewer::instance();
	}

	/**
	 * Получение HTML списка загруженных файлов
	 * @return string
	 */
	public function get()
	{
		$model_storage = new Model_Main_Input_Files_Storage();

		$this->_view->assign('uploaded_files', $model_storage->getFileList());
		return $this->_view->fetch('main/files/list.tpl');
	}
}