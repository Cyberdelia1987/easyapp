<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class MLib_Controller_Frontend
{
	/**
	 * @var MLib_Viewer
	 */
	public $view;

	/**
	 * @var mixed
	 */
	public $session;

	public function __construct()
	{
		$this->session = MLib_Session::getInstance();
		$this->session->start();
		$this->view = MLib_Viewer::getInstance();
	}
}