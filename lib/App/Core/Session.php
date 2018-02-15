<?php

namespace App\Core;

class Session
{
	use \App\Core\Traits\Singleton;

	/**
	 * Session constructor.
	 */
	protected function __construct()
	{
		session_start();
	}

	public function destroy()
	{
		session_destroy();
	}

	public function __destruct()
	{
		session_write_close();
	}

	/**
	 * @param $key
	 * @param $value
	 */
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public static function get($key)
	{
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		} else {
			return false;
		}
	}

	/**
	 * @param $key
	 */
	public static function unset($key)
	{
		if (isset($_SESSION[$key])) {
			unset($_SESSION[$key]);
		}
	}

	/**
	 * @param $message
	 *
	 * @return void
	 */
	public static function addFlash($message)
	{
		if (!isset($_SESSION['flash']) || !is_array($_SESSION['flash'])) {
			$_SESSION['flash'] = [];
		}

		$_SESSION['flash'][] = $message;
	}

	/**
	 * @return bool
	 */
	public static function hasFlash()
	{
		return !empty($_SESSION['flash']);
	}

	/**
	 * @return array
	 */
	public static function getFlash()
	{
		$data = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];

		$_SESSION['flash'] = [];

		return $data;
	}
}