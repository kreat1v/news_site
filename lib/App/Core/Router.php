<?php // Роутер - разбор строки.

namespace App\Core;

class Router
{
	protected $controller;

	protected $action;

	protected $lang;

	protected $route;

	protected $params;

	/**
	 * @return mixed
	 */
	public function getLang()
	{
		return $this->lang;
	}

	/**
	 * @param $clean
	 * @return mixed
	 */
	public function getController($clean = false)
	{
		return $this->controller . (!$clean ? 'Controller' : '');
	}

	/**
	 * @param $clean
	 * @return mixed
	 */
	public function getAction($clean = false)
	{
		return $this->action . (!$clean ? 'Action' : '');
	}

	/**
	 * @return mixed
	 */
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}

	/**
	 * Router constructor.
	 *
	 * @param string $uri
	 */
	public function __construct(string $uri)
	{
		// Получаем default настройки.
		$this->controller = Config::get('defaultController');
		$this->action = Config::get('defaultAction');
		$this->route = Config::get('defaultRoute');
		$this->lang = Config::get('defaultLanguage');

		// Получаем запрос из адрессной строки в виде массива.
		$parts = parse_url($uri);

		// Получаем массив параметров.
		$pathParts = explode(
			'/',
			trim($parts['path'], '/')
		);

		if (current($pathParts) && in_array(current($pathParts), Config::get('languages'))) {
			$this->lang = array_shift($pathParts);
		}

		if (current($pathParts) && in_array(current($pathParts), Config::get('routes'))) {
			$this->route = array_shift($pathParts);
		}

		if (current($pathParts)) {
			$this->controller = ucfirst(array_shift($pathParts));
		}

		if (current($pathParts)) {
			$this->action = array_shift($pathParts);
		}

		$this->params = $pathParts;
	}

	/**
	 * Builds uri.
	 * Метод, благодаря которому мы формируем наши ссылки с сохранением выбранного языка, а так же с сохранением не default роута.
	 *
	 * @param $path - Format - lang.route.controller.action
	 * @param $params - params array
	 * @return string
	 */
	public function buildUri($path, $params = [])
	{
		$parts = array_reverse(explode('.', $path));
		$default = [
			Config::get('defaultAction'),
			strtolower($this->getController(true)),
			$this->getRoute() !== Config::get('defaultRoute') ? $this->getRoute() : '',
			$this->getLang() !== Config::get('defaultLanguage') ? $this->getLang() : ''
		];

		$c = 0;
		$result = [];

		while ($c++ < 4) {
			$result[] = count($parts) ? array_shift($parts) : $default[$c - 1];
		}

		// prepare params
		$paramsString = count($params) ? '/' . implode('/', $params) : '';

		// remove empty parts
		$result = array_filter($result);

		return '/' . implode('/', array_reverse($result)) . $paramsString;
	}

	/**
	 * @param $uri
	 * @param int $status
	 */
	public function redirect($uri, $status = 302)
	{
		header('Location: ' . $uri, true, $status);
		die;
	}
}