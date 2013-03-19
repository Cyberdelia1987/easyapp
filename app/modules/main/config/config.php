<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<sib@avantajprim.com>
 */
$properties = array(
	'spread_percent'	=> array(
		'label'		=> '% допустимого разброса по оси Y для прямолинейного участка',
		'type'		=> 'text',
		'value'		=> 2
	),
	'enable_calman_filter'	=> array(
		'label'		=> 'Использовать фильтр Калмана для деленных графиков',
		'type'		=> 'checkbox',
		'value'		=> false
	)
);