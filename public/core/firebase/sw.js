// Firebase Messaging Service Worker
self.addEventListener("push", (event) => {
  const notif = event.data.json().notification;
  // console.log("-Message received. ", event.data.json());

  event.waitUntil(
    clients
      .matchAll({ type: "window", includeUncontrolled: true })
      .then((windowClients) => {
        let isFocused = false;
        for (let i = 0; i < windowClients.length; i++) {
          const windowClient = windowClients[i];
          if (windowClient.focused) {
            isFocused = true;
            break;
          }
        }

        if (isFocused) {
          // console.log("App is in the foreground");
          // // Handle foreground notification if needed
          if (event.data.json().data.hasOwnProperty("unread_counter")) {
            windowClients.forEach((windowClient) => {
              windowClient.postMessage({
                type: "UPDATE_UNREAD_COUNTER",
                unreadCounter: event.data.json().data.unread_counter,
              });
            });
          }
        } else {
          // console.log("App is in the background");
          self.registration.showNotification(notif.title, {
            body: notif.body,
            icon: notif.image,
            data: {
              url: notif.click_action,
            },
          });

          if (event.data.json().data.hasOwnProperty("unread_counter")) {
            windowClients.forEach((windowClient) => {
              windowClient.postMessage({
                type: "UPDATE_UNREAD_COUNTER",
                unreadCounter: event.data.json().data.unread_counter,
              });
            });
          }
        }
      })
  );
});

// self.addEventListener("push", (event) => {
//   const notif = event.data.json().notification;
//   // console.log(notif);
//   console.log('-Message received. ', event);
//   event.waitUntil(
//     self.registration.showNotification(notif.title, {
//       body: notif.body,
//       icon: notif.image,
//       data: {
//         url: notif.click_action,
//       },
//     })
//   );
// });
// importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js');
// importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js');
// self.addEventListener("notificationclick", (event) => {
//   event.waitUntil(clients.openWindow(event.notification.data.url));
// });
// import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
// import {
//   getMessaging,
//   onMessage,
//   onBackgroundMessage,
// } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";
// const messaging = getMessaging();
// onBackgroundMessage(messaging, (payload) => {
//   console.log(
//     "[firebase-messaging-sw.js] Received background message ",
//     payload
//   );
// });
// onMessage(messaging, (payload) => {
//   console.log(
//     "[firebase-messaging-sw.js] Received background message ",
//     payload
//   );
// });
