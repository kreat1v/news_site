<?php

namespace App\Core;

class Style
{
	private static $config;
	private static $configFile;

	private static $style;
	private static $styleFile;

	public static function load()
	{
		static::$configFile = ROOT.DS.'style'.DS.'config.txt';

		$data = file_get_contents(static::$configFile);
		static::$config = unserialize($data);
	}

	public static function get($code, $default = '')
	{
		$parts = explode('.', $code);

		return isset(static::$config[$parts[0]][$parts[1]])
			? static::$config[$parts[0]][$parts[1]]
			: $default;
	}

	public static function set($code, $value)
	{
		$parts = explode('.', $code);

		if (isset(static::$configFile)) {
			static::$config[$parts[0]][$parts[1]] = $value;
		}

		$data = serialize(static::$config);
		file_put_contents(static::$configFile, $data);
	}

	public static function getStyle()
	{
		return self::$style;
	}

	public static function setStyle($style)
	{
		self::$style = $style;

		$styleFile = ROOT.DS.'style'.DS.static::$style.'.php';

		if (!file_exists($styleFile)) {
			throw new \Exception('Style file not found: '.$styleFile);
		}

		static::$styleFile = require $styleFile;

		$data = serialize(static::$styleFile);
		file_put_contents(static::$configFile, $data);
	}
}