// Logika tampilan produk. Tidak menyentuh jaringan, jadi mudah diuji tanpa Laravel.

export const BATAS_STOK_MENIPIS = 5

export function formatRupiah(angka) {
  const bulat = Math.round(Number(angka) || 0)
  const berpemisah = String(Math.abs(bulat)).replace(/\B(?=(\d{3})+(?!\d))/g, '.')

  return `${bulat < 0 ? '-' : ''}Rp${berpemisah}`
}

export function labelStok(stok) {
  if (stok <= 0) {
    return 'Habis'
  }

  return stok <= BATAS_STOK_MENIPIS ? 'Menipis' : 'Tersedia'
}

export function ringkasProduk(daftar) {
  return (daftar ?? []).reduce(
    (hasil, item) => ({
      total: hasil.total + 1,
      stokHabis: hasil.stokHabis + (item.stok <= 0 ? 1 : 0),
      nilaiStok: hasil.nilaiStok + item.harga * item.stok,
    }),
    { total: 0, stokHabis: 0, nilaiStok: 0 },
  )
}
