<?php
class Model_Main_Filter_Calman
{
	protected $_X0; // predicted state
	protected $_P0; // predicted covariance

	protected $_F; // factor of real value to previous real value
	protected $_Q; // measurement noise
	protected $_H; // factor of measured value to real value
	protected $_R; // environment noise

	protected $_state;
	protected $_covariance;

	/**
	 * Конструктор
	 * @param float 	$q
	 * @param float 	$r
	 * @param float|int $f
	 * @param float|int $h
	 */
	public function __construct($q, $r, $f = 1, $h = 1)
	{
		$this->_Q = $q;
		$this->_R = $r;
		$this->_F = $f;
		$this->_H = $h;
	}

	/**
	 * @param float $state
	 * @param float $covariance
	 */
	protected function _setState($state, $covariance)
	{
		$this->_state = $state;
		$this->_covariance = $covariance;
	}

	/**
	 * @param float $data
	 */
	protected function _correct($data)
	{
		//time update - prediction
		$this->_X0 = $this->_F*$this->_state;
		$this->_P0 = $this->_F*$this->_covariance*$this->_F + $this->_Q;

		//measurement update - correction
		$K = $this->_H*$this->_P0/($this->_H*$this->_P0*$this->_H + $this->_R);
		$this->_state = $this->_X0 + $K*($data - $this->_H*$this->_X0);
		$this->_covariance = (1 - $K*$this->_H)*$this->_P0;
	}

	/**
	 * Метод фильтрации
	 * @param array $data
	 * @param float $init_covariance
	 * @return array
	 */
	public function filter(array $data, $init_covariance = 0.1)
	{
		$tmp = array();
		$this->_setState($data[0], $init_covariance);
		foreach ($data as $key => $value)
		{
			$this->_correct($value);
			$tmp[$key] = $this->_state;
		}

		return $tmp;
	}
}
/**
    // Применение...

    var fuelData = GetData();
    var filtered = new List<double>();

    var kalman = new KalmanFilterSimple1D(f: 1, h: 1, q: 2, r: 15); // задаем F, H, Q и R
    kalman.SetState(fuelData[0], 0.1); // Задаем начальные значение State и Covariance
    foreach(var d in fuelData)
    {
		kalman.Correct(d); // Применяем алгоритм

		filtered.Add(kalman.State); // Сохраняем текущее состояние
	}
*/