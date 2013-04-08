<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class MLib_Filesystem
{
	protected $_path_from = PROJECT_BASE_PATH;

	/**
	 * @param bool $path_from
	 * @param bool $redefine
	 */
	public function __construct($path_from = false, $redefine = false)
	{
		if ($path_from)
		{
			$this->_path_from = ($redefine) ? $path_from : $this->_path_from.$path_from;
		}
	}

	/**
	 * Запись данных в файл
	 * @param string $file_path
	 * @param mixed  $data
	 * @param bool   $encode_json
	 * @param string $mode
	 * @return int
	 * @throws MLib_Exception_Abstract
	 */
	public function writeFile($file_path, $data, $encode_json = false, $mode = 'w')
	{
		$file_path = $this->_preparePath($file_path);

		$cache_path = $this->_path_from;
		if (strpos($file_path, DS) !== false)
		{
			$path_array = explode(DS, $file_path);
			$file_path = array_pop($path_array);
			$cache_path .= implode(DS, $path_array).DS;
			unset($path_array);
		}

		if (!$this->createPath($cache_path))
		{
			throw new MLib_Exception_Abstract('Не удалось создать директорию: "'.$cache_path.'"');
		}

		if (!$fh = fopen($cache_path.$file_path, $mode))
		{
			throw new MLib_Exception_Abstract('Такого файла не существует или не получилось его создать: "'.$cache_path.$file_path.'"');
		}

		return fwrite($fh, ($encode_json) ? json_encode($data) : $data);
	}

	/**
	 * Чтение данных из файла
	 * @param string $file_path
	 * @param bool   $decode_json
	 * @return mixed|string
	 * @throws MLib_Exception_Abstract
	 */
	public function readFile($file_path, $decode_json = false)
	{
		$file_path = $this->_path_from.$this->_preparePath($file_path);

		if (!file_exists($file_path)) return false;

		if (!is_readable($file_path))
		{
			throw new MLib_Exception_Abstract('Файл нечитабелен: "'.$file_path.'"');
		}

		$str = file_get_contents($file_path);

		return ($decode_json) ? json_decode($str, true) : $str;
	}

	/**
	 * Создание директории
	 * @param string $path
	 * @param int    $mode
	 * @return bool
	 */
	public function createPath($path, $mode = 0777)
	{
		$path = $this->_preparePath($path, false);

		if (file_exists($path) && is_dir($path))
		{
			return true;
		}

		return mkdir($path, $mode, true);
	}

	/**
	 * Рекурсивное удаление директории
	 * @param $dir
	 * @return bool
	 */
	public function removeDirRecursive($dir)
	{
		$dir = $this->_preparePath($dir);

		if (!is_dir($dir) || is_link($dir))
		{
			return unlink($dir);
		}

		foreach (scandir($dir) as $file)
		{
			if ($file == '.' || $file == '..') continue;

			if (!$this->removeDirRecursive($dir.DS.$file))
			{
				chmod($dir.DS.$file, 0777);
				if (!$this->removeDirRecursive($dir.DS.$file)) return false;
			};
		}

		return rmdir($dir);
	}

	/**
	 * Подготовка пути:
	 * - Замена слэшей на DIRECTORY_SEPARATOR
	 * - Проверка на то, что не ведется доступ к директории, не находящейся в директории проекта
	 * - Проверка на то, что нет символов .. - перехода на уровень выше
	 * @param string $path
	 * @param bool   $trim
	 * @return string
	 * @throws MLib_Exception_Abstract
	 * @throws MLib_Exception_BadUsage
	 */
	protected function _preparePath($path, $trim = true)
	{
		$path = str_replace('\\', DS, $path);
		$path = str_replace('/', DS, $path);
		$path = $trim ? trim($path, DS) : $path;

		/**
		 * Разрешение создавать/удалять каталоги не в директории проекта устанавливаются глобально с общем конфиге
		 */
		if (!setif(MLib_Config::getMain('filesystem'), 'allow_directory_create_not_in_base_path'))
		{
			if (strpos($path, DS.'..'))
			{
				throw new MLib_Exception_BadUsage('Операции с переходом на уровень выше не разрешены');
			}
		}

		return $path;
	}
}