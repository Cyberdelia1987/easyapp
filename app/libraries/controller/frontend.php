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
		$this->view = MLib_Viewer::instance();
	}

	public function preCallMethod() {}

	public function postCallMethod()
	{
		$this->view->assign('topnav', MLib_Router_Nav::instance()->getTopNav());
	}
}