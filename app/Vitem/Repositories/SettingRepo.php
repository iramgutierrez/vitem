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

    /*static function addResidue($quantity , $store_id)
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
	}*/

	static function addResidue($quantity , $store_id)
	{ 

		$store = \Store::find($store_id); 

		$residue = $store->residue;

		$residue = $residue + $quantity;

		$store->residue = $residue;

		$store->update();
	}

	static function checkSetting($field)
	{

		$setting = \Setting::where('key' , $field)->first();



		if($setting){

			return ($setting->value == 'true') ? true : false ;

		}

		return false;

	}

	static function checkSettingAndAddResidue($field , $quantity , $store_id)
	{ 

		if(self::checkSetting($field) && $store_id)
		{ 

			return self::addResidue($quantity , $store_id);

		}

		return false;
	}
}