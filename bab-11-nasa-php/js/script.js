// ==============================================
// script.js — Kalkulator JavaScript
// Fungsi: tambah, kurang, kali, bagi
// ==============================================

// Ambil elemen dari HTML
const inputA    = document.getElementById('angka1');
const inputB    = document.getElementById('angka2');
const hasilEl   = document.getElementById('hasil');
const exprEl    = document.getElementById('ekspresi');
const errorEl   = document.getElementById('error');
const semuaBtn  = document.querySelectorAll('.btn-op');

// --- 4 Fungsi perhitungan ---

function tambah(a, b) {
  return a + b;
}

function kurang(a, b) {
  return a - b;
}

function kali(a, b) {
  return a * b;
}

function bagi(a, b) {
  if (b === 0) throw new Error('Tidak bisa dibagi dengan nol');
  return a / b;
}

// --- Simbol untuk ekspresi di display ---
const simbol = {
  tambah: '+',
  kurang: '−',
  kali:   '×',
  bagi:   '÷'
};

// --- Fungsi utama hitung ---

function hitung(op) {
  // Reset
  errorEl.textContent = '';
  hasilEl.classList.remove('error');

  const a = parseFloat(inputA.value);
  const b = parseFloat(inputB.value);

  // Validasi input kosong
  if (inputA.value.trim() === '' || inputB.value.trim() === '') {
    errorEl.textContent = 'Masukkan kedua angka terlebih dahulu.';
    return;
  }

  // Validasi bukan angka
  if (isNaN(a) || isNaN(b)) {
    errorEl.textContent = 'Input harus berupa angka.';
    return;
  }

  // Tandai tombol aktif
  semuaBtn.forEach(btn => btn.classList.remove('aktif'));
  document.querySelector(`[data-op="${op}"]`).classList.add('aktif');

  // Tampilkan ekspresi di atas hasil
  exprEl.textContent = `${a} ${simbol[op]} ${b} =`;

  // Hitung
  try {
    let hasil;
    if (op === 'tambah') hasil = tambah(a, b);
    if (op === 'kurang') hasil = kurang(a, b);
    if (op === 'kali')   hasil = kali(a, b);
    if (op === 'bagi')   hasil = bagi(a, b);

    // Bulatkan desimal yang terlalu panjang
    const hasilRapi = parseFloat(hasil.toFixed(8));
    hasilEl.textContent = hasilRapi;
    hasilEl.classList.remove('error');

  } catch (err) {
    hasilEl.textContent = err.message;
    hasilEl.classList.add('error');
    exprEl.textContent = '';
  }
}

// --- Reset semua ---

function resetKalkulator() {
  inputA.value        = '';
  inputB.value        = '';
  hasilEl.textContent = '0';
  exprEl.textContent  = '';
  errorEl.textContent = '';
  hasilEl.classList.remove('error');
  semuaBtn.forEach(btn => btn.classList.remove('aktif'));
}
