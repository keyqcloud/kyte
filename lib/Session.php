<?php

namespace Kyte;

class Session extends BaseObject {

	protected static function getTable() {
		return [
			'name'		=> 'Account',
			'struct'	=> [
				[
					'id'			=> [
						'type'		=> 'i',
						'required'	=> true,
					],

					'uid'		=> [
						'type'		=> 'i',
						'required'	=> true,
					],

					'create_date'	=> [
						'type'		=> 'i',
						'required'	=> true,
					],

					'exp_date'		=> [
						'type'		=> 'i',
						'required'	=> true,
					],

					'token'		=> [
						'type'		=> 's',
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
