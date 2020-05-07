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
	private $user;

	public function __construct($session_model, $account_model) {
		$this->session = new \Kyte\ModelObject($session_model);
		$this->user = new \Kyte\ModelObject($account_model);
	}

	protected function generateTxToken($time, $exp_time) {
		if ($this->user) {
			return hash_hmac('sha256', $this->user->getParam('id').'-'.$time, $exp_time);
		} else return 0;
	}

	protected function generateSessionToken() {
		if ($this->user) {
			$bytes = random_bytes(5);
			return hash_hmac('sha256', $this->user->getParam('email'), bin2hex($bytes));
		} else return 0;
	}

	public function create($email, $password)
	{
		if (isset($email, $password)) {

			// verify user
			if (!$this->user->retrieve('email', $email)) {
				throw new \Exception("Invalid email or password.");
			}

			if (!password_verify($password, $this->user->getParam('password'))) {
				throw new \Exception("Invalid email or password.");
			}

			// delete existing session
			if ($this->session->retrieve('uid', $this->user->getParam('id'))) {
				$this->session->delete();
			}

			$time = time();
			$exp_time = $time+(60*60);
			// create new session
			$res = $this->session->create([
				'uid' => $this->user->getParam('id'),
				'create_date' => $time,
				'exp_date' => $exp_time,
				'sessionToken' => $this->generateSessionToken(),
				'txToken' => $this->generateTxToken($time, $exp_time),
			]);
			if (!$res) {
				throw new \Exception("Unable to create session.");
			}

			// return params for new session after successful creation
			return $this->session->getAllParams();
		} else throw new \Exception("Session name was not specified.");
		
	}

	public function validate($txToken, $sessionToken, $new = true)
	{
		if (!$this->session->retrieve('txToken', $txToken, [[ 'field' => 'sessionToken', 'value' => $sessionToken ]])) {
			throw new \Exception("No valid session.");
		}
		
		if (!$this->user->retrieve('id', $this->session->getParam('uid'))) {
			throw new \Exception("Invalid session.");
		}
		if (time() > $this->session->getParam('exp_date')) {
			throw new \Exception("Session expired.");
		}
		$time = time();
		$exp_time = $time+(60*60);
		if ($new) {
			$txToken = $this->generateTxToken($time, $exp_time);
		}
		$this->session->save([
			'create_date' => $time,
			'exp_date' => $exp_time,
			'sessionToken' => $sessionToken,
			'txToken' => $txToken,
		]);
		return $this->session->getAllParams();
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
