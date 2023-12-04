<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Master Pemilik</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                        <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
                        <li class="breadcrumb-item active">Pasien</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add">
                        <i class="fa-solid fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php
                $errors = session()->getFlashdata('errors');
                if (!empty($errors)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            <?php foreach ($errors as $key => $value) { ?>
                                <li><?= esc($value) ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <?php
                if (session()->getFlashdata('pesan')) {
                    echo '<div class="alert alert-success" role="alert">';
                    echo session()->getFlashdata('pesan');
                    echo '</div>';
                }
                ?>
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pemilik</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($pemilik as $key => $value) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['nama'] ?></td>
                                <td class="text-center"><img src="<?= base_url('assets/images/pasfoto/' . $value['pasfoto']) ?>" class="img-circle" width="50px" height="50px"></td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#info<?= $value['id_pemilik'] ?>"><i class="fa-solid fa-circle-info"></i></button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $value['id_pemilik'] ?>"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?= $value['id_pemilik'] ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Pemilik</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Modal Info -->
        <?php foreach ($pemilik as $key => $value) { ?>
            <div class="modal fade" id="info<?= $value['id_pemilik'] ?>">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Detail Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <th width="200px">Posisi</th>
                                        <td><?php if ($value['posisi'] == 7) {
                                                echo 'Pemilik';
                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Pemilik</th>
                                        <td><?= $value['nama'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td><?php if ($value['j_kel'] == "L") {
                                                echo 'Laki-Laki';
                                            } elseif ($value['j_kel'] == "P") {
                                                echo 'Perempuan';
                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?= $value['email'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nomor HP</th>
                                        <td><?= $value['no_hp'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td><?= $value['alamat'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>KTP</th>
                                        <td><img src="<?= base_url('assets/images/ktp/' . $value['up_ktp']) ?>" class="img-fluid pad" width="321px" height="188px"></td>
                                    </tr>
                                    <tr>
                                        <th>Pasfoto</th>
                                        <td><img src="<?= base_url('assets/images/pasfoto/' . $value['pasfoto']) ?>" class="img-fluid pad" width="113px" height="151px"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Modal Add -->
        <div class="modal fade" id="add">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        echo form_open_multipart('master/pemilik/add');
                        ?>

                        <div class="form-group">
                            <label for="nama">Nama Pemilik</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectBorderWidth2">Jenis Kelamin</label>
                            <select name="j_kel" class="form-control select2bs4">
                                <option value="">----- Jenis Kelamin -----</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor Handphone</label>
                            <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Nomor Handphone">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat"></textarea>
                        </div>
                        <div class="form-group">
                            <label>KTP</label>
                            <input name="ktp" class="form-control" type="file">
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <input name="foto" class="form-control" type="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <?php foreach ($pemilik as $key => $value) { ?>
            <div class="modal fade" id="edit<?= $value['id_pemilik'] ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php
                            echo form_open_multipart('master/pemilik/edit/' . $value['id_pemilik']);
                            ?>

                            <div class="form-group">
                                <label for="nama">Nama Pemilik</label>
                                <input type="text" name="nama" value="<?= $value['nama'] ?>" class="form-control" id="nama" placeholder="Nama Lengkap">
                            </div>
                            <div class="form-group">
                                <label for="exampleSelectBorderWidth2">Jenis Kelamin</label>
                                <select name="j_kel" class="form-control select2bs4">
                                    <option <?php if ($value['j_kel'] == '') {
                                                echo 'selected';
                                            } ?> value="">----- Jenis Kelamin -----</option>
                                    <option <?php if ($value['j_kel'] == 'L') {
                                                echo 'selected';
                                            } ?> value="L">Laki-Laki</option>
                                    <option <?php if ($value['j_kel'] == 'P') {
                                                echo 'selected';
                                            } ?> value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" value="<?= $value['email'] ?>" class="form-control" id="email" placeholder="Email" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nm_perawat">Nomor Handphone</label>
                                <input type="text" name="no_hp" value="<?= $value['no_hp'] ?>" class="form-control" id="no_hp" placeholder="Nomor Handphone" readonly>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat"><?= $value['alamat'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <img src="<?= base_url('assets/images/ktp/' . $value['up_ktp']) ?>" id="gambar_load" class="img-fluid pad" width="321px" height="188px">
                            </div>
                            <div class="form-group">
                                <label>Upload Ulang KTP</label>
                                <input name="ktp" id="preview_gambar" class="form-control" type="file">
                            </div>
                            <div class="form-group">
                                <img src="<?= base_url('assets/images/pasfoto/' . $value['pasfoto']) ?>" id="gambar_load" class="img-fluid pad" width="113px" height="151px">
                            </div>
                            <div class="form-group">
                                <label>Ganti Foto</label>
                                <input name="foto" id="preview_gambar" class="form-control" type="file">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        <?php } ?>

        <!-- Modal Delete -->
        <?php foreach ($pemilik as $key => $value) { ?>
            <div class="modal fade" id="delete<?= $value['id_pemilik'] ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Hapus Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Ingin Menghapus Data <b>Pemilik <?= $value['nama'] ?></b> ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                            <a href="<?= base_url('master/pemilik/delete/' . $value['id_pemilik']) ?>" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->