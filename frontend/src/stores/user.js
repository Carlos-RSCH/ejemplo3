import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({
    profile: null
  }),
  actions: {
    setProfile(p) { this.profile = p; },
    clear() { this.profile = null; }
  }
});