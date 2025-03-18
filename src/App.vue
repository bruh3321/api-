<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { onMounted } from "vue";

onMounted(() => {                   //this is to detect if a user is previously logged in
    const token = localStorage.getItem("token");
    if (token) {
        isLoggedIn.value = true;
    }
});         


const router = useRouter();
const username = ref("");
const password = ref("");
const message = ref("");
const isLoggedIn = ref(false);
const loginpy = "http://0.0.0.0:5000/login";
const registerpy = "http://0.0.0.0:5000/register";
const protectedpy = "http://0.0.0.0:5000/protected";

function sendMessage() {
    let chatbox=document.getElementById("activechat")
    let chatinput=document.getElementById("chatinput")
    chatbox.value += chatinput.value + "\n";
    chatinput.value = null
}

const login = async () => {
    try {
        const response = await axios.post(loginpy, {
            username: username.value,
            password: password.value,
        });

        if (response.status === 200) {
            const token = response.data.token;
            localStorage.setItem("token", token); // storing token
            message.value = "Login successful!";
            isLoggedIn.value = true;
            router.push("/congratulations");
        }
    } catch (error) {
        message.value = error.response
            ? error.response.data.message
            : "Wrong username or password / or account non-existent";
    }
};
const register = async () => {
    try {
        const response = await axios.post(registerpy, {
            username: username.value,
            password: password.value,
        });
        if (response.status === 201) {
            message.value = "succesfuly registered user";
            console.log("it did register still");
        }
    } catch (error) {
        console.error("Registration error:", error);
        message.value = error.response
            ? error.response.data.message
            : "An error has occurred";
    }
};
async function getProtectedData() {
    const token = localStorage.getItem("token");

    if (!token) {
        message.value = "You need to log in first.";
        return;
    }

    try {
        const response = await axios.get(protectedpy, {
            headers: { Authorization: `Bearer ${token}` },
        });

        console.log(response.data);
        message.value = response.data.message;
    } catch (error) {
        message.value = "Failed to fetch protected data.";
    }
}
function logout() {
    localStorage.removeItem("token"); // Remove token
    isLoggedIn.value = false;
    router.push("/");
}
</script>

<template>
    <main>
        <div class="login-container" v-if="!isLoggedIn">
            <input
                type="text"
                class="user"
                v-model="username"
                placeholder="Enter Username"
                required
            />
            <input
                type="password"
                class="pass"
                v-model="password"
                placeholder="Enter Password"
                required
            />
            <div class="button-container">
                <button class="login-btn" @click="login">Login</button>
                <button class="register-btn" @click="register">Register</button>
            </div>
            <div v-if="message" class="error-message">{{ message }}</div>
        </div>
        <div v-else>
            <div class="container-log">
                <table>
                    <tr>
                        <th>Public chats</th>
                    </tr>
                </table>
                <textarea name="chat" id="activechat" readonly></textarea>
                <div class="chat-input-container">
                <input id="chatinput" placeholder="Enter a message" v-model="message" />
            <button id="send" @click="sendMessage">Send</button>
            </div>
        <button class="logout" @click="logout">Log out</button>
    </div>
        </div>
    </main>
</template>

<style scoped>
#activechat {
    white-space: pre-warp;
    padding-top: 25px;
    padding-left: 10px;
    border: 2px dashed #ff69b4;
    background-color: rgba(62, 62, 62, 0.9);
    margin-top: 20px;
    height: 70vh;
    width: 90vh;
    margin-right: 25px;
    size: fixed;
    user-select: none;
    border-radius: 10px;
}
#send {
    position: fixed;
    bottom: 0;
    width: 20vh;
    margin-left: 200px;
    margin-bottom: 25px;
}
#chatinput {
    position: fixed;
    bottom: 0;
    left: 1;
    width: 65vh;
    justify-items: center;
    margin-bottom: 25px;
}
table {
    border: 2px dashed #ff69b4;
    border-radius: 25px;
}
.container-log {
    background: rgba(50, 50, 50, 0.9);
    border: 5px dashed #ff69b4;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.5);
    width: 90vh;
    height: 90vh;
}
body {
    margin: 0;
    font-family: "Comic Sans MS", cursive, sans-serif;
    background: linear-gradient(135deg, #1a1a1a, #333333);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
    color: #ffffff;
}
.congrats-container {
    background: rgba(50, 50, 50, 0.9);
    border: 5px dashed #8a2be2;
    border-radius: 20px;
    padding: 30px;
    text-align: center;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.5);
    animation: bounce 2s infinite ease-in-out;
}
h1 {
    font-size: 2.5rem;
    color: #ff69b4;
    text-shadow: 2px 2px 5px rgba(255, 105, 180, 0.5);
}
.logout {
    position: fixed;
    bottom: 0;
    right: 0;
    padding: 10px 20px;
    margin: 5px;
    border: none;
    border-radius: 20px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition:
        transform 0.3s,
        background-color 0.3s;
    background-color: #8a2be2;
    color: white;
    box-shadow: 0px 5px 15px rgba(138, 43, 226, 0.3);
}
.login-container {
    background: rgba(50, 50, 50, 0.9);
    border: 5px dashed #ff69b4;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.5);
    animation: bounce 2s infinite ease-in-out;
}

@keyframes bounce {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

input {
    display: block;
    width: 200px;
    margin: 10px auto;
    padding: 10px;
    border: 2px solid #ff69b4;
    border-radius: 10px;
    font-size: 16px;
    background-color: #222222;
    color: #ffffff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
    transition: all 0.3s ease;
}

input:hover,
input:focus {
    outline: none;
    background-color: #444444;
    border-color: #8a2be2;
    transform: scale(1.05);
}

.button-container {
    margin-top: 20px;
}

button {
    padding: 10px 20px;
    margin: 5px;
    border: none;
    border-radius: 20px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition:
        transform 0.3s,
        background-color 0.3s;
}

.login-btn {
    background-color: #ff69b4;
    color: white;
    box-shadow: 0px 5px 15px rgba(255, 105, 180, 0.3);
}

.register-btn {
    background-color: #8a2be2;
    color: white;
    box-shadow: 0px 5px 15px rgba(138, 43, 226, 0.3);
}

button:hover {
    transform: scale(1.1);
    background-color: #444444;
    color: #ff69b4;
}

button:active {
    transform: scale(0.95);
}

.error-message {
    color: #ff0000;
    font-size: 14px;
    margin-top: 10px;
}
</style>
