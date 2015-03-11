<?php namespace Vitem\Repositories;

//use Vitem\Entities\Store;

class SettingRepo extends BaseRepo {

	/*public function getModel()
	{
		return new Store;
	}*/

	protected static $sales;

	public function getModel()
    {
        return new \Sale;
    }

	static function addResidue($quantity)
	{
		$setting = \Setting::where('key', 'residue')
				->first();

		$residue = $setting->value;

		$key = $residue + $quantity;

		if(is_numeric($key))
		{
			$key = number_format($key, 2, '.', '');
		}

		$setting->update([
					'value' => $key
				]);
	}

	static function checkSetting($field)
	{

		$setting = \Setting::where('key' , $field)->first();



		if($setting){

			return ($setting->value == 'true') ? true : false ;

		}

		return false;

	}

	static function checkSettingAndAddResidue($field , $quantity)
	{ 

		if(self::checkSetting($field))
		{ 

			return self::addResidue($quantity);

		}

		return false;
	}
}