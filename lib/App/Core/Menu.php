<?php

namespace App\Core;

use App\Controllers\Admin\MenuController;

class Menu
{
	private static $data;

	public static function getData()
	{
		return self::$data;
	}

	public static function getCategory()
	{
		$getMenu = new MenuController();
		static::$data = $getMenu->getCategory();
	}
}