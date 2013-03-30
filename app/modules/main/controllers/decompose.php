<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Controller_Main_Decompose extends MLib_Controller_Frontend
{
	public function index($file_name = false)
	{
		if (!$file_name)
		{
			MLib_Router_Uri::redirect();
		}

		$file_name = urldecode($file_name);

		$model = new Model_Main_Count_Input($file_name);

		$this->view->assign('model_count_main', $model);
		$this->view->display('decompose/index.tpl');
	}

	/**
	 * @return bool
	 */
	public function getNext()
	{
		$model = new Model_Main_Count_Step();
		try
		{
			$html = $model->display();
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::getInstance()->setException($ex);
		}

		$this->view->assign('list', $model->getSeriesList());

		return MLib_Ajax::getInstance()->setSuccess(array(
			'message'		=> 'Данные шага вычисления #'.$model->getStep().' успешно получены',
			'html'			=> $html,
			'step'			=> $model->getStep(),
			'can_continue'	=> ($model->getSeriesCount() > 1) ? true : false,
			'log'			=> $this->view->fetch('decompose/view/log.tpl')
		));
	}

	/**
	 *
	 * @return bool
	 */
	public function getRevert()
	{
		$model = new Model_Main_Count_Revert();

		try
		{
			$html = $model->display();
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::getInstance()->setException($ex);
		}

		$this->view->assign('list', $model->getSeriesList());

		return MLib_Ajax::getInstance()->setSuccess(array(
			'message'		=> 'Данные шага вычисления #'.$model->getStep().' успешно получены',
			'html'			=> $html,
			'step'			=> $model->getStep(),
			'can_continue'	=> false
		));
	}
}