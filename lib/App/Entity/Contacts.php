<?php

namespace App\Entity;

class Contacts extends Base
{
	public function getTableName()
	{
		return 'feedback';
	}

	public function checkFields($data)
	{
		foreach ($data as $value) {
			if (empty($value)) {
				throw new \Exception('Form fields can not be empty');
			}
		}
	}

	public function getFields()
	{
		return [
			'id',
			'name',
			'email',
			'messages',
			'id_user'
		];
	}
}