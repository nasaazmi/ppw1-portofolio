<?php

$nama      = "Nasa Azmi Shobir";
$nim       = "25/558088/SV/26283";
$prodi     = "Teknologi Rekayasa Perangkat Lunak";
$asal_kota = "Mojokerto";
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tugas 1 — Profil Diri</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="page-wrapper">

    <header class="page-header">
      <span class="tag">Tugas 1 · PHP</span>
      <h1>Profil Diri</h1>
      <p>Menampilkan data diri menggunakan variabel PHP dalam tabel HTML</p>
    </header>

    <div class="section-label">Data Mahasiswa</div>
    <div class="card">
      <table class="tabel-profil">
        <tr>
          <td class="col-key">Nama</td>
          <td class="col-sep">:</td>
          <td class="col-val"><?php echo $nama; ?></td>
        </tr>
        <tr>
          <td class="col-key">NIM</td>
          <td class="col-sep">:</td>
          <td class="col-val"><?php echo $nim; ?></td>
        </tr>
        <tr>
          <td class="col-key">Program Studi</td>
          <td class="col-sep">:</td>
          <td class="col-val"><?php echo $prodi; ?></td>
        </tr>
        <tr>
          <td class="col-key">Asal Kota</td>
          <td class="col-sep">:</td>
          <td class="col-val"><?php echo $asal_kota; ?></td>
        </tr>
      </table>
    </div>

    <footer class="page-footer">
      <span>Tugas 1 — Profil Diri</span>
      <span><?php echo date('d F Y'); ?></span>
    </footer>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>