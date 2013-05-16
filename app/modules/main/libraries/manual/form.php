<?php
/**
 * Библиотека, отвечающая за обработку данных с формы выбора линейных участков
 * в ручном режиме и установке этим участкам флага "выбран" для дальнейшего
 * их использования на шаге исключения рядов
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Lib_Main_Manual_Form
{
	/**
	 * Данные формы
	 * @var array
	 */
	protected $_form_data;

	/**
	 * Список рядов
	 * @var Lib_Main_Serie_List|Lib_Main_Serie[]
	 */
	protected $_list;

	/**
	 * Конструктор
	 * @param Lib_Main_Serie_List $list
	 * @param array               $form_data
	 */
	public function __construct(Lib_Main_Serie_List $list, array $form_data)
	{
		$this->_list = $list;
		$this->_form_data = $form_data;
	}

	/**
	 * Назначить выбранными переданные данные о линейных участках
	 */
	public function prepare()
	{
		foreach ($this->_list as $key => $serie)
		{
			$this->_prepareForASerie($serie, $key);
		}
	}

	/**
	 * Обработка выбранных линейных участков для одного ряда
	 * @param Lib_Main_Serie	$serie
	 * @param integer			$key
	 * @throws MLib_Exception_WrongArgument
	 */
	protected function _prepareForASerie(Lib_Main_Serie $serie, $key)
	{
		$mode = setif(setif($this->_form_data, 'value_mode'), $key);
		if (!in_array($mode, array('counted', 'manual')))
		{
			throw new MLib_Exception_WrongArgument('Передан неверный аргумент для режима линейных участков: "'.$mode.'". Ожидалось: "counted"|"manual"');
		}

		$line_parts = $serie->getLineParts();
		$line_parts = $mode == 'counted' ? $this->_parseCounted($line_parts, $key) : $this->_parseManual($line_parts, $key);
		$serie->setLineParts($line_parts);
	}

	/**
	 * Обработка случая, кгда линейные участки выбираются из уже рссчитанных ранее
	 * @param array		$line_parts
	 * @param integer	$key
	 * @return array
	 * @throws MLib_Exception_BadUsage
	 */
	protected function _parseCounted(array $line_parts, $key)
	{
		$settings = $this->_getSettings($key);

		if (!is_array($settings['indexes']))
		{
			$settings['indexes'] = array($settings['indexes']);
		}

		foreach (array_keys($line_parts) as $line_key)
		{
			$line_parts[$line_key]['selected'] = in_array($line_key, $settings['indexes']) ? true : false;
		}

		return $line_parts;
	}

	/**
	 * Обработка случая, когда линеные участки задает пользователь
	 * @param array	$line_parts
	 * @param integer	$key
	 * @return array
	 * @throws MLib_Exception_WrongArgument
	 */
	protected function _parseManual(array $line_parts, $key)
	{
		$settings = $this->_getSettings($key);

		for ($keyi = sizeof($settings['manuals']) - 1; $keyi >=0; $keyi--)
		{
			if ($settings['continue'] && $keyi != 0) continue;
			$man_value = $settings['manuals'][$keyi];

			if (!is_numeric($man_value))
			{
				throw new MLib_Exception_WrongArgument('Переданный ручной коэффициент линеного учатка не является цифровым значением: "'.$man_value.'"');
			}

			array_unshift($line_parts, array(
				'value'		=> $man_value,
				'average'	=> $man_value,
				'start'		=> 0,
				'end'		=> 0,
				'count'		=> 0,
				'selected'	=> true
			));
		}
		return $line_parts;
	}

	/**
	 * Получение настроек линейных участков для одного ряда
	 * @param $key
	 * @return array
	 */
	protected function _getSettings($key)
	{
		return array(
			'indexes'	=> setif(setif($this->_form_data, 'serie_line'), $key),
			'manuals'	=> array(
				setif(setif($this->_form_data, 'serie_line_manual_value'), $key, 0),
				setif(setif($this->_form_data, 'serie_line_manual_value_2'), $key, 0),
			),
			'continue'	=> (bool) setif($this->_form_data, 'continue_decomposition')
		);
	}
}