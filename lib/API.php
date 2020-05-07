<?php

namespace Kyte;

/*
 * Class Session
 *
 * @package Kyte
 *
 */

class API
{
	public $key = null;

	// override parent constriuctor
	public function __construct($model) {
		$this->key = new \Kyte\ModelObject($model);
	}

	// if origin is left null then origin validation is skipped
	public function init($public_key)
	{
		if (isset($public_key)) {
			if (!$this->key->retrieve('public_key', $public_key)) throw new \Exception("API key not found.");
		} else throw new \Exception("API key is required.");
	}
}

?>
