<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<sib@avantajprim.com>
 */
class MLib_Base_Singleton implements MLib_Base_Singleton_Interface
{
	/**
	 * @var array
	 */
	private static $_instances;

	/**
	 * Метод реализации сиглтон-доступа к объекту
	 * @return static
	 */
	public static function instance()
	{
		$class = get_called_class();
		if (!isset(self::$_instances[$class]))
		{
			self::$_instances[$class] = new $class;
		}

		return self::$_instances[$class];
	}

	protected function __construct() {}
	protected function __clone() {}
}