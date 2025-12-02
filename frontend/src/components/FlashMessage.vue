<script setup>
import { useAuthStore } from '../stores/auth';
const auth = useAuthStore();
</script>

<template>
  <div v-if="auth.flash.text" :class="`flash ${auth.flash.type}`">
    {{ auth.flash.text }}
  </div>
</template>

<style>
.flash { padding: 8px; margin: 8px 0; }
.flash.success { background: #d1fae5; }
.flash.error { background: #fee2e2; }
</style>