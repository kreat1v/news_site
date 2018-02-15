<?php

namespace App\Core;

use App\Controllers\Admin\AdController;

class Ad
{
	private static $data;

	public static function getData()
	{
		return self::$data;
	}

	public static function getAd($side)
	{
		$getAd = new AdController();
		static::$data = $getAd->getAdBody($side);
	}
}