<?php
/**
 * @author Сибов Александр<sib@avantajprim.com>
 */
class Model_Main_Input_Files_Storage
{
	/**
	 *
	 * @var string
	 */
	protected $_files_dir;

	public function __construct()
	{
		$this->_files_dir = PROJECT_BASE_PATH.'files'.DS;
	}

	/**
	 * Сохранение распарсенных файлов в директорию, и сериализованных
	 * @param $file_name
	 * @param $content
	 */
	public function save($file_name, $content)
	{
		$this->_checkDir();
		$hash = substr(md5(microtime()), 0, 6);
		$file_name = $hash.'_'.str_replace(' ', '_', $file_name);
		$fp = fopen($this->_files_dir.$file_name, 'a+');
		fwrite($fp, serialize($content));
	}

	/**
	 * Получение списка ранее загруженных файлов
	 * @return array
	 */
	public function getFileList()
	{
		$this->_checkDir();
		$dir_handle = opendir($this->_files_dir);

		$tmp = array();
		while(false !== ($entry = readdir($dir_handle)))
		{
			if ($entry == '') continue;

			$exploded = explode('_', $entry);
			if (sizeof($exploded) < 2) continue;

			$hash = array_shift($exploded);
			if (strlen($hash) != 6) continue;

			$file_info = stat($this->_files_dir.$entry);

			$file_size = setif($file_info, 'size', 0);

			if ($file_size > 1048576)
			{
				$file_size = round($file_size/1048576, 2).' mb';
			}
			elseif ($file_size > 1024)
			{
				$file_size = round($file_size/1024, 2).' kb';
			}
			else
			{
				$file_size = $file_size.' b';
			}

			$tmp[] = array(
				'orig_file_name'	=> implode('_', $exploded),
				'file_name'			=> $entry,
				'modify_time'		=> date("Y-m-d H:i:s.", setif($file_info, 'mtime')),
				'size'			=> $file_size
			);
		}

		return $tmp;
	}

	public function getFileObject($file_name)
	{
		$file_name = $this->_files_dir.$file_name;

		if (!file_exists($file_name) || !is_real($file_name))
		{
			throw new MLib_Exception_WrongArgument('В директории нет указанного файла');
		}


	}

	/**
	 * Проверки директории
	 * @throws MLib_Exception_BadUsage
	 */
	protected function _checkDir()
	{
		if (!is_dir($this->_files_dir))
		{
			if (!mkdir($this->_files_dir, 0777, true))
			{
				throw new MLib_Exception_BadUsage('Не найдена директория для записи/чтения файлов');
			}
		}

		if (!is_readable($this->_files_dir))
		{
			throw new MLib_Exception_BadUsage('Директория для записи/чтения файлов нечитабельна');
		}

		if (!is_writeable($this->_files_dir))
		{
			throw new MLib_Exception_BadUsage('Директория для записи файлов недоступна для записи');
		}
	}
}