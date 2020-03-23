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
	private $key = null;

	// override parent constriuctor
	public function __construct($model) {
		$this->key = new \Kyte\ModelObject($model);
	}

	// if origin is left null then origin validation is skipped
	public function init($public_key, $origin = null)
	{
		if (isset($public_key)) {
			if (!$this->key->retrieve('public_key', $public_key)) throw new \Exception("API key not found.");
			if (isset($origin)) {
				if ($this->key->getParam('domain') != $origin) throw new \Exception("Origin does not match registered domain.");
			}
		} else throw new \Exception("API key is required.");
		
	}

	public function validate($signature, $time)
	{
		if (!$this->key) throw new \Exception("Object not initialized.");

		if (isset($signature, $time)) {
			$hash1 = hash_hmac('SHA256', $time, $this->key->getParam('secret_key'), true);
			$hash2 = hash_hmac('SHA256', $this->key->getParam('domain'), $hash1, true);
			$calculated_signature = hash_hmac('SHA256', $this->key->getParam('public_key'), $hash2);

			if ($calculated_signature != $signature)
				throw new \Exception("Calculated signature does not match provided signature.");
				
			if (time() > $time + (60*30)) {
				throw new \Exception("API request has expired.");
			}

			return true;
			
		} else throw new \Exception("Signature and time are required.");

		throw new \Exception("Invalid API request.");
	}
}

?>
