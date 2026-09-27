// Alamat API diambil dari VITE_API_URL (lihat .env.example), bukan ditulis di kode.
export const alamatApi = import.meta.env.VITE_API_URL

export async function ambilProduk() {
  if (!alamatApi) {
    throw new Error('VITE_API_URL belum diatur')
  }

  const respons = await fetch(`${alamatApi}/produk`, {
    headers: { Accept: 'application/json' },
  })

  if (!respons.ok) {
    throw new Error(`HTTP ${respons.status}`)
  }

  const isi = await respons.json()

  return isi.data
}
