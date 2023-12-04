<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
        <img src="<?= base_url() ?>/assets/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>Pratama Medika</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets/images/pasfoto/' . session()->get('pasfoto')) ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php if (session()->get('level') == 1) { ?>
                        <?= session()->get('nama') ?>
                    <?php } elseif (session()->get('level') == 2) { ?>
                        <?= session()->get('nama') ?>
                    <?php } elseif (session()->get('level') == 3) { ?>
                        <?= session()->get('nama') ?>
                    <?php } elseif (session()->get('level') == 4) { ?>
                        <?= session()->get('nama') ?>
                    <?php } elseif (session()->get('level') == 5) { ?>
                        <?= session()->get('nama') ?>
                    <?php } ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= base_url('petugas') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">DATA MASTER</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-users"></i>
                        <p>
                            Pengguna
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="<?= base_url('master/dokter') ?>" class="nav-link">
                                <i class="fa-solid fa-user-doctor nav-icon"></i>
                                <p>Dokter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/nakes') ?>" class="nav-link">
                                <i class="fa-solid fa-user-nurse nav-icon"></i>
                                <p>Tenaga Kesehatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/pasien') ?>" class="nav-link">
                                <i class="fa-solid fa-user-injured nav-icon"></i>
                                <p>Pasien</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/pemilik') ?>" class="nav-link">
                                <i class="fa-solid fa-user-tie nav-icon"></i>
                                <p>Pemilik</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/petugas') ?>" class="nav-link">
                                <i class="fa-solid fa-user-secret nav-icon"></i>
                                <p>Petugas</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/obat') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-pills"></i>
                        <p>
                            Obat
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/lab') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-microscope"></i>
                        <p>
                            Laboratorium
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/rs') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-hospital"></i>
                        <p>
                            Rumah Sakit
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/poli') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-circle-h"></i>
                        <p>
                            Poli
                        </p>
                    </a>
                </li>
                <li class="nav-header">JADWAL</li>
                <li class="nav-item">
                    <a href="<?= base_url('jadwal/dokter') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-calendar-days"></i>
                        <p>
                            Praktik Dokter
                        </p>
                    </a>
                </li>
                <li class="nav-header">LAYANAN</li>
                <li class="nav-item">
                    <a href="<?= base_url('layanan/kunjungan') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-stethoscope"></i>
                        <p>
                            Kunjungan Berobat
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('layanan/resep') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-prescription"></i>
                        <p>
                            Resep Obat
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('layanan/rekmed') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-notes-medical"></i>
                        <p>
                            Rekam Medis
                        </p>
                    </a>
                </li>
                <li class="nav-header">RUJUKAN</li>
                <li class="nav-item">
                    <a href="<?= base_url('rujukan/lab') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-microscope"></i>
                        <p>
                            Laboratorium
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('rujukan/rs') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-hospital"></i>
                        <p>
                            Rumah Sakit
                        </p>
                    </a>
                </li>
                <li class="nav-header">KEUANGAN</li>
                <li class="nav-item">
                    <a href="<?= base_url('rujukan/lab') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-invoice"></i>
                        <p>
                            Tagihan
                        </p>
                    </a>
                </li>
                <li class="nav-header">KASIR</li>
                <li class="nav-item">
                    <a href="<?= base_url('rujukan/rs') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-money-bill"></i>
                        <p>
                            Pembayaran
                        </p>
                    </a>
                </li>
                <li class="nav-header">APOTEK</li>
                <li class="nav-item">
                    <a href="<?= base_url('apotek/resep') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-prescription"></i>
                        <p>
                            Resep Obat
                        </p>
                    </a>
                </li>
                <li class="nav-header">LAPORAN</li>
                <li class="nav-item">
                    <a href="<?= base_url('apotek/resep') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-prescription"></i>
                        <p>
                            Keuangan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('apotek/resep') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-prescription"></i>
                        <p>
                            Stok Obat
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>