<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
$topnav = array(
	array(
		'title'		=> 'Загрузка файлов',
		'url'		=> '/',
		'regexp'	=> '/main/index/index',
		'strict'	=> true
	),
	array(
		'title'		=> 'Последние рассчеты',
		'plugin'	=> 'MLib_Router_Nav_Plugin_LastFile',
		'url'		=> '/decompose',
		'regexp'	=> '/main/decompose/index/[^/]*',
		'strict'	=> true
	)
);