<?php

namespace App\Core;

use App\Core\DB\Connection;

class App
{
	/** @var Router */
	private static $router;

	/** @var DB\IConnection */
	private static $conn;

	/** @var Session */
	private static $session;

	/**
	 * @return Session
	 */
	public static function getSession(): Session
	{
		return self::$session;
	}

	/**
	 * @return Router
	 */
	public static function getRouter(): Router
	{
		return self::$router;
	}

	/**
	 * @return DB\IConnection
	 */
	public static function getConnection(): DB\IConnection
	{
		return self::$conn;
	}

	/**
	 * @throws \Exception
	 * @param $uri
	 */
	public static function run($uri)
	{
		// Подключение к базе данных.
		static::$conn = new Connection(
			Config::get('db.host'),
			Config::get('db.user'),
			Config::get('db.password'),
			Config::get('db.name')
		);

		static::$router = new Router($uri);

		static::$session = Session::getInstance();

		$route = static::$router->getRoute();
		$className = static::$router->getController();
		$action = static::$router->getAction();
		$params = static::$router->getParams();

		Style::load();

		Localization::setLang(static::$router->getLang());
		Localization::load();

		$controllerName = '\App\Controllers\\'
			.($route !== Config::get('defaultRoute') ? 'Admin\\' : '')
			.$className;

		if (!class_exists($controllerName)) {
			throw new \Exception('Controller '.$controllerName.' not found');
		}

		/** @var \App\Controllers\Base $controller */
		$controller = new $controllerName($params);

		// Если юзер не админ, то админский раздел не доступен.
		if ($route == 'admin' && static::getSession()->get('role') != 'admin') {
			static::getRouter()->redirect(static::getRouter()->buildUri('default.category.index'));
		}

		// Если сессия активна, то страницы с формой регистрации и логина не доступны.
		if (static::getSession()->get('id') && (static::getRouter()->getAction(true) == 'register' || static::getRouter()->getAction(true) == 'login')) {
			static::getRouter()->redirect(static::getRouter()->buildUri('category.index'));
		}

		// Если контроллер User и сессия не активна, то доступны только страницы с формами входа и регистрации.
		if (static::getRouter()->getController(true) == 'User' && !App::getSession()->get('id')) {
			if (static::getRouter()->getAction(true) != 'register' && static::getRouter()->getAction(true) != 'login') {
				static::getRouter()->redirect(static::getRouter()->buildUri('default.user.login'));
			}
		}

		// Если контроллер Contacts и сессия не активна - доступна страница только с формой для сообщений.
		if (static::getRouter()->getController(true) == 'Contacts' && !App::getSession()->get('id')) {
			if (static::getRouter()->getAction(true) != 'index') {
				static::getRouter()->redirect(static::getRouter()->buildUri('contacts.index'));
			}
		}

		if (!method_exists($controller, $action)) {
			throw new \Exception('Action '.$action.' not found in '.$controllerName);
		}

		if (!$controller instanceof \App\Controllers\Base) {
			throw new \Exception('Controller must extend Base class');
		}

		ob_start();

		$controller->$action();

		$view = new \App\Views\Base(
			$controller->getData(),
			$controller->getTemplate()
		);
		$content = $view->render();

		Menu::getCategory();
		$category = new \App\Views\Base(
			Menu::getData(),
			ROOT.DS.'views'.DS.'menu.php'
		);
		$menu = $category->render();

		Ad::getAd('left');
		$adLeftBody = new \App\Views\Base(
			Ad::getData(),
			ROOT.DS.'views'.DS.'ad.php'
		);
		$adLeft = $adLeftBody->render();

		Ad::getAd('right');
		$adRightBody = new \App\Views\Base(
			Ad::getData(),
			ROOT.DS.'views'.DS.'ad.php'
		);
		$adRight = $adRightBody->render();

		$layout = new \App\Views\Base(
			['content' => $content,
			 'menu' => $menu,
			 'adLeft' => $adLeft,
			 'adRight' => $adRight],
			ROOT.DS.'views'.DS.$route.'.php'
		);

		echo $layout->render();

		ob_end_flush();
	}
}