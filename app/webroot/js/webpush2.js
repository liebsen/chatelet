
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