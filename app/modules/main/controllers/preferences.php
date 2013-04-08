<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Controller_Main_Preferences extends MLib_Controller_Frontend
{
	/**
	 * Получение настроек
	 */
	public function get()
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
	public function set()
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