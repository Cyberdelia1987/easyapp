<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Lib_Main_Preferences_Item_Abstract
{
	protected $_name;
	protected $_config = array(
		'label'	=> '',
		'value'	=> ''
	);

	protected $_type = '';

	public function __construct($name, array $config)
	{
		if (!is_array($config))
		{
			throw new MLib_Exception_BadUsage('Передан неверный массив конфига');
		}

		$this->_name = $name;
		$this->_config = array_merge($this->_config, $config);
	}

	/**
	 * @return string
	 */
	public function display()
	{
		MLib_Viewer::getInstance()->assign('pref_name', $this->_name);
		MLib_Viewer::getInstance()->assign('pref_config', $this->_config);
		return MLib_Viewer::getInstance()->fetch('decompose/view/preferences/item/'.$this->_type.'.tpl');
	}
}