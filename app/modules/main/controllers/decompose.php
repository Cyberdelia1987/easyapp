<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
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

		try
		{
			$display_data = $model->display();
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Router_Uri::redirect();
		}

		$this->view->assign('model_count_main', $model);
		$this->view->assign('display_data', $display_data);
		$this->view->assign('manual_mode', MLib_Session::instance()->get('preferences.manual_mode'));
		$this->view->view('decompose/index.tpl');
	}

	/**
	 * @return bool
	 */
	public function getNext()
	{
		$model = Model_Main_Count_Mode::getStepModel();
		try
		{
			$html = $model->display();
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::instance()->setException($ex);
		}

		$this->view->assign('list', $model->getSeriesList());
		//$this->view->assign('mediate_list', $model->getMediateList());

		return MLib_Ajax::instance()->setSuccess(array(
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
		$model = Model_Main_Count_Mode::getRevertModel();

		try
		{
			$html = $model->display();
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::instance()->setException($ex);
		}

		$this->view->assign('list', $model->getSeriesList());

		return MLib_Ajax::instance()->setSuccess(array(
			'message'		=> 'Данные шага вычисления #'.$model->getStep().' успешно получены',
			'html'			=> $html,
			'step'			=> $model->getStep(),
			'can_continue'	=> false
		));
	}

	/**
	 * @return bool
	 */
	public function getDividedManual()
	{
		$model = new Model_Main_Count_Step_Manual();
		try
		{
			$html = $model->display();
		}
		catch (MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::instance()->setException($ex);
		}

		$can_continue = ($model->getSeriesCount() > 1) ? true : false;
		$this->view->assign('can_continue', $can_continue);
		$this->view->assign('list', $model->getSeriesList());

		return MLib_Ajax::instance()->setSuccess(array(
			'message'		=> 'Данные шага вычисления #'.$model->getStep().' успешно получены',
			'html'			=> $html,
			'step'			=> $model->getStep(),
			'can_continue'	=> $can_continue,
			'linears'		=> $this->view->fetch('decompose/view/result/manual_linear.tpl')
		));
	}

	/**
	 * @return bool
	 */
	public function getExcludedManual()
	{
		$form_data = $_POST;
		$model = new Model_Main_Count_Exclude($form_data);

		try
		{
			$html = $model->display();
		}
		catch(MLib_Exception_Abstract $ex)
		{
			return MLib_Ajax::instance()->setException($ex);
		}

		$this->view->assign('list', $model->getSeriesList());

		return MLib_Ajax::instance()->setSuccess(array(
			'message'		=> 'Данные исключения для шага #'.$model->getStep().' успешно получены',
			'html'			=> $html,
			'step'			=> $model->getStep(),
			'can_continue'	=> ($model->getSeriesCount() > 1) ? true : false,
			'log'			=> $this->view->fetch('decompose/view/log.tpl')
		));
	}
}