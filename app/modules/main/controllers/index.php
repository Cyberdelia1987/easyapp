<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Controller_Main_Index extends MLib_Controller_Frontend
{
	public function index()
	{
		$this->view->display('main/index.tpl');
	}
}