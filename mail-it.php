<?php

/* Code by David McKeown - craftedbydavid.com */
/* Editable entries are bellow */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);


$send_to = "hello@telluscoop.com";
$send_subject = "Sign up";



/*Be careful when editing below this line */

$subscribed = false;
$okMessage = 'You\'ve successfully signed up. Thank you!';
$errorMessage = 'There was an error while submitting the form. Please try again later';
$f_name = cleanupentries($_POST["name"]);
$f_email = cleanupentries($_POST["email"]);
$f_message = cleanupentries($_POST["message"]);
$from_ip = $_SERVER['REMOTE_ADDR'];
$from_browser = $_SERVER['HTTP_USER_AGENT'];

function cleanupentries($entry)
{
	$entry = trim($entry);
	$entry = stripslashes($entry);
	$entry = htmlspecialchars($entry);

	return $entry;
}

$message = "This email was submitted on " . date('m-d-Y') .
	"\n\nName: " . $f_name .
	"\n\nE-Mail: " . $f_email .
	"\n\nMessage: \n" . $f_message; //.
"\n\n\nTechnical Details:\n" . $from_ip . "\n" . $from_browser;

$send_subject .= " - {$f_name}";

$headers = "From: " . $f_email . "\r\n" .
	"Reply-To: " . $f_email . "\r\n" .
	"X-Mailer: PHP/" . phpversion();

if (!$f_email) {
	echo "no email";
	exit;
} else if (!$f_name) {
	echo "no name";
	exit;
} else {
	if (filter_var($f_email, FILTER_VALIDATE_EMAIL)) {
		//	mail($send_to, $send_subject, $message, $headers);
		try {


			//			$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'mail.telluscoop.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'mail-it@telluscoop.com';                     //SMTP username
			$mail->Password   = 'ar6Lem1c8ZfN';                               //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
			$mail->Port       = 587;

			$mail->setFrom('mail-it@telluscoop.com', $f_name);
			$mail->addAddress('hello@telluscoop.com',  'Tellus');

			// Content
			//			$mail->isHTML(true);                       // Set email format to HTML
			$mail->Subject = $send_subject;
			$mail->Body    = $message;
			//			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();


			$data_center = 'us6';
			$audience_id = 'df161e6607';
			$api_key = '3d2baf7a41b724790ef4ae22618b516a-us6';
			$url = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $audience_id . '/members';
			$user_details = [
				'email_address' => $f_email,
				'status' => 'subscribed',
				'merge_fields' => [
					'NAME' => $f_name
				]
			];
			$user_details = json_encode($user_details);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);
			curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
			curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $api_key);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $user_details);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Content-Type: application/json',
				'Content-Length: ' . strlen($user_details)
			]);
			$result = curl_exec($ch);
			$result_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($result_code === 200) {
				$subscribed = true;
			}
			if ($subscribed) {
				echo 'You have been subscribed!';
			} else {
				echo 'Something went wrong';
				exit;
			}
		} catch (\Exception $e) {
			echo $e->getMessage();
			exit;
		}
	} else {
		echo "invalid email";
		exit;
	}
}
