<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// require APPPATH . '/libraries/REST_Controller.php';
 //require APPPATH . '/libraries/twilio-php-master/Twilio/autoload.php';
//require APPPATH . '/libraries/twilio-php-master/Twilio/autoload.php';
//use Twilio\Rest\Client;

if ( ! function_exists('send_mail'))

{

	function send_mail($message, $subject, $email_address)

	{          

	    $ci =&get_instance();

		$ci->load->library('email');

		$config['mailtype']='html';

		$ci->email->initialize($config);	

		$ci->email->from('nirbhay@espsofttech.com');

		$ci->email->to($email_address);

		$ci->email->subject($subject);

        $ci->email->message($message);

        

		if($ci->email->send()) {	

			return true;

		} else {

			return false;

		}

	}

}



if(!function_exists('p')) {

	function p($array) {

		echo '<pre>';

		print_r($array);

		echo '</pre>';
		die();

	}

}

if(!function_exists('sendEmail')) {

    function sendEmail($to,$subject,$message) {
        try {
            
            $headers = "Reply-To: The User <". SENDER_EMAIL .">\r\n"; 
            //$headers .= "Return-Path: The Sender <sender@sender.com>\r\n"; 
            $headers .= "From: The6Deals <". SENDER_EMAIL .">\r\n"; 
            $headers .= "Organization: ". ORGANIZATION ."\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "X-Priority: 3\r\n";
            $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
            
            if(mail($to,$subject,$message,$headers))
            {
              return true;
            }else
            {
              return false;
            }   
        } catch (Exception $e) {
        	return false;
            //echo $e->getMessage();
        }
    }
}

if(!function_exists('sendMailWithAttachment')) {
  	function sendMailWithAttachment($mail,$subject,$pathToUploadedFile,$message)
  	{
  		$ci =&get_instance();

  		//$ci->email->clear(TRUE);
	    //$ci->email->set_header('MIME-Version', 1.0);
	    //$ci->email->set_header('Organization', ORGANIZATION);
	    //$ci->email->set_header('X-Priority', 3);

	    //$ci->email->set_header('X-Mailer', "PHP". phpversion());
	    //$this->email->set_header('Content-Type', 'multipart/mixed');
	    //$ci->email->set_header('Content-type', 'text/html');
	    //$ci->email->set_header('charset', 'iso-8859-1');
	    
	    $config['mailtype'] = 'html';
	    $config['charset'] = 'iso-8859-1';
	    $ci->load->library('email');
		$ci->email->initialize($config);
		

	    $ci->email->reply_to(SENDER_EMAIL, 'Gooddeedmap');
	    $ci->email->from(SENDER_EMAIL, 'Gooddeedmap');
	    $ci->email->to($mail);
	    $ci->email->subject($subject);
	    if($pathToUploadedFile != "")
	    {
	    	$ci->email->attach($pathToUploadedFile);
	    }
	    $ci->email->message($message);
	    if($ci->email->send()) {	

			return true;

		} else {

			return false;

		}
  	}
 }





if(!function_exists('check_required_value')) {

	function check_required_value($chk_params, $converted_array) {

        foreach ($chk_params as $param) {

            if (array_key_exists($param, $converted_array) && ($converted_array[$param] != '')) {

                $check_error = 0;

            } else {

                $check_error = array('check_error' => 1, 'param' => $param);

                break;

            }

        }

        return $check_error;

	}

}



if(!function_exists('send_apn_notification')) {

	function send_apn_notification($deviceToken, $message) {

		//$deviceToken = '5c96f8747d856c8c938a71a17802aea963a19f0a36b3916f054ec833534b2e50';



		// Put your private key's passphrase here:

		$passphrase = '123456';



		$ctx = stream_context_create();

		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');

		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);



		// Open a connection to the APNS server

		$fp = stream_socket_client(APNS_GATEWAY_URL, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);



		if (!$fp) {

			log_message('apn_debug',"APN: Maybe some errors: $err: $errstr");

			//exit("Failed to connect: $err $errstr" . PHP_EOL);

		} else {

			log_message('apn_debug',"Connected to APNS");

			//echo 'Connected to APNS' . PHP_EOL;

		}



		// Create the payload body

		$body['aps'] = array(

			'alert' => $message,

			'sound' => 'default'

			);



		// Encode the payload as JSON

		$payload = json_encode($body);



		// Build the binary notification

		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;



		// Send it to the server

		$result = fwrite($fp, $msg, strlen($msg));



		if (!$result) {

			log_message('apn_send_debug',"APN: Message not delivered");

			//echo 'Message not delivered' . PHP_EOL;

		} else {

			log_message('apn_send_debug',"APN: Message successfully delivered");

			//echo 'Message successfully delivered' . PHP_EOL;

		}



		// Close the connection to the server

		fclose($fp);

	}

}



