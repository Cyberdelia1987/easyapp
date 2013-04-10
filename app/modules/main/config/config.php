<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
$properties = array(
	'spread_percent'	=> array(
		'label'		=> 'Максимальный разброс по прямой, % :',
		'type'		=> 'text',
		'value'		=> 2
	),
	'dots_per_jump'		=> array(
		'label'		=> 'Погрешность, точек на скачок : ',
		'type'		=> 'text',
		'value'		=> 3
	),
	'enable_peack_filtering'	=> array(
		'label'		=> 'Использовать фильтрацию пиков (экспериментально)',
		'type'		=> 'checkbox',
		'value'		=> false
	)
);