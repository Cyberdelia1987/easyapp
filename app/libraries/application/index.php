<?php
/**
 * Alexandr Sibov aka Cyber (cyberdelia1987@gmail.com)
 * Дата создания: 07.10.12 1:07
 */
class MLib_Application extends MLib_Base_Singleton
{
	/**
	 * @TODO: вынести обработку ошибок в отдельный класс
	 */
	public function run()
	{
		try
		{
			// Запускаем сессию
			MLib_Session::instance()->start();
			// Запускаем маршрутизацию
			MLib_Router::instance()->route();
			// Обработка вывода AJAX-данных, если инициализировались
			MLib_Ajax::instance()->display();
		}
		catch(Exception $ex)
		{
			echo 'Код ошибки: '.$ex->getCode().'<br/>';
			echo 'Текст ошибки: '.$ex->getMessage().'</br>';
			echo '<br/>';
			echo 'Бэктрейс:<br/>';
			vred($ex->getTraceAsString());
		}
	}
}