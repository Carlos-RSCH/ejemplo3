<script setup>
import ContactForm from '../components/ContactForm.vue';
import { api } from '../api';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const auth = useAuthStore();
const router = useRouter();

async function handleSubmit(payload) {
  if (payload.error) return auth.setFlash('error', payload.error);
  try {
    await api.crearContacto(payload.data);
    auth.setFlash('success','Contacto creado');
    router.push('/agenda');
  } catch (e) { auth.setFlash('error', e.message); }
}
</script>

<template>
  <h1>Crear contacto</h1>
  <ContactForm @submit="handleSubmit" />
</template>