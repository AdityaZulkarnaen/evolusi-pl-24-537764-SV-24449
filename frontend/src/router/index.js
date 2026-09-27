import { createRouter, createWebHistory } from 'vue-router'
import BerandaView from '@/views/BerandaView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'beranda',
      component: BerandaView,
    },
    {
      path: '/produk',
      name: 'produk',
      // Dimuat saat dibuka saja supaya berkas awal tetap kecil.
      component: () => import('@/views/ProdukView.vue'),
    },
  ],
})

export default router
