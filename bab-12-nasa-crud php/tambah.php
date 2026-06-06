<?php
require 'koneksi.php';

$error = '';
$prodiList = [
    'Teknik Informatika',
    'Sistem Informasi',
    'Teknik Komputer',
    'Manajemen Informatika',
    'Ilmu Komputer',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $nim      = mysqli_real_escape_string($conn, trim($_POST['nim']));
    $prodi    = mysqli_real_escape_string($conn, $_POST['prodi']);
    $ipk      = floatval($_POST['ipk']);
    $semester = intval($_POST['semester']);

    if (!$nama || !$nim || !$prodi || $ipk < 0 || $ipk > 4 || $semester < 1 || $semester > 14) {
        $error = 'Semua field wajib diisi dengan benar!';
    } else {
        $sql = "INSERT INTO mahasiswa (nama, nim, prodi, ipk, semester)
                VALUES ('$nama', '$nim', '$prodi', $ipk, $semester)";

        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?pesan=tambah");
            exit;
        } else {
            $error = 'Gagal menyimpan. NIM mungkin sudah terdaftar.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .card { border: none; border-radius: 10px; box-shadow: 0 1px 8px rgba(0,0,0,.08); }
        .card-header { border-radius: 10px 10px 0 0 !important; font-weight: 600; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-4" style="background-color: #475569;">
    <div class="container">
        <span class="navbar-brand"><i class="bi bi-person-plus-fill"></i> Tambah Mahasiswa</span>
        <a href="index.php" class="btn btn-outline-light btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</nav>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <i class="bi bi-plus-circle"></i> Form Tambah Data
                </div>
                <div class="card-body">

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">

                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control"
                                   value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>"
                                   placeholder="Nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control"
                                   value="<?= htmlspecialchars($_POST['nim'] ?? '') ?>"
                                   placeholder="Nomor Induk Mahasiswa" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                            <select name="prodi" class="form-select" required>
                                <option value="">-- Pilih Prodi --</option>
                                <?php foreach ($prodiList as $p): ?>
                                    <option value="<?= $p ?>"
                                        <?= (($_POST['prodi'] ?? '') === $p) ? 'selected' : '' ?>>
                                        <?= $p ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label">IPK <span class="text-danger">*</span></label>
                                <input type="number" name="ipk" class="form-control"
                                       value="<?= htmlspecialchars($_POST['ipk'] ?? '') ?>"
                                       placeholder="0.00 – 4.00" step="0.01" min="0" max="4" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Semester <span class="text-danger">*</span></label>
                                <input type="number" name="semester" class="form-control"
                                       value="<?= htmlspecialchars($_POST['semester'] ?? '') ?>"
                                       placeholder="1 – 14" min="1" max="14" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-secondary">
                                <i class="bi bi-save"></i> Simpan Data
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="bi bi-x"></i> Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
