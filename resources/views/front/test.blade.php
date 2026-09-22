<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FCM</title>
</head>

<body>
    <h1>Firebase Push Notification --</h1>
    <p></p>
    <script type="module">
        // Import the functions you need from the SDKs you need
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import {
            onMessage,
            getMessaging,
            getToken
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyBHx8WgI874zB3EDqmn_7veT8SZKeXxKLU",
            authDomain: "shuru-up-cd1c5.firebaseapp.com",
            projectId: "shuru-up-cd1c5",
            storageBucket: "shuru-up-cd1c5.appspot.com",
            messagingSenderId: "836221963157",
            appId: "1:836221963157:web:b4800db19dfcfe2ffe449c"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);
        onMessage(messaging, (payload) => {
            console.log('Message received. ', payload);
        });
        navigator.serviceWorker.register("core/sw.js").then(registration => {
            getToken(messaging, {
                serviceWorkerRegistration: registration,
                vapidKey: 'BHpM-bHx7DrVzuk16knc3vHIV05rCwZuYmW-KVuJ6bQ88t8tUk4JAcjrHgTNczfUTi5kyzsevyZ739gTKl0xW-w'
            }).then((currentToken) => {
                if (currentToken) {
                    console.log("Token is: " + currentToken);

                    // Send the token to your server and update the UI if necessary
                    // ...
                } else {
                    // Show permission request UI
                    console.log('No registration token available. Request permission to generate one.');
                    // ...
                }
            }).catch((err) => {
                console.log('An error occurred while retrieving token. ', err);
                // ...
            });
        });
    </script>
</body>

</html>