if(!function_exists('send_apn_notification_old')) {

	function send_apn_notification_old()

	{	

		$ci =&get_instance();

	    $ci->load->library('apn');

	    $ci->apn->payloadMethod = 'enhance'; // you can turn on this method for debuggin purpose

	    $ci->apn->connectToPush();

	    $device_token = '5c96f8747d856c8c938a71a17802aea963a19f0a36b3916f054ec833534b2e50';

	    /* My access Token */

	    //$device_token = '232b43ca4c5926a1ad9f255f80a3c6cfe9a650c9c5bf9455290d9bd79bcebf03';



	    // adding custom variables to the notification

	    $ci->apn->setData(array( 'someKey' => true ));



	    $send_result = $ci->apn->sendMessage($device_token, 'Test Message', /*badge*/ 2, /*sound*/ 'default');



	    if($send_result)

	        log_message('debug','Sending successful');

	    else

	        log_message('error',$ci->apn->error);





	    $ci->apn->disconnectPush();

	}

}



if(!function_exists('apn_feedback')) {

	// designed for retreiving devices, on which app not installed anymore

	function apn_feedback()

	{	

		$ci =&get_instance();

	    $ci->load->library('apn');



	    $unactive = $ci->apn->getFeedbackTokens();



	    if (!count($unactive))

	    {

	        log_message('info','Feedback: No devices found. Stopping.');

	        return false;

	    }



	    foreach($unactive as $u)

	    {

	        $devices_tokens[] = $u['devtoken'];

	    }

	    //p($unactive);

	}

}



if(!function_exists('send_gcm_notification')) {

	function send_gcm_notification() {

		$ci =&get_instance();

		// simple loading

    	// note: you have to specify API key in config before

        $ci->load->library('gcm');



	    // simple adding message. You can also add message in the data,

	    // but if you specified it with setMesage() already

	    // then setMessage's messages will have bigger priority

        $ci->gcm->setMessage('Test message '.date('d.m.Y H:s:i'));



    	// add recepient or few

        $ci->gcm->addRecepient('RegistrationId');

        $ci->gcm->addRecepient('New reg id');



    	// set additional data

        $ci->gcm->setData(array(

            'some_key' => 'some_val'

        ));



    	// also you can add time to live

        $ci->gcm->setTtl(500);

    	// and unset in further

        $ci->gcm->setTtl(false);



    	// set group for messages if needed

        $ci->gcm->setGroup('Test');

    	// or set to default

        $ci->gcm->setGroup(false);



    	// then send

        if ($ci->gcm->send())

            echo 'Success for all messages';

        else

            echo 'Some messages have errors';



    	// and see responses for more info

        p($ci->gcm->status);

        p($ci->gcm->messagesStatuses);



    	die(' Worked.');

	}

}



if(!function_exists('humanTiming')) {

	function humanTiming($time)

	{

	    $time = time() - $time; // to get the time since that moment

	    $time = ($time<1)? 1 : $time;

	    $tokens = array (

	        31536000 => 'y',

	        2592000 => 'm',

	        604800 => 'w',

	        86400 => 'd',

	        3600 => 'h',

	        60 => 'min',

	        1 => 'sec'

	    );



	    foreach ($tokens as $unit => $text) {

	        if ($time < $unit) continue;

	        $numberOfUnits = floor($time / $unit);

	        return $numberOfUnits.' '.$text;

	    }



	}

}



if(!function_exists('is_logged_in')) {

	function is_logged_in($return_uri = '') {

	    $ci =&get_instance();

		$admin_login = $ci->session->userdata('admin_session_data');

		if(!isset($admin_login['is_logged_in']) || $admin_login['is_logged_in'] != true) {

			if($return_uri) {

				redirect('admin/login?return_uri='.urlencode(base_url().$return_uri));	

			} else {

				redirect("admin/login");	

			}		

		}		

	}

}



if(!function_exists('admin_session_data')) {

	function admin_session_data() {

		$ci =&get_instance();

		$session_data = $ci->session->userdata('admin_session_data');

		return $session_data;

	}

}



if(!function_exists('assets_url')) {

	function assets_url() {

		echo base_url().'assets/';

	}

}



