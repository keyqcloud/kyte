<?php

namespace Kyte;

/*
 * Class Session
 *
 * @package RizeCreate
 *
 */

class SessionManager
{
	private $session;

	public function __construct() {
		$this->session = new \Kyte\Session();
	}

	public function create($email, $password)
	{
		if (isset($email, $password)) {

			// verify user
			$user = new \Kyte\Account;

			if (!$user->retrieve('email', $email)) {
				throw new \Exception("Invalid email or password.");
			}

			if (!password_verify($password, $user->getParam('password'))) {
				throw new \Exception("Invalid email or password.");
			}

			// delete existing session
			if ($this->session->retrieve('uid', $user->getParam('id'))) {
				$this->session->delete();
			}

			$time = time();
			$exp_time = $time+(60*60);
			$token = base64_encode(hash_hmac('sha256', $user->getParam('id').'-'.$time, $exp_time));
			// create new session
			$res = $this->session->create([
				'uid' => $user->getParam('id'),
				'create_date' => $time,
				'exp_date' => $exp_time,
				'token' => $token,
			]);
			if (!$res) {
				throw new \Exception("Unable to create session.");
			}

			return $token;
		} else throw new \Exception("Session name was not specified.");
		
	}

	public function validate($token)
	{
		if (!$this->session->retrieve('token', $token)) {
			throw new \Exception("No valid session.");
		}
		$user = new \Kyte\Account();
		if (!$user->retrieve('id', $session->getParam('uid'))) {
			throw new \Exception("Invalid session.");
		}
		if (time() > $this->session->getParam('exp_date')) {
			throw new \Exception("Session expired.");
		}
		$time = time();
		$exp_time = $time+(60*60);
		// $token = base64_encode(hash_hmac('sha256', $user->getParam('id').'-'.$time, $exp_time));
		$this->session->save([
			'create_date' => $time,
			'exp_date' => $exp_time,
		]);
		return $token;
	}

	public function destroy() {
		if (!$this->session) {
			throw new \Exception("No valid session.");
		}
		$this->session->delete();
		return true;
	}
}

?>
