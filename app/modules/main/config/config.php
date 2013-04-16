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
	'enable_savitsky_golay_filter'	=> array(
		'label'		=> 'Использовать фильтр Савицкого-Голея',
		'type'		=> 'checkbox',
		'value'		=> false
	),
	'filter_points_count'	=> array(
		'label'		=> 'Количество точек фильтрации',
		'type'		=> 'select',
		'value'		=> 5,
		'options'	=> array(
			5	=> 5,
			7	=> 7,
			9	=> 9,
			11	=> 11
		)
	)
);