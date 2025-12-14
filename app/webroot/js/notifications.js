
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/service-worker.js', { scope: '/' })
    .then((registration) => {
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
      /* if (Notification.permission === 'granted') {
        registration.showNotification('Bienvenida a Chatelet!', {
          body: 'Prueba de notificación de Chatelet',
          icon: '/images/isologo.png'
        });
      }*/    
    }).catch((error) => {
      console.log('ServiceWorker registration failed: ', error);
    });
}

async function sendSubscriptionToServer() {
}

async function subscribeUserToPush() {
  const swRegistration = await navigator.serviceWorker.register('/service-worker.js'); // Register the worker
  const applicationServerKey = 'YOUR_PUBLIC_VAPID_KEY_HERE'; // Replace with your generated VAPID public key

  try {
    const subscription = await swRegistration.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: applicationServerKey
    });
    console.log('User subscribed:', subscription);
    // Send the subscription object to your backend server
    sendSubscriptionToServer(subscription); 
  } catch (error) {
    console.error('Failed to subscribe the user: ', error);
  }
}