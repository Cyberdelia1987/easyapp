<?php
/**
 * Краткое описание назначения класса
 * @author Сибов Александр<sib@avantajprim.com>
 */
class MLib_Ajax
{
	static protected $_instance;

	/**
	 * Если включен режим обработки AJAX-ответов
	 * @var
	 */
	protected $_ajax_mode = false;

	/**
	 * Константы возвращаемого результата
	 */
	const RESULT_UNDEFINED		= 'undefined';
	const RESULT_SUCCESS		= 'success';
	const RESULT_ERROR 			= 'error';
	const RESULT_GLOBAL_ERROR 	= 'global_error';
	const RESULT_EXCEPTION		= 'exception';

	/**
	 *
	 */
	protected function __construct()
	{
	}

	protected $_return = array(
		'result'		=> self::RESULT_UNDEFINED,
		'response'		=> false
	);

	/**
	 * Получеие синглтона AJAX'а
	 * @return MLib_Ajax
	 */
	static public function getInstance()
	{
		if (!self::$_instance) {
			self::$_instance = new self();
		}

		return static::$_instance;
	}

	/**
	 * Установка положительного ответа AJAX'а
	 * @param mixed $data
	 * @return bool
	 */
	public function setSuccess($data = false)
	{
		$this->_initAjax();
		$this->_return['result'] = self::RESULT_SUCCESS;
		$this->_return['response'] = $data;
		return true;
	}

	/**
	 * Установка ошибки для ответа AJAX'ом
	 * @param string|array $errors
	 * @return bool
	 */
	public function setError($errors)
	{
		$this->_initAjax();
		$this->_return['result'] = self::RESULT_ERROR;
		$this->_return['response'] = $errors;
		return true;
	}

	/**
	 * Установка
	 * @param string|array $global_errors
	 * @return bool
	 */
	public function setGlobalError($global_errors)
	{
		$this->_initAjax();
		$this->_return['result'] = self::RESULT_GLOBAL_ERROR;
		$this->_return['response'] = $global_errors;
		return true;
	}

	/**
	 * Выброс исключения
	 * @param MLib_Exception_Abstract $ex
	 * @return bool
	 */
	public function setException(MLib_Exception_Abstract $ex)
	{
		$this->_initAjax();
		$this->_return['result'] = self::RESULT_EXCEPTION;
		$this->_return['response'] = array(
			'message'	=> $ex->getMessage()
		);
		return true;
	}

	protected function _initAjax()
	{
		$this->_ajax_mode = true;
	}

	/**
	 *
	 */
	public function display()
	{
		if (!$this->_ajax_mode) return;
		ob_get_clean();
		header('Content-type: application/json');
		ob_start();
		echo json_encode($this->_return);
		ob_end_flush();
	}
}