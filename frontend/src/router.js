// src/router.js
import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from './stores/auth';
import Home from './views/Home.vue';
import Login from './views/Login.vue';
import Registro from './views/Registro.vue';
import Agenda from './views/Agenda.vue';
import Crear from './views/CrearContacto.vue';
import Editar from './views/EditarContacto.vue';
import Perfil from './views/Perfil.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  { path: '/registro', component: Registro },
  { path: '/agenda', component: Agenda, meta: { requiresAuth: true } },
  { path: '/agenda/crear', component: Crear, meta: { requiresAuth: true } },
  { path: '/agenda/:id', component: Editar, meta: { requiresAuth: true } },
  { path: '/perfil', component: Perfil, meta: { requiresAuth: true } },
];

const router = createRouter({ history: createWebHistory(), routes });

router.beforeEach((to) => {
  const auth = useAuthStore();
  if (to.meta.requiresAuth && !auth.token) return '/login';
});

export default router;