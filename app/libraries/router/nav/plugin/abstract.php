<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
abstract class MLib_Router_Nav_Plugin_Abstract
{
	protected $_row;

	public function __construct($config_row)
	{
		$this->_row = $config_row;
	}

	public function process()
	{
		return $this->_row;
	}
}