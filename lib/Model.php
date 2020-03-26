<?php

namespace Kyte;

/*
 * Class Model
 *
 * @package Kyte
 *
 */

class Model
{
	protected $model;

	public $objects = [];

	public function __construct($model) {
		$this->model = $model;
	}

	public function retrieve($field = null, $value = null, $isLike = false, $conditions = null, $all = false)
	{
		try {
			$dataObjects = array();
			$data = array();

			if (isset($field, $value)) {
				if ($isLike) {
					$sql = "WHERE `$field` LIKE '$value'";
				} else {
					$sql = "WHERE `$field` = '$value'";
				}

				if (!$all) {
					$sql .= " AND `deleted` = '0'";
				}

				if(isset($conditions)) {
					foreach($conditions as $condition) {
						$sql .= " AND `{$condition['field']}` = '{$condition['value']}'";
					}
				}
				$data = DBI::select($this->model['name'], null, $sql);
			} else {
				$data = $all ? DBI::select($this->model['name'], null, null) : DBI::select($this->model['name'], null, "WHERE `deleted` = '0'");
			}

			foreach ($data as $item) {
				$obj = new \Kyte\ModelObject($this->model);
				$obj->retrieve('id', $item['id'], null, null, $all);
				$dataObjects[] = $obj;
			}

			$this->objects = $dataObjects;

			return true;
		} catch (\Exception $e) {
			throw $e;
			return false;
		}
	}

	/*
	 * Returns array count of objects in Model
	 *
	 */
	public function count()
	{
		return count($this->objects);
	}

	public function returnFirst()
	{
		if ($this->count() > 0) {
			return $this->objects[0];
		}
		return null;
	}

	protected function clearModel()
	{
		$this->objects = [];
	}
}
?>
