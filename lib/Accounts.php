<?php

namespace Kyte;

class Accounts extends Collection {

	public static function getTable() {
		return [
			'name'		=> 'Account',
			'struct'	=> [
				[
					'id'		=> [
						'type'		=> 'i',
						'required'	=> true,
					],

					'name'		=> [
						'type'		=> 's',
						'required'	=> true,
					],

					'email'		=> [
						'type'		=> 's',
						'required'	=> true,
					],

					'password'	=> [
						'type'		=> 's',
						'required'	=> true,
					],

					'role_id'	=> [
						'type'		=> 'i',
						'required'	=> true,
					],
				],
			],
		];
	}

	// override parent constriuctor
	public function __construct() {
		$this->table = static::getTable();
	}

}

?>
