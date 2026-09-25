<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header class="header">
    <div class="wadah header-isi">
      <RouterLink
        to="/"
        class="merek"
      >
        Ruang Rumah
      </RouterLink>

      <nav class="nav">
        <RouterLink to="/">
          Beranda
        </RouterLink>
        <RouterLink to="/produk">
          Produk
        </RouterLink>
      </nav>
    </div>
  </header>

  <main class="wadah">
    <RouterView />
  </main>
</template>
