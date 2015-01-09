<?php

use Vitem\Repositories\SettingRepo;

class Setting extends \Eloquent {

	protected $fillable = ['key' , 'value' , 'user_id'];


	public static function addResidue($quantity = 0){

		$SettingRepo = new SettingRepo();

		return SettingRepo::addResidue($quantity);		

	}

	public static function checkSetting($field)
	{

		$SettingRepo = new SettingRepo();

		return SettingRepo::checkSetting($field);	

	}



	public static function checkSettingAndAddResidue($field = '' , $quantity = 0)
	{

		$SettingRepo = new SettingRepo();

		return SettingRepo::checkSettingAndAddResidue($field , $quantity);	

	}

}