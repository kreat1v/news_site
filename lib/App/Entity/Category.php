<?php

namespace App\Entity;

class Category extends Base
{
	public function getTableName()
	{
		return 'category';
	}

	public function checkFields($data)
	{
		if (!is_string($data['title']) || !strlen($data['title'])) {
			throw new \Exception('Category title can\'t be empty');
		}
	}

	public function getFields()
	{
		return [
			'id',
			'title',
			'moderation'
		];
	}
}