<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Model_Main_Count_Mode
{
	/**
	 * Получение модели для обработки каждого шага
	 * @return Model_Main_Count_Step_Automatic|Model_Main_Count_Step_Manual
	 * @throws MLib_Exception_WrongArgument
	 */
	static public function getStepModel()
	{
		switch (self::_getMode())
		{
			case 'manual' :
				return new Model_Main_Count_Step_Manual();
				break;
			case 'automatic' :
				return new Model_Main_Count_Step_Automatic();
				break;
			default :
				throw new MLib_Exception_WrongArgument('Неверный режим работы программы. Ожидается automatic|manual, передан: "'.self::_getMode().'"');
		}
	}

	/**
	 * Получение модели обработки обратных шагов
	 * @return Model_Main_Count_Revert_Automatic|Model_Main_Count_Revert_Manual
	 * @throws MLib_Exception_WrongArgument
	 */
	static public function getRevertModel()
	{
		switch (self::_getMode())
		{
			case 'manual' :
				return new Model_Main_Count_Revert_Manual();
				break;
			case 'automatic' :
				return new Model_Main_Count_Revert_Automatic();
				break;
			default :
				throw new MLib_Exception_WrongArgument('Неверный режим работы программы. Ожидается automatic|manual, передан: "'.self::_getMode().'"');
		}
	}

	/**
	 * Получение режима работы программы
	 * @return string
	 */
	static protected function _getMode()
	{
		return MLib_Session::instance()->get('preferences.manual_mode') ? 'manual' : 'automatic';
	}
}