<script setup>
import { ref, onMounted } from 'vue';
import { api } from '../api';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const perfil = ref(null);

onMounted(async () => {
  try { perfil.value = await api.perfil(); }
  catch (e) { auth.setFlash('error', e.message); }
});
</script>

<template>
  <h1>Perfil</h1>
  <div v-if="perfil">
    <p>ID: {{ perfil.id }}</p>
    <p>Usuario: {{ perfil.nombre_de_usuario }}</p>
    <p>Fecha registro: {{ perfil.fecha_registro }}</p>
  </div>
</template>