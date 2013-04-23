<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Lib_Main_Preferences_List extends Lib_Main_ArrayAccess
{
	public function __construct(array $config)
	{
		$this->_prepareList($config);
	}

	/**
	 * Подготовка списка объектов полей настроек
	 * @param array $config
	 * @throws MLib_Exception_WrongArgument
	 */
	protected function _prepareList(array $config)
	{
		foreach ($config as $item_name => $item_config)
		{
			$item_type = setif($item_config, 'type');

			$class_name = 'Lib_Main_Preferences_Item_'.ucfirst($item_type);
			if (!class_exists($class_name))
			{
				throw new MLib_Exception_WrongArgument('Указан неверный тип объекта: "'.$item_type.'"');
			}
			$this->_data[] = new $class_name($item_name, $item_config);
		}
	}

	/**
	 * Получение подготовленной HTML-строки с кодом формы
	 * @return string
	 */
	public function display()
	{
		/**
		 * @var Lib_Main_Preferences_Item_Abstract $preference_field_object
		 */
		$form_fields = '';

		foreach ($this->_data as $preference_field_object)
		{
			$form_fields .= $preference_field_object->display();
		}

		MLib_Viewer::instance()->assign('form_fields', $form_fields);
		return MLib_Viewer::instance()->fetch('decompose/view/preferences.tpl');
	}
}