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

  self.registration.showNotification(notificationTitle, notificationOptions);
});
