<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Lib_Main_Preferences_Item_Select extends Lib_Main_Preferences_Item_Abstract
{
	protected $_type = 'select';

	protected $_name;
	protected $_config = array(
		'label'		=> '',
		'value'		=> '',
		'options'	=> array()
	);

	public function __construct($name, array $config)
	{
		if (!is_array($config))
		{
			throw new MLib_Exception_BadUsage('Передан неверный массив конфига');
		}

		$this->_name = $name;
		$this->_config = array_merge($this->_config, $config);
	}
}