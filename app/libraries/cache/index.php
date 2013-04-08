<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class MLib_Cache extends MLib_Filesystem
{
	protected $_cache_path;

	/**
	 * @param bool $module_name
	 * @throws MLib_Exception_BadUsage
	 */
	public function __construct($module_name)
	{
		if (empty($module_name))
		{
			throw new MLib_Exception_BadUsage('Должно быть задано имя модуля для работы с файлами кеша');
		}

		parent::__construct(APP_PATH.'cache'.DS.'modules_cache'.DS.$module_name.DS, true);
	}
}