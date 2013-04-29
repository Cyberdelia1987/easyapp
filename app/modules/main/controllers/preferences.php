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
		$model = Model_Main_Decompose_Preferences::instance();
		try
		{
			$str = $model->getList()->display();
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::instance()->setException($ex);
		}

		return MLib_Ajax::instance()->setSuccess($str);
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
			return MLib_Ajax::instance()->setError('Не удалось получить настройки');
		}

		$model = Model_Main_Decompose_Preferences::instance();

		try
		{
			$model->setPreferencesFile($preferences);
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::instance()->setException($ex);
		}

		return MLib_Ajax::instance()->setSuccess('Настройки успешно сохранены');
	}

	/**
	 * Переключение состояния режима (ручной/автоматический)
	 * @return bool
	 */
	public function switchMode()
	{
		$manual = setif($_POST, 'manual_mode_switcher');

		MLib_Session::instance()->set('preferences.manual_mode', $manual);
		return MLib_Ajax::instance()->setSuccess($manual > 0 ? 'Состояние переключено на ручной режим' : 'Состояние переключено на автоматический режим');
	}
}