// src/stores/auth.js
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token') || null,
    user: null,
    flash: { type: null, text: null },
  }),
  actions: {
    setToken(t) {
      this.token = t;
      localStorage.setItem('token', t);
    },
    clear() {
      this.token = null; this.user = null;
      localStorage.removeItem('token');
    },
    setFlash(type, text) { this.flash = { type, text }; setTimeout(() => this.flash = { type:null, text:null }, 3000); }
  }
});