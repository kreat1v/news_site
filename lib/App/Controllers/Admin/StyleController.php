<?php

namespace App\Controllers\Admin;

use App\Controllers\Base;
use \App\Core\Style;
use \App\Core\App;

class StyleController extends Base

{
	protected $data;

	public function indexAction()
	{
		if (Style::getStyle()) {
			if (Style::getStyle() == 'style') {
				$this->data = 'you have chosen free mode settings';
			} else {
				$this->data = Style::getStyle();
			}
		} else {
			$this->data = 'default';
		}
	}

	public function editAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$colorHeader = $_POST['colorHeader'];
				$colorBody = $_POST['colorBody'];

				Style::set('header.background-color', $colorHeader);
				Style::set('body.background-color', $colorBody);

				App::getSession()->addFlash('Your color theme is set up.');
				App::getRouter()->redirect(App::getRouter()->buildUri('index'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}
	}

	public function themeAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				if (!empty($_POST['theme'])) {
					Style::setStyle($_POST['theme']);
					App::getSession()->addFlash('Your color theme is set up.');
				} else {
					App::getSession()->addFlash('Что то пошло не так');
				}

				App::getRouter()->redirect(App::getRouter()->buildUri('index'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}
	}

	public function defaultAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				Style::set('header.background-color', '');
				Style::set('body.background-color', '');

				App::getSession()->addFlash('Your color theme is set up.');
				App::getRouter()->redirect(App::getRouter()->buildUri('index'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}
	}
}