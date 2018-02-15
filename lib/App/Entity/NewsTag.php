<?php

namespace App\Entity;

class NewsTag extends Base
{
	public function getTableName()
	{
		return 'news_tag';
	}

	public function checkFields($data) {
//		if (empty($data)) {
//			throw new \Exception('Please select at least one tag.');
//		}
	}

	public function getFields()
	{
		return [
			'id',
			'id_news',
			'id_tags'
		];
	}

	public function saveTags($data, $idNews)
	{
		$this->conn->escape($idNews);

		$idNews = intval($idNews);
		$sql = 'DELETE FROM ' .  $this->getTableName() . ' WHERE id_news = ' . $idNews;
		$this->conn->query($sql);

		$values = [];
		foreach ($data as $val) {
			$this->conn->escape($val);
			$values[] = $val;
		}

		$sql = "INSERT INTO " . $this->getTableName() . " (id_news, id_tags) VALUES (?, ?)";

		foreach ($values as $val){
			$this->conn->query($sql, [$idNews, $val]);
		}

		return true;
	}
}