(function() {

	document.addEventListener('deviceready', onDeviceReady.bind(this), false);
	var pictureSource;
	var destinationType;
	function onDeviceReady() {
		pictureSource = navigator.camera.PictureSourceType;
		destinationType = navigator.camera.DestinationType;


		

		document.getElementById("capturePhoto").onclick = function() {
			navigator.camera.getPicture(onPhotoDataSuccess, onFail, {
				quality : 50,

				destinationType : destinationType.DATA_URL
			});
		}

		document.getElementById("geolocationdata").addEventListener("click", function() {
			navigator.geolocation.getCurrentPosition(onSuccess, onError, {
				enableHighAccuracy : true
			});
		});

		//watchPosition
		var watchId = navigator.geolocation.watchPosition(onWatchSuccess, onWatchError, {
			timeout : 30000
		});

		document.getElementById("clearWatchbtn").addEventListener("click", function() {
			navigator.geolocation.clearWatch(watchID);
		}); 

		document.getElementById('barcode').onclick=function(){
					cordova.plugins.barcodeScanner.scan(onBarcodeSuccess,onBarcodeFail
						,
	      	
	     	 			{
				          "preferFrontCamera" : true, // iOS and Android 
				          "showFlipCameraButton" : true, // iOS and Android 
				          "prompt" : "Place a barcode inside the scan area", // supported on Android only 
				          "formats" : "QR_CODE,PDF_417", // default: all but PDF_417 and RSS_EXPANDED 
				          "orientation" : "landscape" // Android only (portrait|landscape), default unset so it rotates with the device 
				    	});
		}

		// var mapCanvas = document.getElementById("map");
 	// 	 var mapOptions = {
	 //    center: new google.maps.LatLng(51.5, -0.2), zoom: 10
	 //  };
	 //  var map = new google.maps.Map(mapCanvas, mapOptions);

	};
	 var d = new Date();
	 var n = d.getTime();

	function onMapInit(map) {
	}

	function onPhotoDataSuccess(imageData) {
		

		var smallImage = document.getElementById('smallImage');

		smallImage.style.display = 'block';

		smallImage.src = "data:image/jpeg;base64," + imageData;
		//movePic(imageData);

	}

	function onFail(message) {

		alert('Failed because: ' + message);

	}

	///////////geolocation bit/////////////////
	var onSuccess = function(position) {
		alert('Latitude: ' + position.coords.latitude + '\n' + 'Longitude: ' + position.coords.longitude + '\n');
	};

	// onError Callback receives a PositionError object
	//
	function onError(error) {
		alert('code: ' + error.code + '\n' + 'message: ' + error.message + '\n');
	}

	//watchPosition

	var onWatchSuccess = function(position) {
		var element = document.getElementById('divWatchMeMove');
		element.innerHTML = 'Latitude: ' + position.coords.latitude + '<br />' + 'Longitude: ' + position.coords.longitude + '<br />' + '<hr />' + element.innerHTML;
	};

	function onWatchError(error) {
		alert('code: ' + error.code + '\n' + 'message: ' + error.message + '\n');
	}

	function onBarcodeSuccess(result) {
	          alert("We got a barcode\n" +
	                "Result: " + result.text + "\n" +
	                "Format: " + result.format + "\n" +
	                "Cancelled: " + result.cancelled);
	 }

	 function onBarcodeFail(error) {
	          alert("Scanning failed: " + error);
	      	}


	 function movePic(file){ 
    	window.resolveLocalFileSystemURI(file, resolveOnSuccess, resOnError); 
	} 

	//Callback function when the file system uri has been resolved
	function resolveOnSuccess(entry){ 
	   
	    //new file name
	    var newFileName = n + ".jpg";
	    var myFolderApp = "Suivre";

	    window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSys) {      
	    //The folder is created if doesn't exist
	    fileSys.root.getDirectory( myFolderApp,
	                    {create:true, exclusive: false},
	                    function(directory) {
	                        entry.moveTo(directory, newFileName,  successMove, resOnError);
	                    },
	                    resOnError);
	                    },
	    resOnError);
	}

//Callback function when the file has been moved successfully - inserting the complete path
function successMove(entry) {
    //I do my insert with "entry.fullPath" as for the path
    alert("worked");
    alert(entry.Suivre+"/"+n);
}

function resOnError(error) {
    alert(error.code);
    
}
 function getPhoto(source) {
      // Retrieve image file location from specified source
      alert("here");
      navigator.camera.getPicture(onPhotoURISuccess, onFail, { quality: 50,
        destinationType: destinationType.FILE_URI,
        sourceType: source });
    }
  function onPhotoURISuccess(imageURI) {
      // Uncomment to view the image file URI
       alert(imageURI);

      // Get image handle
      //
      var largeImage = document.getElementById('largeImage');

      // Unhide image elements
      //
      largeImage.style.display = 'block';

      // Show the captured photo
      // The in-line CSS rules are used to resize the image
      //
      largeImage.src = imageURI;
    }



})();
