<?php
require 'koneksi.php';

$error = '';
$prodiList = [
    'Teknologi Rekayasa Perangkat Lunak',
    'Teknologi Rekayasa Internet',
    'Teknologi Rekayasa Elektro',
    'Teknologi Rekayasa Instrumentasi dan Kontrol',
];

$id     = intval($_GET['id'] ?? 0);
$result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id = $id");
$row    = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $nim      = mysqli_real_escape_string($conn, trim($_POST['nim']));
    $prodi    = mysqli_real_escape_string($conn, $_POST['prodi']);
    $ipk      = floatval($_POST['ipk']);
    $semester = intval($_POST['semester']);

    if (!$nama || !$nim || !$prodi || $ipk < 0 || $ipk > 4 || $semester < 1 || $semester > 14) {
        $error = 'Semua field wajib diisi dengan benar!';
    } else {
        $sql = "UPDATE mahasiswa SET
                    nama     = '$nama',
                    nim      = '$nim',
                    prodi    = '$prodi',
                    ipk      = $ipk,
                    semester = $semester
                WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?pesan=edit");
            exit;
        } else {
            $error = 'Gagal memperbarui data.';
        }
    }

    $row = array_merge($row, $_POST);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
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
        <span class="navbar-brand text-white"><i class="bi bi-pencil-square"></i> Edit Mahasiswa</span>
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
                    <i class="bi bi-pencil"></i> Form Edit Data
                </div>
                <div class="card-body">

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" action="edit.php?id=<?= $id ?>">

                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control"
                                   value="<?= htmlspecialchars($row['nama']) ?>"
                                   placeholder="Nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control"
                                   value="<?= htmlspecialchars($row['nim']) ?>"
                                   placeholder="Nomor Induk Mahasiswa" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                            <select name="prodi" class="form-select" required>
                                <option value="">-- Pilih Prodi --</option>
                                <?php foreach ($prodiList as $p): ?>
                                    <option value="<?= $p ?>"
                                        <?= ($row['prodi'] === $p) ? 'selected' : '' ?>>
                                        <?= $p ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label">IPK <span class="text-danger">*</span></label>
                                <input type="number" name="ipk" class="form-control"
                                       value="<?= $row['ipk'] ?>"
                                       placeholder="0.00 – 4.00" step="0.01" min="0" max="4" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Semester <span class="text-danger">*</span></label>
                                <input type="number" name="semester" class="form-control"
                                       value="<?= $row['semester'] ?>"
                                       placeholder="1 – 14" min="1" max="14" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-secondary text-white">
                                <i class="bi bi-save"></i> Simpan Perubahan
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
