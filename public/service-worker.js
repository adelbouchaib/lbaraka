self.addEventListener('push', function(event) {
    const data = event.data?.json();
    const title = data.notification.title;
    const options = {
      body: data.notification.body,
    //   icon: '/icon-192x192.png', // Optional icon
    };
  
    event.waitUntil(
      self.registration.showNotification(title, options)
    );
  });
  