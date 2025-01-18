<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();
const username = ref("");
const password = ref("");
const message = ref("");
const isLoggedIn = ref(false);


const handleLogin = () => {
    isLoggedIn.value = true;
    router.push("/congratulations");
};

const login = async () => {
    try {
        const response = await axios.post("http://127.0.0.1:5000/login", {
            username: username.value,
            password: password.value,
        });

        if (response.status === 200) {
            message.value = response.data.message;
            handleLogin();
        }
    } catch (error) {
        message.value = error.response
            ? error.response.data.message
            : "wrong username or password / or account none existent";
    }
};
const register = async () => {
    try {
        const response = await axios.post("http://127.0.0.1:5000/register", {
            username: username.value,
            password: password.value,
        });
        if (response.status === 201) {
            message.value = response.data.message;
            console.log("it did register still");
        }
    } catch (error) {
        console.error("Registration error:", error);
        message.value = error.response
            ? error.response.data.message
            : "An error has occurred";
    }
};
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
                <button class="register-btn" @lick="register">Register</button>
            </div>
            <div v-if="message" class="error-message">{{ message }}</div>
        </div>
        <div v-else>
            <h1>Congratulations! You are logged in.</h1>
        </div>
    </main>
</template>

<style scoped>
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
