<?php

namespace App\Entity;

class Tags extends Base
{
	public function getTableName()
	{
		return 'tags';
	}

	public function checkFields($data) {}

	public function getFields()
	{
		return [
			'id',
			'title'
		];
	}

	public function getTags(string $id)
	{
		if (empty($id)) {
			return null;
		}

		$sql = 'SELECT * FROM ' .  $this->getTableName() . ' WHERE id IN ('. $id .')';
		$result = $this->conn->query($sql);

		return isset($result) ? $result : null;
	}
}