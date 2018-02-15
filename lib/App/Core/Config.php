<?php
// хранилище конфигураций

namespace App\Core;

class Config
{
	protected static $storage = [];

	public static function set($param, $value)
	{
		if (!isset(static::$storage[$param])) {
			static::$storage[$param] = $value;
		} else {
			trigger_error('Variable '. $param .' already defined', E_USER_WARNING);
		}
	}

	public static function get($param)
	{
		return static::$storage[$param];
	}
}