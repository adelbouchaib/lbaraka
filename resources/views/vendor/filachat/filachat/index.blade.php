<x-filament-panels::page>
    <div class="flex bg-white shadow-sm rounded-xl ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10"
        style="height: calc(100vh - 8rem);">
        <!-- Left Sidebar (Chat List) -->
        <livewire:filachat-chat-list :selectedConversation="$selectedConversation" />
        <!-- Right Section (Chat Conversation) -->
        <livewire:filachat-chat-box :selectedConversation="$selectedConversation" />
    </div>
</x-filament-panels::page>

@script

<script>
  const firebaseConfig = {
    apiKey: "AIzaSyCzz91VFPinYPTQ97Gjoq_lkGObCWib_88",
    authDomain: "lbaraka-1f464.firebaseapp.com",
    projectId: "lbaraka-1f464",
    storageBucket: "lbaraka-1f464.firebasestorage.app",
    messagingSenderId: "825065799200",
    appId: "1:825065799200:web:e790fe16dc95fef0c50645",
    measurementId: "G-JRRLJHPNCX"
  };

  firebase.initializeApp(firebaseConfig);

  const messaging = firebase.messaging();

  let currentToken = null; // Declare a global variable



  // Ask permission and get token
  Notification.requestPermission().then((permission) => {
    if (permission === "granted") {
      messaging.getToken({ vapidKey: 'BLX4N79hrhWKADdk6elMxsY9nijOccotAwR0mtsv00A8WtAtjK-LRqeR64uCLBNY0RlYCfVy8c5c0n3bnntfsiY' })
        .then((currentToken) => {
          if (currentToken) {
            console.log("FCM Token:", currentToken);

            // Send this token to your server
            sendTokenToServer(currentToken); // Example: send the token to your server

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


  function sendTokenToServer(currentToken) {
        
        // Call the Livewire method and pass the JavaScript variable
        @this.call('storeUserToken', currentToken);
    }


  // Foreground notification handler
  messaging.onMessage((payload) => {
    // console.log("Foreground message:", payload);
    new Notification(payload.notification.title, {
      body: payload.notification.body,
    //   icon: '/icon.png'
    });
  });


 
</script>

@endscript
