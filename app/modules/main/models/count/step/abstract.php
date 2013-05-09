<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Model_Main_Count_Step_Abstract
{
	protected $_step;

	/**
	 * @var Lib_Main_Serie_List
	 */
	protected $_prev_calc;

	/**
	 * @var MLib_Session
	 */
	protected $_session;

	/**
	 * Список столбцов данных
	 * @var Lib_Main_Serie_List|Lib_Main_Serie[]
	 */
	protected $_series_list;

	/**
	 * @var Lib_Main_Serie_List|Lib_Main_Serie[]
	 */
	protected $_mediate_list;

	/**
	 * Объект вида
	 * @var MLib_Viewer
	 */
	protected $_view;

	/**
	 * Объект фильтра
	 * @var bool|Lib_Main_Filter_SavGolay
	 */
	protected $_filter;

	public function __construct()
	{
		$this->_session = MLib_Session::instance();
		$this->_view = MLib_Viewer::instance();
		$this->_step = sizeof($this->_session->get('decompose'));
		$this->_filter = (Model_Main_Decompose_Preferences::instance()->getValue('enable_savitsky_golay_filter')) ?
		$filter = new Lib_Main_Filter_SavGolay(array('points' => Model_Main_Decompose_Preferences::instance()->getValue('filter_points_count'))) : false;
	}

	/**
	 * Получение шага рассчетов
	 * @return int
	 */
	public function getStep()
	{
		return $this->_step;
	}

	/**
	 * Отображение результата в шаблон
	 * @return string
	 */
	public function display()
	{
		$this->_countSeries();
		$this->_prepareJson();
		$this->_saveToSession();

		$this->_view->assign('model', $this);
		$this->_view->assign('series_list', $this->_series_list);
		$this->_view->assign('mediate_list', $this->_mediate_list);
		return $this->_view->fetch('decompose/view/result.tpl');
	}

	/**
	 * Получение количества столбцов в результате рассчета
	 * @return int
	 */
	public function getSeriesCount()
	{
		return sizeof($this->_series_list);
	}

	/**
	 * @return Lib_Main_Serie_List
	 */
	public function getSeriesList()
	{
		return $this->_series_list;
	}

	/**
	 * @return Lib_Main_Serie_List
	 */
	public function getMediateList()
	{
		return $this->_mediate_list;
	}

	/**
	 * Рассчет данных по столбцам
	 */
	protected function _countSeries()
	{
		/**
		 * @var Lib_Main_Serie $serie
		 */
		$this->_getPrevCalc();

		$series_list = new Lib_Main_Serie_List();
		$series_list->setXAxis($this->_prev_calc->getXAxis());

		$first_serie = first($this->_prev_calc->toArray());

		$mediate_list = new Lib_Main_Serie_List();
		$mediate_list->setXAxis($this->_prev_calc->getXAxis());

		foreach ($this->_prev_calc as $key => $serie)
		{
			if ($key == 0) continue;

			$new_serie = new Lib_Main_Serie();
			$new_serie
				->setList($series_list)
				->setCaption('f'.$key.sprintf("%''".$this->getStep()."s",  ''))
				->setNumerator($serie)
				->setDenominator($first_serie)
				->divide()
				->analyzeLineParts(
					Model_Main_Decompose_Preferences::instance()->getValue('spread_percent'),
					Model_Main_Decompose_Preferences::instance()->getValue('dots_per_jump'))
				->filter($this->_filter);

			$mediate_list[] = clone $new_serie;
			$series_list[] = $new_serie;
		}

		$this->_mediate_list = $mediate_list;
		$this->_series_list = $series_list;

		$this->_excludeDenominator();
	}

	/**
	 * Исключение полосы
	 */
	protected function _excludeDenominator() {}

	/**
	 * Получение предыдущего вычисления из сессии
	 * @throws MLib_Exception_Abstract
	 */
	protected function _getPrevCalc()
	{
		if ($this->getStep() < 1)
		{
			throw new MLib_Exception_Abstract('Текущий шаг меньше 1, в сессии недостаточно данных');
		}

		$this->_prev_calc = $this->_session->get('decompose.'.($this->getStep()-1));

		if (!$this->_prev_calc)
		{
			throw new MLib_Exception_Abstract('Не удалось получить данные предыдущего вычисления из сессии');
		}
	}

	/**
	 * Сохранение объектов в сессию
	 */
	protected function _saveToSession()
	{
		MLib_Session::instance()->set('decompose.'.$this->getStep(), $this->_series_list);
		$this->_session->set('mediate.'.($this->getStep() - 1), $this->_mediate_list);
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
		$tmp = array(
			'xAxis'	=> array(
				'caption'	=> $this->_series_list->getXAxis()->getCaption(),
				'data'		=> $this->_series_list->getXAxis()->toArray()
			),
			'series'	=> array()
		);

		$tmp2 = array(
			'xAxis'	=> array(
				'caption'	=> $this->_mediate_list->getXAxis()->getCaption(),
				'data'		=> $this->_mediate_list->getXAxis()->toArray()
			),
			'series'	=> array()
		);

		foreach ($this->_series_list->toArray() as $key => $serie)
		{
			$tmp['series'][] = array(
				'caption'	=> $serie->getCaption(),
				'data'		=> $serie->toArray()
			);

			$tmp2['series'][] = array(
				'caption'	=> $this->_mediate_list[$key]->getCaption(),
				'data'		=> $this->_mediate_list[$key]->toArray()
			);
		}

		$this->_view->assign('chart_data',	json_encode($tmp));
		$this->_view->assign('mediate_data', json_encode($tmp2));
	}
}