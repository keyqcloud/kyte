<?php

namespace Kyte;

/*
 * Class Collection
 *
 * @package Kyte
 *
 */

class Collection
{
	// key-value describing table
	// 
	//	[
	// 		'name'		=> 'name of table (also name of object)',
	// 		'struct'	=> [
	//			'column name' => [ 'type' => 'i/s/d', 'requred' => true/false ],
	//			...
	//			'column name' => [ 'type' => 'i/s/d', 'requred' => true/false ],
	//		]
	//	]
	protected $table = [];

	public $objects = [];

	public function __construct($table) {
		$this->table = $table;
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
				$data = DBI::select($this->table['name'], null, $sql);
			} else {
				$data = $all ? DBI::select($this->table['name'], null, null) : DBI::select($this->table['name'], null, "WHERE `deleted` = '0'");
			}

			foreach ($data as $item) {
				$obj = new \Kyte\BaseObject($this->table);
				$obj->retrieve('id', $item['id']);
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
	 * Returns array count of objects in collection
	 *
	 */
	public function count()
	{
		return count($this->objects);
	}

	protected function clearCollection()
	{
		$this->objects = [];
	}
}
?>
