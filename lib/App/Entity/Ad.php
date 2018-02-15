<?php

namespace App\Entity;

class Ad extends Base
{
	public function getTableName()
	{
		return 'ad';
	}

	public function checkFields($data)
	{
		foreach ($data as $value) {
			if (empty($value) && !strlen($value)) {
				throw new \Exception('Form fields can not be empty');
			}
		}
	}

	public function getFields()
	{
		return [
			'id',
			'side',
			'title',
			'price',
			'content'
		];
	}
}