// src/api.js
import { useAuthStore } from './stores/auth';

const BASE = 'https://tu-host-backend.com/api';

async function request(path, { method = 'GET', body, auth = false } = {}) {
  const headers = { 'Content-Type': 'application/json' };
  if (auth) {
    const { token } = useAuthStore();
    if (token) headers['Authorization'] = `Bearer ${token}`;
  }
  const res = await fetch(`${BASE}${path}`, { method, headers, body: body ? JSON.stringify(body) : undefined });
  const data = await res.json().catch(() => ({}));
  if (!res.ok) throw new Error(data.error || `Error ${res.status}`);
  return data;
}

export const api = {
  login: (username, password) => request('/auth/login.php', { method: 'POST', body: { username, password } }),
  registrar: (username, password) => request('/auth/registrar.php', { method: 'POST', body: { username, password } }),
  perfil: () => request('/auth/perfil.php', { auth: true }),
  editarPerfil: (username) => request('/auth/editar.php?id=', { method: 'PUT', body: { username }, auth: true }),

  contactos: (q='') => request(`/contactos/index.php${q ? `?q=${encodeURIComponent(q)}` : ''}`, { auth: true }),
  crearContacto: (c) => request('/contactos/crear.php', { method: 'POST', body: c, auth: true }),
  actualizarContacto: (id, c) => request(`/contactos/actualizar.php?id=${id}`, { method: 'PUT', body: c, auth: true }),
  eliminarContacto: (id) => request(`/contactos/eliminar.php?id=${id}`, { method: 'DELETE', auth: true }),
};