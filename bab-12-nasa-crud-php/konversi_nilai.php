<?php
$nilai  = null;
$grade  = null;
$error  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['nilai'] ?? '';

    if ($input === '' || !is_numeric($input)) {
        $error = 'Masukkan nilai berupa angka.';
    } else {
        $nilai = (int) $input;
        if ($nilai < 0 || $nilai > 100) {
            $error = 'Nilai harus antara 0 sampai 100.';
            $nilai = null;
        } else {
            // Konversi grade
            if ($nilai >= 80) {
                $grade = ['huruf' => 'A', 'desk' => 'Sangat Baik',
                          'class' => 'success', 'bg' => '#198754'];
            } elseif ($nilai >= 70) {
                $grade = ['huruf' => 'B', 'desk' => 'Baik',
                          'class' => 'primary', 'bg' => '#0d6efd'];
            } elseif ($nilai >= 60) {
                $grade = ['huruf' => 'C', 'desk' => 'Cukup',
                          'class' => 'warning', 'bg' => '#ffc107'];
            } elseif ($nilai >= 50) {
                $grade = ['huruf' => 'D', 'desk' => 'Kurang',
                          'class' => 'info',    'bg' => '#0dcaf0'];
            } else {
                $grade = ['huruf' => 'E', 'desk' => 'Sangat Kurang / Tidak Lulus',
                          'class' => 'danger',  'bg' => '#dc3545'];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konversi Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .page-header { background: #fff; border-bottom: 1px solid #e0e0e0; padding: 16px 0; margin-bottom: 28px; }
        .page-header h4 { margin: 0; font-weight: 700; color: #1a1a2e; }
        .card { border: none; border-radius: 10px; box-shadow: 0 1px 8px rgba(0,0,0,.07); }
        .card-header { font-weight: 600; font-size: .95rem; border-radius: 10px 10px 0 0 !important; }
        .grade-badge {
            width: 100px; height: 100px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.8rem; font-weight: 800;
            color: #fff; margin: 0 auto 12px;
        }
        .table th { font-size: .83rem; text-transform: uppercase; letter-spacing: .04em; color: #666; }
    </style>
</head>
<body>

<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-calculator-fill text-secondary fs-5"></i>
            <h4>Konversi Nilai</h4>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <!-- Form Input -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="bi bi-input-cursor-text"></i> Masukkan Nilai
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <label class="form-label">Nilai (0 – 100)</label>
                        <div class="input-group">
                            <input type="number" name="nilai" class="form-control form-control-lg
                                   <?= $error ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($_POST['nilai'] ?? '') ?>"
                                   placeholder="Contoh: 85" min="0" max="100" autofocus>
                            <button type="submit" class="btn btn-secondary btn-lg">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                            <?php if ($error): ?>
                                <div class="invalid-feedback"><?= $error ?></div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hasil Konversi -->
            <?php if ($grade): ?>
            <div class="card mb-4">
                <div class="card-header bg-<?= $grade['class'] ?> text-<?= $grade['class'] === 'warning' ? 'dark' : 'white' ?>">
                    <i class="bi bi-check-circle"></i> Hasil Konversi
                </div>
                <div class="card-body text-center py-4">
                    <p class="text-muted mb-3">Nilai yang dimasukkan: <strong><?= $nilai ?></strong></p>
                    <div class="grade-badge" style="background: <?= $grade['bg'] ?>">
                        <?= $grade['huruf'] ?>
                    </div>
                    <div class="fs-5 fw-semibold mt-2"><?= $grade['desk'] ?></div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Tabel Referensi -->
            <div class="card">
                <div class="card-header bg-white">
                    <i class="bi bi-table text-secondary"></i> Tabel Konversi
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0 text-center">
                        <thead class="table-light">
                            <tr><th>Nilai</th><th>Grade</th><th>Keterangan</th></tr>
                        </thead>
                        <tbody>
                            <?php
                            $tabel = [
                                ['80 – 100', 'A', 'Sangat Baik',  'success'],
                                ['70 – 79',  'B', 'Baik',         'primary'],
                                ['60 – 69',  'C', 'Cukup',        'warning'],
                                ['50 – 59',  'D', 'Kurang',       'info'],
                                ['0 – 49',   'E', 'Sangat Kurang / Tidak Lulus', 'danger'],
                            ];
                            foreach ($tabel as $r): ?>
                            <tr <?= ($grade && $grade['huruf'] === $r[1]) ? 'class="table-active fw-bold"' : '' ?>>
                                <td><?= $r[0] ?></td>
                                <td><span class="badge bg-<?= $r[3] ?>"><?= $r[1] ?></span></td>
                                <td><?= $r[2] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
