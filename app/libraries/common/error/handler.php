<?php
/**
 * Author: Alexandr Sibov aka "Cyber"
 * Created: 09.10.12 23:48
 */

set_error_handler(array('Error_Handler', 'handleError'),E_ALL);

/**
 * Сделать нормальную обработку ошибок
 */
class Error_Handler
{
	static public function handleError($errno, $msg, $file, $line)
	{
		echo '<div>';
		echo "Произошла ошибка:<b>$errno</b>!<br>";
		echo "Файл: <tt>$file</tt>, строка $line.<br>";
		echo "Текст ошибки: <i>$msg</i>";
		echo "</div>";
	}
}