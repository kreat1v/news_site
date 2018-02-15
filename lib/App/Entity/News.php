<?php

namespace App\Entity;

class News extends Base
{
	public function getTableName()
	{
		return 'news';
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
			'id_category',
			'date',
			'title',
			'content',
			'tag',
			'img_dir',
			'views'
		];
	}

	public function getSection($limit, $limitStart, $where = null, $value = null)
	{
		$strWhere = '';

		if ($where && $value) {
			$strWhere = ' WHERE ' . $where . ' = '. $value;
		}

		$sql = 'SELECT * FROM ' . $this->getTableName() . $strWhere . ' ORDER BY id DESC LIMIT ' . $limit . ' OFFSET ' . $limitStart;

		return $this->conn->query($sql);
	}

	// получение определенных новостей из таблицы по id
	public function getNews(string $id, $limit, $limitStart)
	{
		if (empty($id)) {
			return null;
		}

		$sql = 'SELECT * FROM ' .  $this->getTableName() . ' WHERE id IN ('. $id .') ORDER BY id DESC LIMIT ' . $limit . ' OFFSET ' . $limitStart;
		$result = $this->conn->query($sql);

		return isset($result) ? $result : null;
	}
}