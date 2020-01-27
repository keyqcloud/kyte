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
						'date'		=> false,
					],

					'deleted'	=> [
						'type'		=> 'i',
						'required'	=> false,
						'date'		=> false,
					],

					'domain'		=> [
						'type'		=> 's',
						'required'	=> true,
						'date'		=> false,
					],

					'public_key'	=> [
						'type'		=> 's',
						'required'	=> true,
						'date'		=> false,
					],

					'secret_key'	=> [
						'type'		=> 's',
						'required'	=> true,
						'date'		=> false,
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
