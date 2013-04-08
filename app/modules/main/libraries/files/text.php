<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Lib_Main_Files_Text
{
	protected $_file_path;

	public function __construct($file_path)
	{
		$this->_file_path = $file_path;
	}

	/**
	 * @return int
	 */
	public function read()
	{
		return file_get_contents($this->_file_path);
	}
}