<?php

namespace Kyte;

class Account extends BaseObject {

	// override parent constriuctor
	public function __construct() {
		$this->table = \Kyte\Accounts::getTable();
	}
}

?>
