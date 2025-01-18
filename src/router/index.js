import { createRouter, createWebHistory } from 'vue-router';
import App from '../App.vue';
import Congratulations from '../views/congratulations.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: App,
  },
  {
    path: '/congratulations',
    name: 'Congratulations',
    component: Congratulations,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
