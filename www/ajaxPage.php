<?php
 header("Access-Control-Allow-Origin: *");
//check command
if(isset($_REQUEST['cmd'])){
$cmd=$_REQUEST['cmd'];
	switch($cmd){
		case 1:
			addUser();
		break;
		case 2:
			login();
		break;
		case 3:
			addDevice();
		break;
		case 4:
			getDevices();
		break;
		case 5:
			editDevice();
		break;
		case 6:
			deleteDevice();
		break;
		case 7:
			getDeviceLocationXML();
		break;
		case 8:
			getSingleDeviceLocationXML();
		break;
		case 9:
			getDeviceLocation();
		break;
		case 10:
			getSingleDeviceLocation();
		break;
		case 11:
			findLocation();
		break;
		case 12:
			addDeviceLocation();
		break;
		case 13:
			getLocations();
		break;
		case 14:
			alertSecurity();
		break;
		case 15:
			updateNotification();
		break;
		case 16:
			addStartDeviceLocation();
		break;


		default:
			echo '{"result":0,"message":"Wrong command"}';
		break;
	}
}

function addStartDeviceLocation(){
	if(!isset($_REQUEST['deviceid'])){
		echo '{"result":0,"message":"Device is not given"}';
		return;
	}
	if($_REQUEST['deviceid']==""){
		echo '{"result":0,"message":"Device is not given"}';
		return;
	}
	if(!isset($_REQUEST['locationid'])){
		echo '{"result":0,"message":"Location is not given"}';
		return;
	}
	if($_REQUEST['locationid']==""){
		echo '{"result":0,"message":"Location is not given"}';
		return;
	}

	
	$device=$_REQUEST['deviceid'];
	$location=$_REQUEST['locationid'];

	include('user.php');
	$obj=new user();

	$currentdatetime=date("Y-m-d h:i:s")." ";
				
			
	$row=$obj->addDeviceLocation($device,$currentdatetime,	$location);
	if($row==true){
		echo '{"result":1,"message":"Device location successfully added"}';
	}

	else{
		echo '{"result":0,"message":"Device location was not added"}';
	}

}

function addUser(){
	if(!isset($_REQUEST['firstname'])){
		echo '{"result":0,"message":"First name is not given"}';
		return;
	}
	if(!isset($_REQUEST['lastname'])){
		echo '{"result":0,"message":"Last name is not given"}';
		return;
	}
	if(!isset($_REQUEST['email'])){
		echo '{"result":0,"message":"Email is not given"}';
		return;
	}
	if(!isset($_REQUEST['password'])){
		echo '{"result":0,"message":"Password is not given"}';
		return;
	}
	if(!isset($_REQUEST['phone'])){
		echo '{"result":0,"message":"Phone number is not given"}';
		return;
	}

	if($_REQUEST['firstname']==""){
		echo '{"result":0,"message":"First name is not given"}';
		return;
	}
	if($_REQUEST['lastname']==""){
		echo '{"result":0,"message":"Last name is not given"}';
		return;
	}
	if($_REQUEST['email']==""){
		echo '{"result":0,"message":"Email is not given"}';
		return;
	}
	if($_REQUEST['password']==""){
		echo '{"result":0,"message":"Password is not given"}';
		return;
	}
	if($_REQUEST['phone']==""){
		echo '{"result":0,"message":"Phone number is not given"}';
		return;
	}

	$firstname=$_REQUEST['firstname'];
	$lastname=$_REQUEST['lastname'];
	$email=$_REQUEST['email'];
	$password=$_REQUEST['password'];
	$phone=$_REQUEST['phone'];
	$notification=$_REQUEST['notification'];

	include('user.php');
	$obj=new user();
	$row=$obj->addUser($firstname, $lastname, $email, $phone,$password,$notification);

	if($row==true){
		echo '{"result":1,"message":"Sign up successful"}';
	}

	else{
		echo '{"result":0,"message":"Sign up was not successful"}';
	}

}


