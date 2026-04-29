self.addEventListener('push', event => {
  const data = event.data.json();
  console.log('Push message received:', data);

  const options = {
    body: data.body,
    icon: data.icon || '/images/icon.png', // Optional icon
    data: {
      url: data.url || '/' // Optional data to use on notification click
    }
  };

  event.waitUntil(
    self.registration.showNotification(data.title, options)
  );
});

// Optional: Handle notification clicks to open a specific window/tab
self.addEventListener('notificationclick', event => {
  event.notification.close();
  const clickedUrl = event.notification.data.url;
  event.waitUntil(
    clients.openWindow(clickedUrl)
  );
});