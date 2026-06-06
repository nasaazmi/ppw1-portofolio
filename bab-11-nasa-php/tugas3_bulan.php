<?php
// tugas3_bulan.php — Info Bulan Sekarang

$bulan_en     = date('F');
$tahun        = date('Y');
$hari_ini     = (int) date('j');
$total_hari   = (int) date('t');
$hari_tersisa = $total_hari - $hari_ini;
$persen       = round(($hari_ini / $total_hari) * 100);

$bulan_id = [
  'January'   => 'Januari',   'February' => 'Februari',
  'March'     => 'Maret',     'April'    => 'April',
  'May'       => 'Mei',       'June'     => 'Juni',
  'July'      => 'Juli',      'August'   => 'Agustus',
  'September' => 'September', 'October'  => 'Oktober',
  'November'  => 'November',  'December' => 'Desember',
];
$bulan = $bulan_id[$bulan_en];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tugas 3 — Info Bulan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="page-wrapper">

  <header class="page-header">
    <span class="tag">Tugas 3 · PHP</span>
    <h1>Info Bulan Sekarang</h1>
    <p>Menggunakan fungsi date() untuk membaca informasi waktu dari server</p>
  </header>

  <div class="section-label">Data Bulan Ini</div>
  <div class="card">

    <div class="bulan-besar"><?php echo $bulan; ?></div>
    <div class="bulan-tahun"><?php echo $tahun; ?></div>

    <div class="stat-row">
      <div class="stat-item">
        <div class="stat-num"><?php echo $hari_ini; ?></div>
        <div class="stat-lbl">Hari Ini</div>
      </div>
      <div class="stat-item">
        <div class="stat-num"><?php echo $total_hari; ?></div>
        <div class="stat-lbl">Total Hari</div>
      </div>
      <div class="stat-item highlight">
        <div class="stat-num"><?php echo $hari_tersisa; ?></div>
        <div class="stat-lbl">Tersisa</div>
      </div>
    </div>

    <div class="progress-wrap">
      <div class="progress-meta">
        <span>Progress Bulan</span>
        <span><?php echo $persen; ?>%</span>
      </div>
      <div class="progress-track">
        <div class="progress-fill" style="width:<?php echo $persen; ?>%"></div>
      </div>
      <div class="progress-note">
        Sudah <?php echo $hari_ini; ?> hari dari <?php echo $total_hari; ?> hari di bulan <?php echo $bulan; ?>.
      </div>
    </div>

  </div>

  <footer class="page-footer">
    <span>Tugas 3 — Info Bulan</span>
    <span><?php echo date('d F Y'); ?></span>
  </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