function login(){
	
	if(!isset($_REQUEST['email'])){
		echo '{"result":0,"message":"Email is not given"}';
		return;
	}
	if(!isset($_REQUEST['password'])){
		echo '{"result":0,"message":"Password is not given"}';
		return;
	}
	if($_REQUEST['email']==""){
		echo '{"result":0,"message":"Email is not given"}';
		return;
	}
	if($_REQUEST['password']==""){
		echo '{"result":0,"message":"Password is not given"}';
		return;
	}
	$email=$_REQUEST['email'];
	$password=$_REQUEST['password'];
	include('user.php');
	$obj=new user();
	$row=$obj->login($email, $password);
	if($row==true){
		$row=$obj->fetch();
		echo '{"result":1,"user":';
		echo json_encode($row);
		echo "}";
	}

	else{
		echo '{"result":0,"message":"Login failed"}';
	}

}
function getDevices(){
	// if(!isset($_REQUEST['id'])){
	// 	echo '{"result":0,"message":"User can not be identified"}';
	// 	return;
	// }
	// if($_REQUEST['id']==""){
	// 	echo '{"result":0,"message":"User can not be identified"}';
	// 	return;
	// }

	include('user.php');
	$obj=new user();

	if(isset($_REQUEST['id'])){
		$id=$_REQUEST['id'];
		$row=$obj->getDevices($id);
	}else{
		$row=$obj->getDevices();
	}
	
	if($row==true){
		$row=$obj->fetch();
			echo '{"result":1,"device":[';
			while($row){
				echo json_encode($row);

				$row=$obj->fetch();
				if($row!=false){
					echo ",";
				}
			}
		echo "]}";
	}

	else{
		echo '{"result":0,"message":"Error fetching devices"}';
	}

}


function addDevice(){
	if(!isset($_REQUEST['device'])){
		echo '{"result":0,"message":"Device name is not given"}';
		return;
	}
	if(!isset($_REQUEST['description'])){
		echo '{"result":0,"message":"Description is not given"}';
		return;
	}

	if(!isset($_REQUEST['tag'])){
		echo '{"result":0,"message":"Tag ID is not given"}';
		return;
	}
	// if(!isset($_REQUEST['image'])){
	// 	echo '{"result":0,"message":"Image is not given"}';
	// 	return;
	
	if($_REQUEST['device']==""){
		echo '{"result":0,"message":"Device name is not given"}';
		return;
	}
	if($_REQUEST['description']==""){
		echo '{"result":0,"message":"Description is not given"}';
		return;
	}

	if($_REQUEST['tag']==""){
		echo '{"result":0,"message":"Tag ID is not given"}';
		return;
	}
	// if($_REQUEST['image']==""){
	// 	echo '{"result":0,"message":"Image is not given"}';
	// 	return;
	// }
	
	
	$device=$_REQUEST['device'];
	$description=$_REQUEST['description'];
	
	$tag=$_REQUEST['tag'];
	$userid=$_REQUEST['userid'];
	

	if(is_array($_FILES)) {
		if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
			$sourcePath = $_FILES['userImage']['tmp_name'];
				$targetPath = "img/".$_FILES['userImage']['name'];
				if(move_uploaded_file($sourcePath,$targetPath)) {
				
					 echo $targetPath;
				
			}
		}
	}


	
	include('user.php');
	$obj=new user();

	
		$row=$obj->addDevice($device,$description, $tag, $userid);

		if($row==true){
			echo '{"result":1,"message":"Device added"}';
		}
		else{
			echo '{"result":0,"message":"Device not added"}';
		}
	

	

}


