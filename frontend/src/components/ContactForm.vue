<script setup>
import { ref, watch } from 'vue';
const props = defineProps({ modelValue: Object });
const emits = defineEmits(['update:modelValue', 'submit']);

const form = ref({ nombre:'', telefono:'', apellido:'', email:'', direccion:'', notas:'' });
watch(() => props.modelValue, (v) => { if (v) form.value = { ...form.value, ...v }; }, { immediate: true });

function onSubmit() {
  if (!form.value.nombre || !form.value.telefono) return emits('submit', { error: 'Nombre y teléfono son obligatorios' });
  emits('submit', { data: form.value });
}
</script>

<template>
  <div>
    <input v-model="form.nombre" placeholder="Nombre" />
    <input v-model="form.telefono" placeholder="Teléfono" />
    <input v-model="form.apellido" placeholder="Apellido" />
    <input v-model="form.email" placeholder="Email" />
    <input v-model="form.direccion" placeholder="Dirección" />
    <textarea v-model="form.notas" placeholder="Notas"></textarea>
    <button @click="onSubmit">Guardar</button>
  </div>
</template>