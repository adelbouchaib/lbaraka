// firebase-messaging-sw.js

importScripts('https://www.gstatic.com/firebasejs/9.6.11/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.11/firebase-messaging-compat.js');

firebase.initializeApp({
  apiKey: "AIzaSyCzz91VFPinYPTQ97Gjoq_lkGObCWib_88",
  authDomain: "lbaraka-1f464.firebaseapp.com",
  projectId: "lbaraka-1f464",
  storageBucket: "lbaraka-1f464.firebasestorage.app",
  messagingSenderId: "825065799200",
  appId: "1:825065799200:web:e790fe16dc95fef0c50645",
  measurementId: "G-JRRLJHPNCX"
});

const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);

  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: '/icon.png' // Optional
  };

//   self.registration.showNotification(notificationTitle, notificationOptions);
});



    console.log("i am working");



  let currentToken = null; // Declare a global variable



  // Ask permission and get token
  Notification.requestPermission().then((permission) => {
    if (permission === "granted") {
      messaging.getToken({ vapidKey: 'BLX4N79hrhWKADdk6elMxsY9nijOccotAwR0mtsv00A8WtAtjK-LRqeR64uCLBNY0RlYCfVy8c5c0n3bnntfsiY' })
        .then((currentToken) => {
          if (currentToken) {
            console.log("FCM Token:", currentToken);

            // Send this token to your server
            // sendTokenToServer(currentToken); // Example: send the token to your server
           
           

          } else {
            console.log("No registration token available.");
          }
        }).catch((err) => {
          console.error("Error getting token:", err);
        });
    } else {
      console.warn("Permission not granted");
    }
  });


//   function sendTokenToServer(currentToken) {
        
//         // Call the Livewire method and pass the JavaScript variable
//         @this.call('storeUserToken', currentToken);
//         // window.livewire.emit('storeUserToken', currentToken);

//     }


  // Foreground notification handler
  messaging.onMessage((payload) => {
    console.log("Foreground message:", payload);
    new Notification(payload.notification.title, {
      body: payload.notification.body,
    //   icon: '/icon.png'
    });
  });
