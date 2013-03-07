<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Controller_Decompose_Index extends MLib_Controller_Frontend
{
	public function index()
	{
		$this->view->assign('lala', 'tralalalalaee');
		$this->view->display('decompose/index.tpl');
	}

	public function result()
	{

	}
}