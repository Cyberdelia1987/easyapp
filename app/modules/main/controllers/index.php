<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Controller_Main_Index extends MLib_Controller_Frontend
{
	/**
	 * Отображение стартовой страницы. Ничего лишнего
	 */
	public function index()
	{
		$this->view->assign('list_model', new Model_Main_Input_Files_View_List());
		$this->view->display('main/index.tpl');
	}

	/**
	 * Действие загрузки файла
	 * @return bool
	 */
	public function uploadFile()
	{
		$file_field = 'data_file';
		$file_specs = setif($_FILES, $file_field);

		if (!$file_specs || $file_specs && empty($file_specs['name']))
		{
			return MLib_Ajax::getInstance()->setException(new MLib_Exception_BadUsage('Не передан файл для загрузки. Выберите корректный файл для загрузки'));
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

		$list_model = new Model_Main_Input_Files_View_List();

		return MLib_Ajax::getInstance()->setSuccess(array(
			'message'	=> 'Файл успешно загружен',
			'list'		=> $list_model->get()
		));
	}

	/**
	 * Действие удаления файла
	 * @param $file_name
	 */
	public function removeFile($file_name)
	{
		$model = new Model_Main_Input_Files_Storage();

		try
		{
			$model->remove($file_name);
		}
		catch (MLib_Exception_Abstract $ex)
		{
			MLib_Ajax::getInstance()->setException($ex);
		}

		$list_model = new Model_Main_Input_Files_View_List();
		MLib_Ajax::getInstance()->setSuccess(array(
			'message'	=> 'Файл успешно удален',
			'list'		=> $list_model->get()
		));
	}
}