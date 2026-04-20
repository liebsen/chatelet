
'use strict';

/**
 * Received push
 */
self.addEventListener('push', function (event) {
    let pushMessageJSON = event.data.json();    
    let pushMessageObject = {
        body: pushMessageJSON.body,
        icon: pushMessageJSON.icon,
        badge: pushMessageJSON.badge,
        data: pushMessageJSON.data
    };
    if(pushMessageJSON.image) {
        pushMessageObject.image = pushMessageJSON.image;
    }
    self.registration.showNotification(pushMessageJSON.title, pushMessageObject);
    console.info("sw[push]:", event);
});

/**
 * Click by push
 */
self.addEventListener('notificationclick', function(event) {
    let url = event.notification.data.url;
    event.notification.close(); // Android needs explicit close.
    if (!url) return;
    event.waitUntil(
        clients.matchAll({type: 'window'}).then( windowClients => {
            // Check if there is already a window/tab open with the target URL
            for (var i = 0; i < windowClients.length; i++) {
                var client = windowClients[i];
                // If so, just focus it.
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            // If not, then open the target URL in a new window/tab.
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});

self.addEventListener('message', function (event) {
    // A message has been sent to this service worker.
    console.log("sw[message]:", event);
});

self.addEventListener('pushsubscriptionchange', function (event) {
    // The Push subscription ID has changed. The App should send this
    // information back to the App Server.
    console.log("sw[pushsubscriptionchange]:", event);
    event.waitUntil(
        self.clients.matchAll()
            .then(clientList => {
                let sent = false;
                console.debug("Service worker found clients",
                    JSON.stringify(clients));
                clientList.forEach(client => {
                    console.debug("Service worker sending to client...", client);
                    sent = true;
                    client.postMessage({'type': 'update'});
                });
                if (sent == false) {
                    throw new Error("No valid client to send to.");
                }
            })
            .catch(err => {
                console.error("Service worker couldn't send message: ", err);
            })
    );

});

self.addEventListener('registration', function (event) {
    // The service worker has been registered.
    console.log("sw[registration]:", event);
});


self.addEventListener('install', function (event) {
    // The serivce worker has been loaded and installed.
    // The browser aggressively caches the service worker code.
    console.log("sw[install]:", JSON.stringify(event));
    // This replaces currently active service workers with this one
    // making this service worker a singleton.
    event.waitUntil(self.skipWaiting());
    console.log("sw[installed]:", JSON.stringify(event));

});

self.addEventListener('activate', function (event) {
    // The service worker is now Active and functioning.
    console.log("sw[activate]: ", JSON.stringify(event));
    // Again, ensure that this is the only active service worker for this
    // page.
    event.waitUntil(self.clients.claim());
    console.log("sw[activated]:", JSON.stringify(event));
    navigator.serviceWorker
});
