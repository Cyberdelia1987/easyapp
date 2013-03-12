<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Controller_Main_Index extends MLib_Controller_Frontend
{
	public function index()
	{
		$model_storage = new Model_Main_Input_Files_Storage();

		$this->view->assign('uploaded_files', $model_storage->getFileList());
		$this->view->display('main/index.tpl');
	}
}