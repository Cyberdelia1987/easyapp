<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Controller_Main_Decompose extends MLib_Controller_Frontend
{
	public function index()
	{
		$this->view->assign('lala', 'tralalalalaee');
		$this->view->display('decompose/index.tpl');
	}

	public function upload()
	{
		$file_field = 'data_file';
		$file_specs = setif($_FILES, $file_field);

		if (!$file_specs)
		{
			return MLib_Ajax::getInstance()->setException(new MLib_Exception_BadUsage('No file specified'));
		}

		$file_path_from = $file_specs['tmp_name'];
		$model = new Model_Main_Input_Files_Parse($file_path_from);
		try
		{
			$data = $model->parse();
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::getInstance()->setException($ex);
		}

		$model_storage = new Model_Main_Input_Files_Storage();
		$model_storage->save($file_specs['name'], $data);

		MLib_Router_Uri::redirect();
		return MLib_Ajax::getInstance()->setSuccess('It\'s OK');
	}
}