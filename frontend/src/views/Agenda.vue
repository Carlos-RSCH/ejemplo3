<!-- src/views/Agenda.vue -->
<script setup>
import { ref, onMounted } from 'vue';
import { api } from '../api';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const auth = useAuthStore();
const router = useRouter();
const contactos = ref([]);
const q = ref('');

async function cargar() {
  try {
    contactos.value = await api.contactos(q.value);
  } catch (e) {
    auth.setFlash('error', e.message);
    if (e.message.toLowerCase().includes('401')) { auth.clear(); router.push('/login'); }
  }
}
async function eliminar(id) {
  if (!confirm('¿Eliminar contacto?')) return;
  try { await api.eliminarContacto(id); auth.setFlash('success','Eliminado'); cargar(); }
  catch (e) { auth.setFlash('error', e.message); }
}

onMounted(cargar);
</script>

<template>
  <h1>Tu agenda</h1>
  <input v-model="q" placeholder="Buscar por nombre/apellido" @input="cargar" />
  <button @click="$router.push('/agenda/crear')">Crear</button>
  <ul>
    <li v-for="c in contactos" :key="c.id">
      <strong>{{ c.nombre }}</strong> - {{ c.telefono }}
      <button @click="$router.push(`/agenda/${c.id}`)">Editar</button>
      <button @click="eliminar(c.id)">Eliminar</button>
    </li>
  </ul>
</template>