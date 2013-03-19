<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Model_Main_Decompose_Preferences
{
	/**
	 * Массив конфига
	 * @var array
	 */
	protected $_config;

	/**
	 * имя файлов настроек в кеше
	 * @var string
	 */
	protected $_preferences_file_name = 'decompose_preferences.json';

	public function __construct()
	{
		$this->_config = MLib_Config::getModule('main', 'properties');
		$this->_config = $this->getConfigFromSavedPreferences();
	}

	/**
	 * Подстановка в конфиг настроек из прочитанного файла
	 * @return array|mixed
	 */
	public function getConfigFromSavedPreferences()
	{
		$cache_obj = new MLib_Cache('main');
		$cached = $cache_obj->readFile($this->_preferences_file_name, true);

		if (!is_array($cached)) return $this->_config;

		$tmp = $this->_config;

		foreach ($tmp as $var => $value)
		{
			if (isset($cached[$var]))
			{
				$tmp[$var]['value'] = $cached[$var];
			}
		}

		return $tmp;
	}

	/**
	 * Запись настроек в файл
	 * @param array $data
	 * @return int
	 */
	public function setPreferencesFile(array $data)
	{
		$cache_obj = new MLib_Cache('main');

		$tmp = array();

		foreach ($this->_config as $var => $value)
		{
			if (isset($data[$var]))
			{
				$tmp[$var] = $data[$var];
			}
		}

		return $cache_obj->writeFile($this->_preferences_file_name, $tmp, true);
	}

	/**
	 * Получение списка объектов полей формы настройки
	 * @return Lib_Main_Preferences_List
	 */
	public function getList()
	{
		return new Lib_Main_Preferences_List($this->_config);
	}
}