function editDevice(){
	if(!isset($_REQUEST['device'])){
		echo '{"result":0,"message":"Device name is not given"}';
		return;
	}
	if(!isset($_REQUEST['deviceid'])){
		echo '{"result":0,"message":"Device ID is not given"}';
		return;
	}
	if(!isset($_REQUEST['description'])){
		echo '{"result":0,"message":"Description is not given"}';
		return;
	}
	
	if(!isset($_REQUEST['tag'])){
		echo '{"result":0,"message":"Tag ID is not given"}';
		return;
	}
	if($_REQUEST['device']==""){
		echo '{"result":0,"message":"Device name is not given"}';
		return;
	}

	if($_REQUEST['deviceid']==""){
		echo '{"result":0,"message":"Device ID is not given"}';
		return;
	}
	if($_REQUEST['description']==""){
		echo '{"result":0,"message":"Description is not given"}';
		return;
	}

	if($_REQUEST['tag']==""){
		echo '{"result":0,"message":"Tag ID is not given"}';
		return;
	}
	
	
	$device=$_REQUEST['device'];
	$description=$_REQUEST['description'];
	$deviceid=$_REQUEST['deviceid'];
	$tag=$_REQUEST['tag'];
	$userid=$_REQUEST['userid'];

	
	include('user.php');
	$obj=new user();

	
		$row=$obj->editDevice($device,$description, $tag, $userid,$deviceid);

		if($row==true){
			echo '{"result":1,"message":"Device edited"}';
		}
		else{
			echo '{"result":0,"message":"Device not edited"}';
		}

}




function deleteDevice(){
	 if(!isset($_REQUEST['deviceid'])){
	 	echo '{"result":0,"message":"Device details cannot be found"}';
		return;
	 }
	 if($_REQUEST['deviceid']==""){
		echo '{"result":0,"message":"Device ID is not given"}';
		return;
	}
	
	 $deviceid=$_REQUEST['deviceid'];

	include('user.php');
	$obj=new user();
	$row=$obj->deleteDevice($deviceid);

	if($row==true){
		echo '{"result":1,"message":"Deletion successful"}';
	}
	else{
		echo '{"result":0,"message":"Deletion not successful"}';
	}

}

function parseToXML($htmlStr)
{
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quot;',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;
}

function getDeviceLocationXML(){

	header("Content-type: text/xml");
	echo '<markers>';
	include('user.php');
	$obj=new user();
	$row=$obj->getDeviceLocation();
	if($row==true){
		$row=$obj->fetch();
			
			while($row){
				
				echo '<marker ';
				  echo 'name="' . parseToXML($row['name']) . '" ';
				  echo 'address="' . parseToXML($row['placename']) . '" ';
				  echo 'lat="' . $row['latitude'] . '" ';
				  echo 'lng="' . $row['longitude'] . '" ';
				  echo 'type="' . $row['type'] . '" ';
				  echo '/>';
				  $row=$obj->fetch();
				}
				echo '</markers>';
			
		

	}

	else{
		echo '{"result":0,"message":"Could not fetch devices"}';
	}

}

function getDeviceLocation(){
	include('user.php');
	$obj=new user();
	$row=$obj->getDeviceLocation();
	if($row==true){
		$row=$obj->fetch();
		echo '{"result":1,"devicelocation":[';
			while($row){
				echo json_encode($row);

				$row=$obj->fetch();
				if($row!=false){
					echo ",";
				}
			}
		echo "]}";
	}

	else{
		echo '{"result":0,"message":"Could not fetch devices"}';
	}

}
function getSingleDeviceLocation(){
	 if(!isset($_REQUEST['device'])){
	 	echo '{"result":0,"message":"Place has not been selected"}';
		return;
	 }
	 if($_REQUEST['device']==""){
		echo '{"result":0,"message":"Place has not been selected"}';
		return;
	}
	
	$device=$_REQUEST['device'];
	include('user.php');
	$obj=new user();
	$row=$obj->getDeviceLocation($device);
	if($row==true){
		$row=$obj->fetch();
		echo '{"result":1,"devicelocation":[';
			while($row){
				echo json_encode($row);

				$row=$obj->fetch();
				if($row!=false){
					echo ",";
				}
			}
		echo "]}";
	}

	else{
		echo '{"result":0,"message":"Could not fetch devices"}';
	}

}

