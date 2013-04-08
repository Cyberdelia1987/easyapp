<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class MLib_Router_Uri
{
	/**
	 * Получение базового адреса
	 * @return string
	 */
	static public function getBaseUrl()
	{
		$protocol = isset($_SERVER["https"]) ? 'https' : 'http';

		return $protocol.'://'.trim($_SERVER['HTTP_HOST'], '/').'/';
	}

	/**
	 * Банальный редирект
	 * @param string $link
	 * @param string $method
	 * @param int    $http_response_code
	 */
	static public function redirect($link = '', $method = 'location', $http_response_code = 301)
	{
		$uri = self::getBaseUrl().trim($link, '/');

		switch($method)
		{
			case 'refresh' :
				header("Refresh:0;url=".$uri);
				break;
			default :
				header("Location: ".$uri, TRUE, $http_response_code);
			break;
		}
		exit;
	}
}