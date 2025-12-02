<!-- src/views/Login.vue -->
<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../stores/auth';
import { api } from '../api';
import { useRouter } from 'vue-router';

const username = ref('');
const password = ref('');
const loading = ref(false);
const auth = useAuthStore();
const router = useRouter();

async function submit() {
  if (!username.value || !password.value) { auth.setFlash('error','Completa usuario y contraseña'); return; }
  loading.value = true;
  try {
    const { token } = await api.login(username.value, password.value);
    auth.setToken(token);
    auth.setFlash('success','Sesión iniciada');
    router.push('/agenda');
  } catch (e) {
    auth.setFlash('error', e.message);
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <h1>Login</h1>
  <form @submit.prevent="submit">
    <input v-model="username" placeholder="Usuario" />
    <input v-model="password" type="password" placeholder="Contraseña" />
    <button :disabled="loading">Entrar</button>
  </form>
</template>