if(!function_exists('load_admin_view')) {

	function load_admin_view($view_path, $data = array(), $leftBar = 'yes') {

		if(!empty($view_path)) {

			$ci =&get_instance();



			/* Load Header */

			$ci->load->view('includes/header', $data);



			/* Load sidebar */

			if($leftBar == 'yes') {

				$ci->load->view('includes/left-sidebar', $data);

			}



			/* Load content section */

			$ci->load->view($view_path, $data);



			/* Load footer */

			$ci->load->view('includes/footer', $data);

		} else {

			show_error('Unable to load content view, please check again.');

		}

	}

}



if(!function_exists('add_active_class')) {

	function add_active_class($class) {

		$ci =&get_instance();

		$currentMethod = $ci->router->fetch_method();

		if($currentMethod == $class) {

			echo 'active';

		}

	}

}



if(!function_exists('sendEmail')) {

    function sendEmail($emailData) {

        try {

            $email = $emailData['email'];

            $body = $emailData['template_data'];;

            

            $from_name = "Espsofttech.com";

            $headers = "From: ".$from_name."<noreply@espsofttech.com>\r\n";

            $headers.= "MIME-Version: 1.0\r\n";

            $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            @mail($email,$emailData['subject'],$body,$headers);

            

            return 1;

        } catch (Exception $e) {

            echo $e->getMessage();

        }

    }

}



if(!function_exists('generate_forgot_code')) {

    function generate_forgot_code($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];

        }

        return $randomString;

    }

}

/*function for send otp*/

if(!function_exists('send_otp')) 
{
	function send_otp($otp,$mobile)
	{
			// Authorisation details
		$ch = curl_init();
		$user="pushpendra@espsofttech.com:push4123";
		$receipientno=$mobile;
		$senderID="TEST SMS";
		$msgtxt="this is test message , test";
		curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
		$buffer = curl_exec($ch);
		if(empty ($buffer))
		{ echo " buffer is empty "; }
		else
		{ echo $buffer; }
		curl_close($ch);
			}

}

/* for url decode format */

function formatData($data)
{
 foreach($data as $key => $val)
 {
  if(!is_array($val))
  {
   $data[$key] = urldecode($val);
  }else
  {
   $data[$key] = formatData($val);
  }
 }

 return $data; 
}
/* for generate random password*/
function random_password() 
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $password = array(); 
    $alpha_length = strlen($alphabet) - 1; 
    for ($i = 0; $i < 8; $i++) 
    {
        $n = rand(0, $alpha_length);
        $password[] = $alphabet[$n];
    }
    return implode($password); 
}
function setUserLang($user_id)
{
	$ci =&get_instance();
	$user_data = $ci->db->get_where("users",array("id" => $user_id))->row_array();
	if(!empty($user_data))
	{
		$user_lang = $user_data["user_lang"];
	}else
	{
		//$user_lang = 2;
		$user_lang = 1;
	}
	$GLOBALS['user_lang'] = $user_lang;
	return $user_lang;
}


function __webtxt($word)
{
	global $user_lang;

	$ci =&get_instance();
	
	$data = $ci->db->get_where("webtexts",array("lang_id" => $user_lang,"text_eng" => $word))->row_array();
	$word = $data["text_lang"];
	return $word;
}
 function smsapi($otp,$mobile)
    {

      /* End of file common_helper.php */
      // Your Account SID and Auth Token from twilio.com/console
      $sid = 'ACf3c15917b08e13ca3ae4c5bb91839065';
      $token = '57bd920870e7a35862931fcf3333cd86';
      $client = new Client($sid, $token);

      // Use the client to do fun stuff like send text messages!
      $client->messages->create(
          // the number you'd like to send the message to
          '+972'.$mobile,
          array(
              // A Twilio phone number you purchased at twilio.com/console
              'from' => '+972526285726',
              // the body of the text message you'd like to send
              'body' => $otp. "Please verify this otp in v12mobile"
          )
      );
    }

/*twillo sms api*/
function send_smtp_mail($message, $subject, $email_address,$from)
{
 
		$ci =&get_instance();

		$ci->load->library('email');

		$config['mailtype'] = 'html';
	    $config['charset'] = 'iso-8859-1';

		$ci->email->initialize($config);	

		$ci->email->from("info@chalkboardcatering.net",'Chalkboard');

		$ci->email->to($email_address);

		$ci->email->subject($subject);

        $ci->email->message($message);

        

		if($ci->email->send()) {	

			return true;

		} else {

			return false;

		}

}
/*end twilllo sms api*/
/* Location: ./system/application/helpers/common_helper.php */