self.addEventListener('push', event => {
  const data = JSON.parse(event.data.text());
  const options = {
    body: data.content,
    icon: 'src/images/icons/app-icon-96x96.png',
    // ... other options like badge, image, vibrate, etc.
    data: {
      url: data.openUrl
    }
  };
  event.waitUntil(
    self.registration.showNotification(data.title, options)
  );
});

self.addEventListener('notificationclick', event => {
  event.notification.close();
  // Open a new window/tab when the notification is clicked
  event.waitUntil(
    clients.openWindow(event.notification.data.url || '/')
  );
});