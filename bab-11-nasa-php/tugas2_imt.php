<?php

function hitungIMT($berat, $tinggi)
{
  $tinggi_m = $tinggi / 100;
  $imt = $berat / ($tinggi_m * $tinggi_m);

  if ($imt < 18.5) $kategori = "Kurus";
  elseif ($imt < 25.0) $kategori = "Normal";
  elseif ($imt < 30.0) $kategori = "Gemuk";
  else                  $kategori = "Obesitas";

  return ["imt" => round($imt, 1), "kategori" => $kategori];
}

$berat  = 60;
$tinggi = 159;
$hasil  = hitungIMT($berat, $tinggi);

$referensi = [
  ["Kurus",    "< 18.5",      "#aaaaaa"],
  ["Normal",   "18.5 – 24.9", "#555555"],
  ["Gemuk",    "25.0 – 29.9", "#333333"],
  ["Obesitas", "≥ 30.0",      "#111111"],
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tugas 2 — Hitung IMT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="page-wrapper">

    <header class="page-header">
      <span class="tag">Tugas 2 · PHP</span>
      <h1>Indeks Massa Tubuh</h1>
      <p>Fungsi hitungIMT($berat, $tinggi) — menghitung dan mengkategorikan IMT</p>
    </header>

    <div class="section-label">Data Input</div>
    <div class="card">
      <div class="imt-inputs">
        <div class="imt-box">
          <div class="box-label">Berat Badan</div>
          <div class="box-val"><?php echo $berat; ?><span class="box-unit">kg</span></div>
        </div>
        <div class="imt-box">
          <div class="box-label">Tinggi Badan</div>
          <div class="box-val"><?php echo $tinggi; ?><span class="box-unit">cm</span></div>
        </div>
      </div>

      <div class="imt-result-box">
        <div class="imt-score"><?php echo $hasil['imt']; ?></div>
        <div>
          <div class="imt-kat-label">Kategori</div>
          <div class="imt-kat-val"><?php echo $hasil['kategori']; ?></div>
        </div>
      </div>

      <table class="ref-table">
        <?php foreach ($referensi as $ref):
          $aktif = ($ref[0] === $hasil['kategori']);
        ?>
          <tr class="<?php echo $aktif ? 'aktif' : ''; ?>">
            <td>
              <span class="ref-dot" style="background:<?php echo $ref[2]; ?>"></span>
              <?php echo $ref[0]; ?>
            </td>
            <td class="ref-range"><?php echo $ref[1]; ?></td>
            <td style="font-size:11px; color:#999; text-align:right;">
              <?php echo $aktif ? '← kamu di sini' : ''; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>

    <footer class="page-footer">
      <span>Tugas 2 — Hitung IMT</span>
      <span><?php echo date('d F Y'); ?></span>
    </footer>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>