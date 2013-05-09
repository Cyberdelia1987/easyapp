<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Model_Main_Count_Exclude
{
	protected $_step;

	/**
	 * @var Lib_Main_Serie_List|Lib_Main_Serie[]
	 */
	protected $_prev_calc;

	/**
	 * @var MLib_Session
	 */
	protected $_session;

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

	/**
	 * Массив данных с формы
	 * @var array
	 */
	protected $_form_data;

	public function __construct(array $form_data)
	{
		$this->_session = MLib_Session::instance();
		$this->_view = MLib_Viewer::instance();
		$this->_step = sizeof($this->_session->get('decompose')) - 1;
		$this->_filter = (Model_Main_Decompose_Preferences::instance()->getValue('enable_savitsky_golay_filter')) ?
			$filter = new Lib_Main_Filter_SavGolay(array('points' => Model_Main_Decompose_Preferences::instance()->getValue('filter_points_count'))) : false;
		$this->_form_data = $form_data;
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
		$this->_view->assign('series_list', $this->_prev_calc);
		return $this->_view->fetch('decompose/view/result/manual_excluded.tpl');
	}

	/**
	 * Получение количества столбцов в результате рассчета
	 * @return int
	 */
	public function getSeriesCount()
	{
		return sizeof($this->_prev_calc);
	}

	/**
	 * @return Lib_Main_Serie_List
	 */
	public function getSeriesList()
	{
		return $this->_prev_calc;
	}

	/**
	 * Рассчет данных по столбцам
	 */
	protected function _countSeries()
	{
		$this->_getPrevCalc();

		foreach ($this->_prev_calc as $key => $serie)
		{
			$this->_setSelectedLinePart($serie, $key);
			$serie->excludeDenominator()->filter($this->_filter);
		}
	}

	/**
	 * @param Lib_Main_Serie	$serie
	 * @param integer			$key
	 */
	protected function _setSelectedLinePart(Lib_Main_Serie $serie, $key)
	{
		$idx = setif(setif($this->_form_data, 'serie_line'), $key, 0);
		$line_parts = $serie->getLineParts();

		if ($idx == 'manual' && is_numeric(setif(setif($this->_form_data, 'serie_line_manual_value'), $key)))
		{
			$value = setif(setif($this->_form_data, 'serie_line_manual_value'), $key);

			array_unshift($line_parts, array(
				'value'		=> $value,
				'average'	=> $value,
				'start'		=> 0,
				'end'		=> 0,
				'count'		=> 0,
				'selected'	=> true
			));
		}
		else
		{
			foreach (array_keys($line_parts) as $line_key)
			{
				$line_parts[$line_key]['selected'] = ($line_key == $idx) ? true : false;
			}
		}

		$serie->setLineParts($line_parts);
	}

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

		$this->_prev_calc = $this->_session->get('decompose.'.($this->getStep()));

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
		MLib_Session::instance()->set('decompose.'.$this->getStep(), $this->_prev_calc);
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
				'caption'	=> $this->_prev_calc->getXAxis()->getCaption(),
				'data'		=> $this->_prev_calc->getXAxis()->toArray()
			),
			'series'	=> array()
		);

		foreach ($this->_prev_calc->toArray() as $serie)
		{
			$tmp['series'][] = array(
				'caption'	=> $serie->getCaption(),
				'data'		=> $serie->toArray()
			);
		}

		$this->_view->assign('chart_data',	json_encode($tmp));
	}
}