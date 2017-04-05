<?php
	include_once("databasehelper.php");
	/**
	*User class
	*/

	class user extends databasehelper{

		function user(){

		}
		/**
		*log in a user
		*@param string password password of user
		*@param string email email of user
		*@return boolean returns true if successful or false
		*/
		function login($email,$password){
			/**
			*@var string $strQuery should contain insert query
			*/
			$strQuery="select * from user where password like '$password' and email like '$email'";
			
			return $this->query($strQuery);
		}


		
		function addUser($firstname,$lastname,$email,$tel, $password, $notification){
			/**
			*@var string $strQuery should contain insert query
			*/
			$strQuery="insert into user set
			firstname ='$firstname',
							email='$email',
							phone='$tel',
							lastname='$lastname',
							notification='$notification',
							password='$password'";
						
				
			return $this->query($strQuery);
		}

		function editDevice($device,$description, $tag,$id,$deviceid){
			/**
			*@var string $strQuery should contain insert query
			*/
			
			$strQuery="update device set
			name='$device',
			description ='$description',
			tagidentification='$tag',
			userid='$id'
			where deviceid=$deviceid";
			return $this->query($strQuery);
		}

		function addDevice($device,$description, $tag,$id){
			/**
			*@var string $strQuery should contain insert query
			*/
			$strQuery="insert into device set
			name='$device',
			description ='$description',
			tagidentification='$tag',
			image='img/device.jpg',
			userid='$id'";
							
			return $this->query($strQuery);

		}

		function getLocation($location){
			/**
			*@var string $strQuery should contain insert query
			*/
			$strQuery="select * from location where placename='$location'";

							
			return $this->query($strQuery);

		}
		function getLocationWithID($location){
			/**
			*@var string $strQuery should contain insert query
			*/
			$strQuery="select * from location where locationid=$location";

							
			return $this->query($strQuery);

		}
		function getLocationWithTagID($tagid){
			/**
			*@var string $strQuery should contain insert query
			*/
			$strQuery="select * from devicelocation where tagidentification=$tagid";

							
			return $this->query($strQuery);

		}

		
		function getDevices($id=false){
			$strQuery="select * from device";

			if($id!=false){
                $strQuery=$strQuery . " where userid=$id";
            }
			
			return $this->query($strQuery);
		}

		function getDeviceLocation($filter=false){
			$strQuery="select device.deviceid, device.name, device.image, location.locationid as locationid, location.placename, location.type, location.latitude, location.longitude, devicelocation.time from location inner join devicelocation on location.locationid=devicelocation.locationid inner join device on devicelocation.deviceid=device.deviceid";

			if($filter!=false){
                $strQuery=$strQuery . " where device.deviceid='$filter' ";
            }else{
            	$strQuery=$strQuery . " where device.track='1' ";
            }


            //$strQuery=$strQuery . "ORDER BY devicelocation.time DESC";

         
			return $this->query($strQuery);
		}

		function deleteDevice($deviceid){
			$strQuery="delete from device where deviceid='$deviceid'";
			return $this->query($strQuery);
		}

		function addDeviceLocation($device,$currentdatetime,$location){
			$strQuery="insert into devicelocation set
			deviceid='$device',
			locationid ='$location',
			time='$currentdatetime'";
			//echo $strQuery;				
			return $this->query($strQuery);
		}


		function findDevice($tag){
				$strQuery="select device.deviceid as deviceid, device.name as name, device.track as track, device.description as description, user.phone as phone, user.notification as notification, user.email as email from device inner join user on device.userid=user.userid where tagidentification='$tag'";

							
			return $this->query($strQuery);
		}

		function getLocations(){
			$strQuery="select * from location";
			
			return $this->query($strQuery);
		}

		function updatingtest($image){
			$strQuery="update device set
			image='$image'
			where deviceid=21";
			return $this->query($strQuery);

		}

		function getUser($userid){
					/**
			*@var string $strQuery should contain insert query
			*/
			$strQuery="select * from user where userid=$userid";

							
			return $this->query($strQuery);

		}
		function updateNotificationCode($notification,$userid){
				$strQuery="update user set
				notification='$notification'
				where userid=$userid";
				return $this->query($strQuery);
		}
		function updateTrackingCode($track, $device){
			$strQuery="update device set
				track='$track'
				where name='$device'";
				return $this->query($strQuery);
		}


		}

?>