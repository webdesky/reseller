<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	function sendPushNotification_1($data)
	{
		/*
			Notification fields:

			booking_id, from_id, to_id, title, message, msg_type, icon, total_price, book_sal, device_type, reg_id 
		*/

		$not = array();
		$paylod = array();
		$msg = array();

		/* Set Notification data according to device and msg type  */
		if($data["msg_type"] == "notification")
		{
			if($data["device_type"] == "ios" || $data["device_type"] == "iOS")
			{
				$not["title"] = $data["title"];
				$not["body"] = $data["message"];
			}else
			{
				$not["title"] = $data["title"];
				$not["body"] = $data["message"];
				
				if(!empty($data["icon"]))
				{
					$not["icon"] = $data["icon"];
				}
			}
		}else
		{
			if($data["device_type"] == "ios" || $data["device_type"] == "iOS")
			{
				$paylod["title"] = $data["title"];
				$paylod["body"] = $data["message"];
				
				if(isset($data["from_id"]))
				{
					$paylod["from_id"] = $data["from_id"];
				}

				if(isset($data["to_id"]))
				{
					$paylod["to_id"] = $data["to_id"];
				}

				if(isset($data["booking_id"]))
				{
					$paylod["booking_id"] = $data["booking_id"];
				}

				if(isset($data["icon"]))
				{
					$paylod["icon"] = $data["icon"];
				}
				
				if(isset($data["total_price"]))
				{
					$paylod["total_price"] = $data["total_price"];
				}

				if(isset($data["book_sal"]))
				{
					$paylod["book_sal"] = $data["book_sal"];
				}
			}else
			{
				$paylod["'title'"] = "'".$data["title"]."'";
				$paylod["'body'"] = "'".$data["message"]."'";
				
				if(isset($data["from_id"]))
				{
					$paylod["'from_id'"] = "'".$data["from_id"]."'";
				}

				if(isset($data["to_id"]))
				{
					$paylod["'to_id'"] = "'".$data["to_id"]."'";
				}

				if(isset($data["booking_id"]))
				{
					$paylod["'booking_id'"] = "'".$data["booking_id"]."'";
				}

				if(isset($data["icon"]))
				{
					$paylod["'icon'"] = "'".$data["icon"]."'";
				}
				
				if(isset($data["total_price"]))
				{
					$paylod["'total_price'"] = "'".$data["total_price"]."'";
				}

				if(isset($data["book_sal"]))
				{
					$paylod["'book_sal'"] = "'".$data["book_sal"]."'";
				}
			}
		}

		$msg["registration_ids"] = $data["reg_id"];

		if(!empty($not))
		{
			$msg["notification"] = $not;
		}
		if(!empty($paylod))
		{
			$msg["data"] = $paylod;
		}
		file_put_contents('uploads/Output_jay.TXT', json_encode($msg));
		//echo json_encode($msg); die();

		// Set CURL request headers 
    	$headers = array( 
                        'Authorization: key=' . PUSH_API_KEY,
                        'Content-Type: application/json'
                    );
		
		// Initialize curl handle       
	    $ch = curl_init();

	    // Set URL to GCM push endpoint     
	    //curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');

	    curl_setopt($ch, CURLOPT_URL, PUSH_URL);

	    // Set request method to POST       
	    curl_setopt($ch, CURLOPT_POST, true);

	    // Set custom request headers       
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	    // Get the response back as string instead of printing it       
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    // Set JSON post data
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    // Actually send the request    
	    echo $result = curl_exec($ch);

	    // Handle errors
	    /*if (curl_errno($ch)) {
	        echo 'GCM error: ' . curl_error($ch);
	    }*/

	    // Close curl handle
	    curl_close($ch);

	    // Debug GCM response       
	    $resp = (array) json_decode($result);
	    //return $resp;
	}

	function sendPushNotification($data, $reg_id) 
	 {
	     
	     //$apiKey = "AIzaSyDPCopYdGvG3xhc32EKRDZJ7jANrz6N9F8";
	     $apiKey = "AIzaSyBoDFjyfCA1sFo8pQBGnMV_dUNw1faGzL8";
	     $post = array(
	                     //'to'  => $reg_id,
	                     'registration_ids' => array($reg_id),
	                     'notification' => $data
	                     //'data' => $data
	                  );

	     
	     // Set CURL request headers 
	     $headers = array( 
	                         'Authorization: key= ' . $apiKey,
	                         'Content-Type: application/json'
	                     );

	     // Initialize curl handle       
	     $ch = curl_init();

	     // Set URL to GCM push endpoint     
	     //curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');

	     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

	     // Set request method to POST       
	     curl_setopt($ch, CURLOPT_POST, true);

	     // Set custom request headers       
	     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	     // Get the response back as string instead of printing it       
	     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	     // Set JSON post data
	     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
	     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	     // Actually send the request    
	     $result = curl_exec($ch);

	     // Handle errors
	     if (curl_errno($ch)) {
	         echo 'GCM error: ' . curl_error($ch);
	     }

	     // Close curl handle
	     curl_close($ch);

	     // Debug GCM response       
	     //echo "<pre>"; 
	     //print_r((array)json_decode($result));
	 }

	function pp($data)
	{
		echo "<pre>"; print_r($data); die();
	}


?>