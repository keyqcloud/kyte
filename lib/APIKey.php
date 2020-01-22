<?php

namespace Kyte;

class APIKey extends BaseObject {

	protected static function getTable() {
		return [
			'name'		=> 'Account',
			'struct'	=> [
				[
					'id'			=> [
						'type'		=> 'i',
						'required'	=> true,
					],

					'domain'		=> [
						'type'		=> 's',
						'required'	=> true,
					],

					'public_key'	=> [
						'type'		=> 's',
						'required'	=> true,
					],

					'secret_key'	=> [
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
