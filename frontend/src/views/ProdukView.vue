<script setup>
import { computed, onMounted, ref } from 'vue'
import { ambilProduk } from '@/lib/api'
import { formatRupiah, labelStok, ringkasProduk } from '@/lib/produk'

const produk = ref([])
const memuat = ref(true)
const galat = ref('')

const ringkasan = computed(() => ringkasProduk(produk.value))

onMounted(async () => {
  try {
    produk.value = await ambilProduk()
  } catch (e) {
    galat.value = e.message
  } finally {
    memuat.value = false
  }
})
</script>

<template>
  <section class="bagian">
    <h1>Daftar produk</h1>

    <p
      v-if="memuat"
      class="redup"
    >
      Memuat data…
    </p>

    <p
      v-else-if="galat"
      class="galat"
    >
      Gagal memuat produk: {{ galat }}
    </p>

    <p
      v-else-if="produk.length === 0"
      class="redup"
    >
      Belum ada produk.
    </p>

    <template v-else>
      <p class="redup">
        Total {{ ringkasan.total }} produk, {{ ringkasan.stokHabis }} stok habis,
        nilai stok {{ formatRupiah(ringkasan.nilaiStok) }}.
      </p>

      <div class="gulir">
        <table class="tabel">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Kategori</th>
              <th class="kanan">
                Harga
              </th>
              <th class="kanan">
                Stok
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in produk"
              :key="item.id"
            >
              <td>{{ item.nama }}</td>
              <td class="redup">
                {{ item.kategori }}
              </td>
              <td class="kanan">
                {{ formatRupiah(item.harga) }}
              </td>
              <td class="kanan">
                <span :class="['lencana', `lencana-${labelStok(item.stok).toLowerCase()}`]">
                  {{ labelStok(item.stok) }}
                </span>
                {{ item.stok }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
  </section>
</template>
