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

	/**
	 *
	 */
	public function getProperties()
	{
		$model = new Model_Main_Decompose_Preferences();
		try
		{
			$str = $model->getList()->display();
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::getInstance()->setException($ex);
		}

		return MLib_Ajax::getInstance()->setSuccess($str);
	}

	/**
	 * Установка настроек
	 * @return bool
	 */
	public function setProperties()
	{
		$preferences = setif($_POST, 'preferences');
		if (!$preferences)
		{
			return MLib_Ajax::getInstance()->setError('Не удалось получить настройки');
		}

		$model = new Model_Main_Decompose_Preferences();

		try
		{
			$model->setPreferencesFile($preferences);
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::getInstance()->setException($ex);
		}

		return MLib_Ajax::getInstance()->setSuccess('Настройки успешно сохранены');
	}
}