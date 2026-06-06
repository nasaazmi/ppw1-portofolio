<?php
require 'koneksi.php';

function predikat($ipk) {
    if ($ipk >= 3.51) return ['label' => 'Cumlaude',         'class' => 'success'];
    if ($ipk >= 3.01) return ['label' => 'Sangat Memuaskan', 'class' => 'primary'];
    if ($ipk >= 2.76) return ['label' => 'Memuaskan',        'class' => 'info'];
    if ($ipk >= 2.00) return ['label' => 'Cukup',            'class' => 'warning'];
    return                   ['label' => 'Tidak Lulus',      'class' => 'danger'];
}

$data = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY id ASC");

$pesan = $_GET['pesan'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .navbar-brand { font-weight: 700; }
        .card { border: none; border-radius: 10px; box-shadow: 0 1px 8px rgba(0,0,0,.08); }
        .table th { font-size: .83rem; text-transform: uppercase; letter-spacing: .04em; color: #666; }
        .badge { font-size: .78rem; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark mb-4" style="background-color: #475569;">
    <div class="container">
        <span class="navbar-brand"><i class="bi bi-people-fill"></i> Data Mahasiswa</span>
    </div>
</nav>

<div class="container pb-5">

    <?php if ($pesan === 'tambah'): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> Data berhasil ditambahkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif ($pesan === 'edit'): ?>
        <div class="alert alert-info alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> Data berhasil diperbarui!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif ($pesan === 'hapus'): ?>
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="bi bi-trash"></i> Data berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h6 class="mb-0 fw-bold"><i class="bi bi-table text-secondary"></i> Daftar Mahasiswa</h6>
            <a href="tambah.php" class="btn btn-secondary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Data
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Program Studi</th>
                            <th>IPK</th>
                            <th>Semester</th>
                            <th>Predikat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    if (mysqli_num_rows($data) == 0): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Belum ada data. <a href="tambah.php">Tambah sekarang</a>
                            </td>
                        </tr>
                    <?php else:
                        while ($row = mysqli_fetch_assoc($data)):
                            $p = predikat((float)$row['ipk']);
                    ?>
                        <tr>
                            <td class="text-muted"><?= $no++ ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($row['nama']) ?></td>
                            <td><code><?= htmlspecialchars($row['nim']) ?></code></td>
                            <td><?= htmlspecialchars($row['prodi']) ?></td>
                            <td><?= number_format($row['ipk'], 2) ?></td>
                            <td><?= $row['semester'] ?></td>
                            <td><span class="badge bg-<?= $p['class'] ?>"><?= $p['label'] ?></span></td>
                            <td class="text-center">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-outline-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="hapus.php?id=<?= $row['id'] ?>"
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Yakin hapus data <?= htmlspecialchars($row['nama']) ?>?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