function findLocation(){
	 if(!isset($_REQUEST['locationid'])){
	 	echo '{"result":0,"message":"Location has not been selected"}';
		return;
	 }
	 if($_REQUEST['locationid']==""){
		echo '{"result":0,"message":"Location has not been selected"}';
		return;
	}
	
	$locationid=$_REQUEST['locationid'];
	include('user.php');
	$obj=new user();
	$row=$obj->getLocation($locationid);
	if($row==true){
		$row=$obj->fetch();
		echo '{"result":1,"location":[';
			while($row){
				echo json_encode($row);

				$row=$obj->fetch();
				if($row!=false){
					echo ",";
				}
			}
		echo "]}";
	}

	else{
		echo '{"result":0,"message":"Could not fetch location"}';
	}

}
function getSingleDeviceLocationXML(){
	 if(!isset($_REQUEST['place'])){
	 	echo '{"result":0,"message":"Place has not been selected"}';
		return;
	 }
	 if($_REQUEST['place']==""){
		echo '{"result":0,"message":"Place has not been selected"}';
		return;
	}
	
	 $place=$_REQUEST['place'];
	
		
	header("Content-type: text/xml");
	echo '<markers>';
	include('user.php');
	$obj=new user();
	$row=$obj->getDeviceLocation($place);
	if($row==true){
		$row=$obj->fetch();
			
			while($row){
				
				echo '<marker ';
				  echo 'name="' . parseToXML($row['name']) . '" ';
				  echo 'address="' . parseToXML($row['placename']) . '" ';
				  echo 'lat="' . $row['latitude'] . '" ';
				  echo 'lng="' . $row['longitude'] . '" ';
				  echo 'type="' . $row['type'] . '" ';
				  echo '/>';
				  $row=$obj->fetch();
				}
				echo '</markers>';
			
		

	}

	else{
		echo '{"result":0,"message":"Could not fetch devices"}';
	}

}

function addDeviceLocation(){
	if(!isset($_REQUEST['tagid'])){
		echo '{"result":0,"message":"Tag identification is not given"}';
		return;
	}
	if($_REQUEST['tagid']==""){
		echo '{"result":0,"message":"Tag identification is not given"}';
		return;
	}
	if(!isset($_REQUEST['locationid'])){
		echo '{"result":0,"message":"Location is not given"}';
		return;
	}
	if($_REQUEST['locationid']==""){
		echo '{"result":0,"message":"Location is not given"}';
		return;
	}

	
	$tag=$_REQUEST['tagid'];
	$location=$_REQUEST['locationid'];

	include('user.php');
	$obj=new user();

		$row=$obj->findDevice($tag);
		if($row==true){
			$deviceid=$obj->fetch();

			$row=$obj->getLocationWithID($location);
			if($row==true){
				$locationname=$obj->fetch();

				$currentdatetime=date("Y-m-d h:i:s")." ";
				$device=$deviceid['deviceid'];
				
			
				$row=$obj->addDeviceLocation($device,$currentdatetime,	$location);
				if($row==true){
					echo '{"result":1,"message":"Device added"}';
				}
				else{
					echo '{"result":0,"message":"Device not added"}';
				}

		}
		else{
			echo '{"result":0,"message":"Could not fetch location information"}';
			return;
		}

		if($deviceid['track']=='1'){
			$notiicationcode=$deviceid['notification'];
			
			$pushnotification=substr($notiicationcode, 0,1);
			$sms=substr($notiicationcode, 1,1);
			$email=substr($notiicationcode, 2,1);

			
			

			if($pushnotification=='1'){
				
			}
			if($sms=='1'){
				
					require './Smsgh/Api.php';

					$auth = new BasicAuth("znlltiuf", "qmidxlrw");
					// instance of ApiHost
					$apiHost = new ApiHost($auth);

					// instance of AccountApi
					$accountApi = new AccountApi($apiHost);
					// Get the account profile
					// Let us try to send some message
					$messagingApi = new MessagingApi($apiHost);
					 try {
				    // Send a quick message
					    //$messageResponse = $messagingApi->sendQuickMessage("Husby", "+2332432191768", "I love you dearly Honey. See you in the evening...");
					$currentdatetime=date("Y-m-d h:i:s")." ";
					
				

					$mesg = new Message();
					$mesg->setContent($deviceid['name']." moved to the ".$locationname['placename']." at ".$currentdatetime);
					$mesg->setTo($deviceid['phone']);
					$mesg->setFrom("Suivre App");
					$mesg->setRegisteredDelivery(false);

					   

					$messageResponse = $messagingApi->sendMessage($mesg);

					if ($messageResponse instanceof MessageResponse) {
					    echo '{"result":1,"message":"Message sent"}';
					      //   echo $messageResponse->getStatus();
					      //   echo'"';
					} elseif ($messageResponse instanceof HttpResponse) {
					    echo '{"result":0,"message":"Message not sent"}';
					}
				} catch (Exception $ex) {
					    echo $ex->getTraceAsString();
				}
			}
			if($email=='1'){
				

		    	$to = $deviceid['email']; // this is your Email address
			    $from = "efuabainson@gmail.com"; // this is the sender's Email address
			    $subject = "Suivre App Alert";
			    $subject2 = "Copy of Suivre App Alert";
			    $message = $deviceid['name']." moved to the ".$locationname['placename']." at ".$currentdatetime;
			    $message2 = $deviceid['name']." moved to the ".$locationname['placename']." at ".$currentdatetime;

			    $headers = "From:" . $from;
			    $headers2 = "From:" . $to;
			    mail($to,$subject,$message,$headers);
			}

		}
						

	}

	else{
			echo '{"result":0,"message":"Could not fetch device information"}';
			return;
	}

	
	

}
function getLocations(){
	include('user.php');
	$obj=new user();
	$row=$obj->getLocations();
	if($row==true){
		$row=$obj->fetch();
		echo '{"result":1,"location":[';
			while($row){
				echo json_encode($row);

				$row=$obj->fetch();
				if($row!=false){
					echo ",";
				}
			}
		echo "]}";
	}

	else{
		echo '{"result":0,"message":"Could not fetch location"}';
	}
}

