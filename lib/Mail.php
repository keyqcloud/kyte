<?php

namespace Kyte;

class Mail {
	private static $sendgridAPIKey;

	/*
	 * Sets API key for SendGrid
	 *
	 * @param string $dbName
	 */
	public static function setSendGridAPIKey($key)
	{
		self::$sendgridAPIKey = $key;
	}

	/*
	 * Send email via SendGrid
	 *
	 * @param array $to
	 * @param string $from_email
	 * @param string $from_name
	 * @param string $subject
	 * @param string $body
	 */
	public static function email($to, $from_email, $from_name, $subject, $body)
	{
		$sg = new \SendGrid(self::$sendgridAPIKey);

		$email = new \SendGrid\Mail\Mail();
		$email->setFrom($from_email, $from_name);
		$email->setSubject($subject);
		foreach ($to as $address => $name) {
			$email->addTo($address, $name);
		}
		$email->addContent("text/plain", $body);

		$response = $sg->send($email);
	}
}

?>
