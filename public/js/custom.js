// Dynamically add Firebase script links
const firebaseAppScript = document.createElement('script');
firebaseAppScript.src = "https://www.gstatic.com/firebasejs/10.11.0/firebase-app-compat.js";
firebaseAppScript.defer = true;
document.head.appendChild(firebaseAppScript);

const firebaseMessagingScript = document.createElement('script');
firebaseMessagingScript.src = "https://www.gstatic.com/firebasejs/10.11.0/firebase-messaging-compat.js";
firebaseMessagingScript.defer = true;
document.head.appendChild(firebaseMessagingScript);

// Wait until both scripts are loaded
firebaseMessagingScript.onload = () => {
  // Your service worker logic
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register("/sw.js").then(
      (registration) => {
        console.log("Service worker registration succeeded:", registration);
      },
      (error) => {
        console.error(`Service worker registration failed: ${error}`);
      }
    );
  }
};



  