function alertSecurity(){
	if(!isset($_REQUEST['userid'])){
		echo '{"result":0,"message":"User id is not given"}';
		return;
	}
	if($_REQUEST['userid']==""){
		echo '{"result":0,"message":"User id is not given"}';
		return;
	}
	if(!isset($_REQUEST['deviceid'])){
		echo '{"result":0,"message":"Device id is not given"}';
		return;
	}
	if($_REQUEST['deviceid']==""){
		echo '{"result":0,"message":"Device id is not given"}';
		return;
	}
	if(!isset($_REQUEST['name'])){
		echo '{"result":0,"message":"The name of device is not given"}';
		return;
	}
	if($_REQUEST['name']==""){
		echo '{"result":0,"message":"The name of device is not given"}';
		return;
	}
	if(!isset($_REQUEST['description'])){
		echo '{"result":0,"message":"Description is not given"}';
		return;
	}
	if($_REQUEST['description']==""){
		echo '{"result":0,"message":"Description is not given"}';
		return;
	}
	if(!isset($_REQUEST['locationid'])){
		echo '{"result":0,"message":"Location is not given"}';
		return;
	}
	if($_REQUEST['locationid']==""){
		echo '{"result":0,"message":"Location is not given"}';
		return;
	}
	if(!isset($_REQUEST['image'])){
		echo '{"result":0,"message":"Image is not given"}';
		return;
	}
	if($_REQUEST['image']==""){
		echo '{"result":0,"message":"Image is not given"}';
		return;
	}
	
	$name=$_REQUEST['name'];
	$location=$_REQUEST['locationid'];
	$description=$_REQUEST['description'];
	$image=$_REQUEST['image'];
	$deviceid=$_REQUEST['deviceid'];
	$user=$_REQUEST['userid'];

	include('user.php');
	$obj=new user();

	$row=$obj->getDeviceLocation($deviceid);
	if($row==true){
		$location=$obj->fetch();

	}

	else{
		echo '{"result":0,"message":"Could not fetch location"}';
		return;
	}

	$row=$obj->getUser($user);
	if($row==true){
		$user=$obj->fetch();
	}

	else{
		echo '{"result":0,"message":"Could not fetch user"}';
		return;
	}

	require './Smsgh/Api.php';

	$auth = new BasicAuth("znlltiuf", "qmidxlrw");
	// instance of ApiHost
	$apiHost = new ApiHost($auth);

	// instance of AccountApi
	$accountApi = new AccountApi($apiHost);
	// Get the account profile
	// Let us try to send some message
	$messagingApi = new MessagingApi($apiHost);
	try {
    // Send a quick message
	    //$messageResponse = $messagingApi->sendQuickMessage("Husby", "+2332432191768", "I love you dearly Honey. See you in the evening...");
		$currentdatetime=date("Y-m-d h:i:s")." ";
		//echo($location['placename']);

	    $mesg = new Message();
	    $mesg->setContent("Alert from ".$user['firstname']." ".$user['lastname'].". ".$name." (".$description.") moved to the ".$location['placename']." at ".$currentdatetime);
	    $mesg->setTo("0573283028");
	    $mesg->setFrom("Suivre App Security Alert!");
	    $mesg->setRegisteredDelivery(true);

	   

	    $messageResponse = $messagingApi->sendMessage($mesg);

	    if ($messageResponse instanceof MessageResponse) {
	    	 echo '{"result":1,"message":"Message sent"}';
	      //   echo $messageResponse->getStatus();
	      //   echo'"';
	    } elseif ($messageResponse instanceof HttpResponse) {
	    	 echo '{"result":0,"message":"Message not sent"}';
	        // echo "\nServer Response Status : " . $messageResponse->getStatus();
	        // echo'"';
	    }
	} catch (Exception $ex) {
	    echo $ex->getTraceAsString();
	}

	    	$to = "efuabainson@gmail.com"; // this is your Email address
		    $from = "efuabainson@gmail.com"; // this is the sender's Email address
		    $subject = "Suivre App Security Alert!";
		    $subject2 = "Copy of Suivre App Alert";
		    $message = "Alert from ".$user['firstname']." ".$user['lastname'].". ".$name." (".$description.") moved to the ".$location['placename']." at ".$currentdatetime;
		    $message2 = "Alert from ".$user['firstname']." ".$user['lastname'].". ".$name." (".$description.") moved to the ".$location['placename']." at ".$currentdatetime;

		    $headers = "From:" . $from;
		    $headers2 = "From:" . $to;
		    mail($to,$subject,$message,$headers);

	

}


