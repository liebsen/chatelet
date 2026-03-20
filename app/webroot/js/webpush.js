
/* Push notification subscription*/

// Function to convert VAPID public key to a Uint8Array

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

// Your public VAPID key generated from your server
const publicVapidKey = 'BEBiooz0kvrLqazPF8zdDj9SC_It9_KiZ-0iOp16Ks93U6S-G45i7woIqFUmtZZYgh_tWVXfr88etWr0jKtFcyY';
const version = 1001;

async function subscribeUser() {
  if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
    console.error('Service workers or push notifications are not supported in this browser.');
    return;
  }

  //const registration = await navigator.serviceWorker.register('/sw.js'); //
  const registration = await navigator.serviceWorker.register(`/service-worker.js?v=${version}`); //
  console.log('Service Worker registered');

  const permission = await Notification.requestPermission();
  console.log('permission',permission)
  if (permission !== 'granted') {
    throw new Error('Notification permission not granted.');
  }

  const subscribeOptions = {
    userVisibleOnly: true,
    applicationServerKey: urlBase64ToUint8Array(publicVapidKey), //
  };

  let subscription = await registration.pushManager.getSubscription();

  if(subscription) {
    // already subscribed on this device
    console.log('User already subscribed:', subscription);
  } else {
    subscription = await registration.pushManager.subscribe(subscribeOptions);
    console.log('User subscribed:', subscription);

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
}

// Call this function when appropriate (e.g., a button click, after user consent)
subscribeUser().catch(console.error);

/*
if (!Notification) {
    console.log('*Browser does not support Web Notification');
}

if ('serviceWorker' in navigator) {
  navigator.serviceWorker
    .register('service-worker.js?v=1.00.01', { scope: './' })
    .then(function (registration) {
        console.log("Service Worker Registered");
    })
    .catch(function (err) {
        console.log("Service Worker Failed to Register", err);
    })
}

navigator.serviceWorker.ready.then((reg) => {
  const subscribeOptions = {
    userVisibleOnly: true,
    applicationServerKey: 'BFrp-TvkuqCeNsytRt...'
  };
  reg.pushManager.subscribe(subscribeOptions).then((subscription) => {
    //send endpoint, p256dh and auth to backend
    console.log('endpoint is: ' + subscription.endpoint);
    console.log('p256dh is: ' + subscription.toJSON().keys.p256dh);
    console.log('auth is: ' + subscription.toJSON().keys.auth);

    // document.write('<p>endpoint is: ' + subscription.endpoint + '</p>');
    // document.write('<p>p256dh is: ' + subscription.toJSON().keys.p256dh + '</p>');
    // document.write('<p>auth is: ' + subscription.toJSON().keys.auth + '</p>');
  });
});
*/

/* End of Push notification subscription*/