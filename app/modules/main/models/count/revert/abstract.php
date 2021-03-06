<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Model_Main_Count_Revert_Abstract
{
	/**
	 * @var Lib_Main_Serie_List
	 */
	protected $_prev_calc;

	/**
	 * @var MLib_Session
	 */
	protected $_session;

	/**
	 * Список рядов данных
	 * @var Lib_Main_Serie_List
	 */
	protected $_series_list;

	/**
	 * Объект вида
	 * @var MLib_Viewer
	 */
	protected $_view;

	/**
	 *
	 */
	public function __construct()
	{
		$this->_session = MLib_Session::instance();
		$this->_view = MLib_Viewer::instance();
	}

	public function display()
	{
		$this->_prepareSeries();
		$this->_prepareJson();

		$this->_view->assign('model', $this);
		$this->_view->assign('series_list', $this->_series_list);
		return $this->_view->fetch('decompose/view/result_final.tpl');
	}

	/**
	 *
	 */
	protected function _prepareSeries()
	{
		/**
		 * @var Lib_Main_Serie_List[] $counted
		 */
		$list = new Lib_Main_Serie_List();
		$counted = $this->_session->get('decompose');
		$list->setXAxis($counted[0]->getXaxis());
		$keys = array_keys($counted);
		$min_step = reset($keys);
		$max_step = end($keys);

		for ($i = $max_step; $i >= $min_step; $i--)
		{
			/**
			 * @var Lib_Main_Serie $bear_serie
			 */
			$bear_serie = $this->_session->get('decompose.'.$i);
			$bear_serie = $bear_serie[0];
			$coef = $bear_serie->hasLinearParts() ? $bear_serie->getLongestLinePartValue() : 1;

			if ($bear_serie->hasLinearParts())
			{
				$sec = $bear_serie->getNextLinePartValue($coef);
				$coef = $coef - $sec;//$bear_serie->getNextLinePartValue($coef);
			}

			$serie = new Lib_Main_Serie();
			$serie->setCaption('Reverse #'.$i);

			foreach ($bear_serie as $key => $value)
			{
				for ($j = $i+1; $j <= $max_step; $j++)
				{
					$value -= $list[$j][$key];
				}
				$serie[$key] = $coef == 0 ? 0 : round($value / $coef, 5);
			}

			$list[$i] = $serie;
		}

		$this->_series_list = $list;
	}

	/**
	 * @return string
	 */
	public function getStep()
	{
		return 'final';
	}

	/**
	 * @return Lib_Main_Serie_List
	 */
	public function getSeriesList()
	{
		return $this->_series_list;
	}

	/**
	 * Подготовка JSON-данных для JavaScript
	 * @return string
	 */
	protected function _prepareJson()
	{
		/**
		 * @var Lib_Main_Serie $serie
		 */
		$tmp = array();

		$tmp['xAxis'] = array(
			'caption'	=> $this->_series_list->getXAxis()->getCaption(),
			'data'		=> $this->_series_list->getXAxis()->toArray()
		);
		$tmp['series'] = array();

		// Добавляем к рядам обратного рассчета первый ряд из измеренных значений
		$tmp['series'][] = array(
			'caption'	=> $this->_session->get('decompose.0.0')->getCaption(),
			'data'		=> $this->_session->get('decompose.0.0')->toArray()
		);

		foreach ($this->_series_list->toArray() as $serie)
		{
			$tmp['series'][] = array(
				'caption'	=> $serie->getCaption(),
				'data'		=> $serie->toArray()
			);
		}

		$this->_view->assign('chart_data',	json_encode($tmp));
	}
}