function updateNotification(){
	include('user.php');
	$obj=new user();

	if(isset($_REQUEST['notification'])){
		if(!($_REQUEST['notification']=="")){
			$notification=$_REQUEST['notification'];
			$userid=$_REQUEST['userid'];
			$row=$obj->updateNotificationCode($notification, $userid);
			if($row==true){
				
			}

			else{
				echo '{"result":0,"message":"Could not update notification channel"}';
				return;
			}
		}
	}

	$track=$_REQUEST['track'];
	$device=$_REQUEST['devicename'];

	$row=$obj->updateTrackingCode($track, $device);
	if($row==true){
		echo '{"result":1,"message":"Update successful"}';
	}

	else{
		echo '{"result":0,"message":"Update failed"}';
		return;
	}


}

function sendNotification(){
	$to="APA91bFIj2WLkD3W4kbZcGO7dyI-TKKX0QpYCwtzqE2cNC0GbnUfQ7_gvQKOUloSb9T-6OZMxKdHXj8biiMYVgRJJP-C6b3PfpC7Kzu4G77PqMeGekHU9W6qTwnu0YTtWGNd6tGMBQka";
	$title="Push Notification Title";
	$message="Push Notification Message";
	sendPush($to,$title,$message);
}

function sendPush($to,$title,$message)
{
// API access key from Google API's Console
// replace API
	define( 'API_ACCESS_KEY', 'AIzaSyA5eScgNYWfnCjtmP7e22aYos4Zdn7h_kE');
	$registrationIds = array($to);
	$msg = array
	(
	'message' => $message,
	'title' => $title,
	'vibrate' => 1,
	'sound' => 1

	// you can also add images, additionalData
	);
	$fields = array
	(
	'registration_ids' => $registrationIds,
	'data' => $msg
	);
	$headers = array
	(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
	);
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
	echo $result;
}

?>