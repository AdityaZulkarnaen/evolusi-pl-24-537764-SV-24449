import { describe, expect, it } from 'vitest'
import { formatRupiah, labelStok, ringkasProduk } from '../produk'

describe('formatRupiah', () => {
  it('memberi pemisah ribuan dengan titik', () => {
    expect(formatRupiah(1250000)).toBe('Rp1,250,000')
    expect(formatRupiah(95000)).toBe('Rp95.000')
  })

  it('menganggap nilai kosong sebagai nol', () => {
    expect(formatRupiah(null)).toBe('Rp0')
    expect(formatRupiah(undefined)).toBe('Rp0')
  })
})

describe('labelStok', () => {
  it('menandai stok nol sebagai Habis', () => {
    expect(labelStok(0)).toBe('Habis')
  })

  it('menandai stok sampai 5 sebagai Menipis', () => {
    expect(labelStok(1)).toBe('Menipis')
    expect(labelStok(5)).toBe('Menipis')
  })

  it('menandai stok di atas 5 sebagai Tersedia', () => {
    expect(labelStok(6)).toBe('Tersedia')
  })
})

describe('ringkasProduk', () => {
  it('menghitung total, stok habis, dan nilai stok', () => {
    const daftar = [
      { harga: 100000, stok: 2 },
      { harga: 50000, stok: 0 },
      { harga: 25000, stok: 4 },
    ]

    expect(ringkasProduk(daftar)).toEqual({ total: 3, stokHabis: 1, nilaiStok: 300000 })
  })

  it('mengembalikan nol untuk daftar kosong', () => {
    const nol = { total: 0, stokHabis: 0, nilaiStok: 0 }

    expect(ringkasProduk([])).toEqual(nol)
    expect(ringkasProduk(undefined)).toEqual(nol)
  })
})
