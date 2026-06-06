<?php
$data   = null;
$errors = [];

$prodiList = [
    'Teknik Informatika',
    'Sistem Informasi',
    'Teknik Komputer',
    'Manajemen Informatika',
    'Ilmu Komputer',
];

function predikatIPK($ipk) {
    if ($ipk >= 3.51) return ['label' => 'Dengan Pujian (Cumlaude)', 'class' => 'success'];
    if ($ipk >= 3.01) return ['label' => 'Sangat Memuaskan',         'class' => 'secondary'];
    if ($ipk >= 2.76) return ['label' => 'Memuaskan',                'class' => 'info'];
    if ($ipk >= 2.00) return ['label' => 'Cukup',                    'class' => 'warning'];
    return                   ['label' => 'Tidak Memenuhi Syarat Lulus','class' => 'danger'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil & sanitasi input
    $nama     = trim($_POST['nama']     ?? '');
    $nim      = trim($_POST['nim']      ?? '');
    $prodi    = $_POST['prodi']          ?? '';
    $ipkRaw   = $_POST['ipk']            ?? '';
    $semRaw   = $_POST['semester']       ?? '';

    // Validasi
    if ($nama === '') {
        $errors['nama'] = 'Nama wajib diisi.';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
        $errors['nama'] = 'Nama hanya boleh huruf dan spasi.';
    }

    if ($nim === '') {
        $errors['nim'] = 'NIM wajib diisi.';
    } elseif (!preg_match('/^\d+$/', $nim)) {
        $errors['nim'] = 'NIM hanya boleh berisi angka.';
    }

    if (!in_array($prodi, $prodiList)) {
        $errors['prodi'] = 'Program Studi wajib dipilih.';
    }

    if ($ipkRaw === '' || !is_numeric($ipkRaw)) {
        $errors['ipk'] = 'IPK wajib diisi berupa angka.';
    } elseif ((float)$ipkRaw < 0 || (float)$ipkRaw > 4) {
        $errors['ipk'] = 'IPK harus antara 0.00 – 4.00.';
    }

    if ($semRaw === '' || !is_numeric($semRaw)) {
        $errors['semester'] = 'Semester wajib diisi.';
    } elseif ((int)$semRaw < 1 || (int)$semRaw > 14) {
        $errors['semester'] = 'Semester harus antara 1 – 14.';
    }

    // Jika tidak ada error → simpan ke $data untuk ditampilkan
    if (empty($errors)) {
        $data = [
            'nama'     => htmlspecialchars($nama,     ENT_QUOTES, 'UTF-8'),
            'nim'      => htmlspecialchars($nim,      ENT_QUOTES, 'UTF-8'),
            'prodi'    => htmlspecialchars($prodi,    ENT_QUOTES, 'UTF-8'),
            'ipk'      => number_format((float)$ipkRaw, 2),
            'semester' => (int)$semRaw,
            'predikat' => predikatIPK((float)$ipkRaw),
        ];
    }
}

// Helper: tampilkan nilai lama di form jika ada error
function old($key, $default = '') {
    return htmlspecialchars($_POST[$key] ?? $default, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .page-header { background: #fff; border-bottom: 1px solid #e0e0e0; padding: 16px 0; margin-bottom: 28px; }
        .page-header h4 { margin: 0; font-weight: 700; color: #1a1a2e; }
        .card { border: none; border-radius: 10px; box-shadow: 0 1px 8px rgba(0,0,0,.07); }
        .card-header { font-weight: 600; font-size: .95rem; border-radius: 10px 10px 0 0 !important; }
        .result-row { display: flex; justify-content: space-between;
                      padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
        .result-row:last-child { border: none; }
        .result-label { color: #888; font-size: .9rem; }
        .result-val   { font-weight: 600; font-size: .95rem; }
    </style>
</head>
<body>

<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-badge-fill text-secondary fs-5"></i>
            <h4>Pendataan Mahasiswa</h4>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <!-- ── FORM ── -->
            <?php if (!$data): ?>
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <i class="bi bi-pencil-square"></i> Isi Data Mahasiswa
                </div>
                <div class="card-body">
                    <form method="POST" action="" novalidate>

                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama"
                                   class="form-control <?= isset($errors['nama']) ? 'is-invalid' : (isset($_POST['nama']) ? 'is-valid' : '') ?>"
                                   value="<?= old('nama') ?>" placeholder="Nama lengkap" maxlength="100">
                            <?php if (isset($errors['nama'])): ?>
                                <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim"
                                   class="form-control <?= isset($errors['nim']) ? 'is-invalid' : (isset($_POST['nim']) ? 'is-valid' : '') ?>"
                                   value="<?= old('nim') ?>" placeholder="Nomor Induk Mahasiswa" maxlength="20">
                            <?php if (isset($errors['nim'])): ?>
                                <div class="invalid-feedback"><?= $errors['nim'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                            <select name="prodi"
                                    class="form-select <?= isset($errors['prodi']) ? 'is-invalid' : (isset($_POST['prodi']) && !isset($errors['prodi']) ? 'is-valid' : '') ?>">
                                <option value="">-- Pilih Program Studi --</option>
                                <?php foreach ($prodiList as $p): ?>
                                    <option value="<?= $p ?>" <?= (($_POST['prodi'] ?? '') === $p) ? 'selected' : '' ?>>
                                        <?= $p ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['prodi'])): ?>
                                <div class="invalid-feedback"><?= $errors['prodi'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label">IPK <span class="text-danger">*</span></label>
                                <input type="number" name="ipk"
                                       class="form-control <?= isset($errors['ipk']) ? 'is-invalid' : (isset($_POST['ipk']) ? 'is-valid' : '') ?>"
                                       value="<?= old('ipk') ?>" placeholder="0.00 – 4.00"
                                       step="0.01" min="0" max="4">
                                <?php if (isset($errors['ipk'])): ?>
                                    <div class="invalid-feedback"><?= $errors['ipk'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Semester <span class="text-danger">*</span></label>
                                <input type="number" name="semester"
                                       class="form-control <?= isset($errors['semester']) ? 'is-invalid' : (isset($_POST['semester']) ? 'is-valid' : '') ?>"
                                       value="<?= old('semester') ?>" placeholder="1 – 14"
                                       min="1" max="14">
                                <?php if (isset($errors['semester'])): ?>
                                    <div class="invalid-feedback"><?= $errors['semester'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-secondary">
                                <i class="bi bi-send"></i> Kirim Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ── HASIL ── -->
            <?php else: ?>
            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-check-circle"></i> Data Berhasil Disimpan
                </div>
                <div class="card-body">
                    <div class="result-row">
                        <span class="result-label">Nama</span>
                        <span class="result-val"><?= $data['nama'] ?></span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">NIM</span>
                        <span class="result-val"><code><?= $data['nim'] ?></code></span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">Program Studi</span>
                        <span class="result-val"><?= $data['prodi'] ?></span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">IPK</span>
                        <span class="result-val"><?= $data['ipk'] ?></span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">Semester</span>
                        <span class="result-val"><?= $data['semester'] ?></span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">Predikat Kelulusan</span>
                        <span class="result-val">
                            <span class="badge bg-<?= $data['predikat']['class'] ?> fs-6">
                                <?= $data['predikat']['label'] ?>
                            </span>
                        </span>
                    </div>

                    <div class="d-grid mt-4">
                        <a href="pendataan_mahasiswa.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-repeat"></i> Isi Data Baru
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
