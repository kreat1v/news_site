<?php

namespace App\Core\Traits;

trait Singleton
{
	protected static $instance = null;
	public static function getInstance()
	{
		if (static::$instance === null) {
			static::$instance = new static();
		}
		return static::$instance;
	}
	protected function __construct() {}
	protected function __clone() {}
	protected function __sleep() {}
	protected function __wakeup() {}
}