<?php

namespace App\Controllers;

use App\Entity\Subscription;
use App\Entity\Category;
use App\Core\App;

class SubscriptionController extends Base
{
	private $subscriptionModel;
	private $categoryModel;

	public function __construct(array $params = [])
	{
		parent::__construct( $params );

		$this->subscriptionModel = new Subscription(App::getConnection());
		$this->categoryModel = new Category(App::getConnection());
	}

	public function indexAction()
	{
		$this->data['cat'] = $this->categoryModel->list();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			try {
				$this->data['post'] = [
					'email' => $_POST['email'],
					'categories' => implode(', ', $_POST['category'])
				];

				$this->subscriptionModel->save($this->data['post']);

				App::getSession()->addFlash('Thanks for subscribing!');
				App::getRouter()->redirect(App::getRouter()->buildUri('.'));
			} catch (\Exception $exception) {
				App::getSession()->addFlash($exception->getMessage());
			}
		}
	}
}