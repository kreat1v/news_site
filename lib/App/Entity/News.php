<?php

namespace App\Entity;

class News extends Base
{
	private $newsTag;
	private $tags;
	private $category;

	private function getNewsTag()
	{
		if (empty($this->newsTag)) {
			$this->newsTag = new NewsTag($this->conn);
		}

		return $this->newsTag;
	}

	private function getTags()
	{
		if (empty($this->tags)) {
			$this->tags = new Tags($this->conn);
		}

		return $this->tags;
	}

	private function getCategory()
	{
		if (empty($this->category)) {
			$this->category = new Category($this->conn);
		}

		return $this->category;
	}

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
			'views',
			'analytics'
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

	public function filter($filter)
	{
		$fieldsNews = $this->getTableName();
		$fieldsNewsTag = $this->getNewsTag()->getTableName();
		$fieldsTags = $this->getTags()->getTableName();
		$fieldsCategory = $this->getCategory()->getTableName();

		$analytics = $this->getCategory()->getBy('title', 'Analytics');

		$where = [];
		$category = [];
		$tags = [];

		if (!empty($filter['dateFrom'])) {
			$value = $this->conn->escape($filter['dateFrom']);
			$where[] = "news.date >= $value";
		}

		if (!empty($filter['dateTo'])) {
			$value = $this->conn->escape($filter['dateTo']);
			$where[] = "news.date <= $value";
		}

		if (!empty($filter['category'])) {
			foreach ($filter['category'] as $idCategory) {
				if ($idCategory == $analytics['id']) {
					$where[] = "news.analytics = 1";
					continue;
				}

				$idCategory = $this->conn->escape($idCategory);
				$category[] = $idCategory;
			}

			if (!empty($category)) {
				$str = implode(', ', $category);
			}

			if (!empty($str)) {
				$where[] = "news.id_category IN ($str)";
			}
		}

		if (!empty($filter['tags'])) {
			foreach ($filter['tags'] as $idTags) {
				$idTags = $this->conn->escape($idTags);
				$tags[] = $idTags;
			}

			if (!empty($tags)) {
				$str = implode(', ', $tags);
			}

			$where[] = "tags.id IN ($str)";
		}

		if (!empty($where)) {
			$strWhere = ' AND ' . implode(' AND ', $where);
		} else {
			return null;
		}

		echo $strWhere;

		$sql = "SELECT $fieldsNews.* 
				FROM $fieldsNews 
				JOIN $fieldsNewsTag ON $fieldsNews.id = $fieldsNewsTag.id_news 
				JOIN $fieldsTags ON $fieldsNewsTag.id_tags = $fieldsTags.id 
				JOIN $fieldsCategory ON $fieldsNews.id_category = $fieldsCategory.id 
				WHERE 1 $strWhere 
				GROUP BY $fieldsNews.id";
		return $this->conn->query($sql);
	}
}