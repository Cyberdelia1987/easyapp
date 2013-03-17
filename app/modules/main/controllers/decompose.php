<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Controller_Main_Decompose extends MLib_Controller_Frontend
{
	public function index($file_name = false)
	{
		if (!$file_name)
		{
			MLib_Router_Uri::redirect();
		}

		$file_name = urldecode($file_name);

		$model = new Model_Main_Count_Input($file_name);

		$this->view->assign('model_count_main', $model);
		$this->view->display('decompose/index.tpl');
	}
}