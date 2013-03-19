<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<sib@avantajprim.com>
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
	'enable_calman_filter'	=> array(
		'label'		=> 'Использовать фильтр Калмана при делении',
		'type'		=> 'checkbox',
		'value'		=> false
	)
);