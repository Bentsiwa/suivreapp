importScripts('https://www.gstatic.com/firebasejs/3.5.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.5.2/firebase-messaging.js');


var config = {
		    apiKey: "AIzaSyDFTaM3V2z_I2FKTFnLrYsRFqsf2K1F-u8",
		    authDomain: "suivre-156322.firebaseapp.com",
		    databaseURL: "https://suivre-156322.firebaseio.com",
		    storageBucket: "suivre-156322.appspot.com",
		    messagingSenderId: "81511517930"
		  };
firebase.initializeApp(config);

const messaging = firebase.messaging();


messaging.setBackgroundMessageHandler(function(payload) {
  alert('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Hello!';
  const notificationOptions = {
    body: 'This is my first notification.',
    icon: 'img/dress.jpg'
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});
