<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { api } from '../api';
import ContactForm from '../components/ContactForm.vue';
import { useAuthStore } from '../stores/auth';

const route = useRoute(); const router = useRouter(); const auth = useAuthStore();
const contacto = ref(null);

onMounted(async () => {
  const lista = await api.contactos();
  contacto.value = lista.find(c => c.id == route.params.id);
  if (!contacto.value) { auth.setFlash('error','No encontrado'); router.push('/agenda'); }
});

async function handleSubmit(payload) {
  if (payload.error) return auth.setFlash('error', payload.error);
  try {
    await api.actualizarContacto(route.params.id, payload.data);
    auth.setFlash('success','Actualizado'); router.push('/agenda');
  } catch (e) { auth.setFlash('error', e.message); }
}
</script>

<template>
  <h1>Editar contacto</h1>
  <ContactForm v-if="contacto" :modelValue="contacto" @submit="handleSubmit" />
</template>