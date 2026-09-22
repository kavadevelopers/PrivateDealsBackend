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
    const firebaseConfig = {
        apiKey: "AIzaSyBHx8WgI874zB3EDqmn_7veT8SZKeXxKLU",
        authDomain: "shuru-up-cd1c5.firebaseapp.com",
        projectId: "shuru-up-cd1c5",
        storageBucket: "shuru-up-cd1c5.appspot.com",
        messagingSenderId: "836221963157",
        appId: "1:836221963157:web:b4800db19dfcfe2ffe449c"
    };
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);
    // onMessage(messaging, (payload) => {
    //     console.log('Message received. ', payload);
    // });
    navigator.serviceWorker.register("{{ asset('core/firebase/sw.js') }}").then(registration => {
        getToken(messaging, {
            serviceWorkerRegistration: registration,
            vapidKey: 'BHpM-bHx7DrVzuk16knc3vHIV05rCwZuYmW-KVuJ6bQ88t8tUk4JAcjrHgTNczfUTi5kyzsevyZ739gTKl0xW-w'
        }).then((currentToken) => {
            if (currentToken) {
                // console.log("Token is: " + currentToken);
                $('input[name=firebase_token]').val(currentToken);
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
    navigator.serviceWorker.addEventListener("message", (event) => {
        if (event.data.type === "UPDATE_UNREAD_COUNTER") {
            @if (request()->routeIs('front.*'))
                let unreadCounter = parseInt(event.data.unreadCounter);
                let notiKavaCounter = document.querySelector(".notiKavaCounter p");

                if (unreadCounter > 9) {
                    notiKavaCounter.innerHTML = "9+";
                } else {
                    notiKavaCounter.innerHTML = unreadCounter;
                }

                document.querySelector(".notiKavaCounter").style.display = "block";
            @endif
            @if (request()->routeIs('admin.*'))
                document.querySelector(".notificationBubble").style.display = "block";
            @endif
            createjs.Sound.play("notification");
        }
    });
</script>
