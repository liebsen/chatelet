/* Push notification subscription*/
const publicVapidKey = 'BEBiooz0kvrLqazPF8zdDj9SC_It9_KiZ-0iOp16Ks93U6S-G45i7woIqFUmtZZYgh_tWVXfr88etWr0jKtFcyY';

function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

async function subscribeUser() {
  if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
    console.error('Service workers or push notifications are not supported in this browser.');
    return;
  }

  // const registration = await navigator.serviceWorker.register('/sw.js'); //
  // const registration = await navigator.serviceWorker.register(`/service-worker.js`); //

  navigator.serviceWorker
    .register("/service-worker.js", { scope: "/" })
    .then(async(registration) => {
      // registration worked
      if (registration && registration.active) {
        console.log('Existing Service Worker found:', registration.active.scriptURL);
      }      
      console.log('Service Worker registered');

      const permission = await Notification.requestPermission();

      if (permission !== 'granted') {
        throw new Error('Notification permission not granted.');
      }

      const subscribeOptions = {
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(publicVapidKey),
      };

      let subscription = await registration.pushManager.getSubscription();

      if(subscription) {
        // already subscribed on this device
        console.log('User already subscribed');
        registration.update()
        console.log('Registration updated');
      } else {
        subscription = await registration.pushManager.subscribe(subscribeOptions);
        console.log('User sucessfully subscribed');

        // Send the subscription to your server
        await fetch('/api/subscribe', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(subscription),
        });
        console.log('Subscription sent to server');
      }      
    })
    .catch((error) => {
      // registration failed
      console.error(`Registration failed with ${error}`);
    });
}

// Call this function when appropriate (e.g., a button click, after user consent)
subscribeUser()
