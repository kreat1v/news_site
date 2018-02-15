<?php
// языковые настройки

namespace App\Core;

class Localization
{
	/**
	 * @var array
	 */
	private static $messages;

	/**
	 * @var string
	 */
	private static $lang;

	/**
	 * @return mixed
	 */
	public static function getLang()
	{
		return self::$lang;
	}

	/**
	 * @param mixed $lang
	 */
	public static function setLang($lang)
	{
		if (in_array($lang, Config::get('languages'))) {
			self::$lang = $lang;
		} elseif (empty(self::$lang)){
			self::$lang = Config::get('defaultLanguage');
		}
	}

	public static function load()
	{
		$langFile = ROOT.DS.'lang'.DS.static::$lang.'.php';

		if (!file_exists($langFile)) {
			throw new \Exception('Lang file not found: '.$langFile);
		}

		static::$messages = require $langFile;
	}

	public static function get($code, $default = '')
	{
		$parts = explode('.', $code);

		return isset(static::$messages[$parts[0]][$parts[1]])
			? static::$messages[$parts[0]][$parts[1]]
			: $default;
	}

	public static function chooseLang($lang)
	{
		$controller = strtolower(App::getRouter()->getController(true));
		$action = App::getRouter()->getAction(true);
		$params = !empty(App::getRouter()->getParams()) ? '/' . implode('/', App::getRouter()->getParams()) : '';

		if (($controller === Config::get('defaultController')) && ($action === Config::get('defaultAction')) && empty($params)) {
			$controller = '';
		} else {
			$controller = '/' . $controller;
		}

		if (($action === Config::get('defaultAction')) && empty($params)) {
			$action = '';
		} else {
			$action = '/' . $action;
		}

		return '/' . $lang . $controller . $action . $params;
	}
}