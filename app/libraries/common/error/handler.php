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
	static public function handleError($err_num, $err_str, $err_file, $err_line)
	{
		//if (!(error_reporting() & $err_num)) return false;

		switch ($err_num)
		{
			case E_USER_ERROR:
				echo "<b>My ERROR</b> [$err_num] $err_str<br />\n";
				echo "  Фатальная ошибка в строке $err_line файла $err_file";
				echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
				echo "Завершение работы...<br />\n";
				exit(1);
				break;

			case E_USER_WARNING:
				echo "<b>My WARNING</b> [$err_num] $err_str<br />\n";
				break;

			case E_USER_NOTICE:
				echo "<b>My NOTICE</b> [$err_num] $err_str<br />\n";
				break;

			default:
				echo "Неизвестная ошибка: [$err_num] $err_str<br />\n";
				break;
		}

		echo 'Файл: ['.$err_line.'] '.$err_file.'<br>'.PHP_EOL;

		/* Не запускаем внутренний обработчик ошибок PHP */
		return false;
	}
}