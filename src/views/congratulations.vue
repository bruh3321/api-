<script setup lang="ts">
</script>

<template>
  <main>
    <div class="congrats-container">
      
    </div>
  </main>
</template>

<style>
body {
  margin: 0;
  font-family: 'Comic Sans MS', cursive, sans-serif; 
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

@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

h1 {
  font-size: 2.5rem;
  color: #ff69b4;
  text-shadow: 2px 2px 5px rgba(255, 105, 180, 0.5);
}
</style>
