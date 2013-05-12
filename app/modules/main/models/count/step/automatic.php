<?php
/**
 * @author Сибов Александр<cyberdelia1987@gmail.com>
 */
class Model_Main_Count_Step_Automatic extends Model_Main_Count_Step_Abstract
{
	protected function _excludeDenominator()
	{
		foreach ($this->_series_list as $serie)
		{
			$serie->excludeDenominator()->filter($this->_filter);
		}
	}
}