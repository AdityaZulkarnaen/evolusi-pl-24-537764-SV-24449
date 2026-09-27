<script setup>
import { RouterLink } from 'vue-router'
import { alamatApi } from '@/lib/api'
</script>

<template>
  <section class="bagian">
    <h1>Katalog Ruang Rumah</h1>
    <p class="redup">
      Frontend Vue 3 yang membaca data produk dari API Laravel.
    </p>

    <dl class="rincian">
      <div>
        <dt>Penyusun</dt>
        <dd>Aditya Lucky Zulkarnaen (24/537764/SV/24449)</dd>
      </div>
      <div>
        <dt>Alamat API</dt>
        <dd><code>{{ alamatApi || 'belum diatur (VITE_API_URL)' }}</code></dd>
      </div>
    </dl>

    <RouterLink
      to="/produk"
      class="tombol"
    >
      Lihat daftar produk
    </RouterLink>
  </section>
</template>
