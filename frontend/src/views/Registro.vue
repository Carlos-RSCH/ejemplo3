<script setup>
import { ref } from 'vue';
import { api } from '../api';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const username = ref('');
const password = ref('');
const auth = useAuthStore();
const router = useRouter();

async function submit() {
  try {
    await api.registrar(username.value, password.value);
    auth.setFlash('success','Usuario registrado');
    router.push('/login');
  } catch (e) { auth.setFlash('error', e.message); }
}
</script>

<template>
  <h1>Registro</h1>
  <form @submit.prevent="submit">
    <input v-model="username" placeholder="Usuario" />
    <input v-model="password" type="password" placeholder="Contraseña" />
    <button>Registrar</button>
  </form>
</template>