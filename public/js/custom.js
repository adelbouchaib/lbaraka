if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register("/sw.js").then(
          (registration) => {
              console.log("Service worker registration succeeded:", registration);
          },
          (error) => {
              console.error(`Service worker registration failed: ${error}`);
          },
          );
          
  navigator.serviceWorker.register('/firebase-messaging-sw.js')
    .then(function(registration) {
      console.log('Firebase Service Worker registered with scope:', registration.scope);
    }).catch(function(error) {
      console.log('Service Worker registration failed:', error);
    });

   
}
