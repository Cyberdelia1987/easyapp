<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class MLib_Router_Nav_Plugin_LastFile extends MLib_Router_Nav_Plugin_Abstract
{
	public function process()
	{
		$last_file_name = MLib_Session::instance()->get('last_file_name');

		$this->_row['url'] = $last_file_name ? '/decompose/'.$last_file_name : '/';
		return $this->_row;
	}
}