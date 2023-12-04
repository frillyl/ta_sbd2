<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Master Obat</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                        <li class="breadcrumb-item active">Obat</li>
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
                            <th>Nama Obat</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($obat as $key => $value) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['nm_obat'] ?></td>
                                <td><?= date('d-m-Y', strtotime($value['tgl_kadaluarsa'])) ?></td>
                                <td><?= $value['stok'] ?></td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#info<?= $value['id_obat'] ?>"><i class="fa-solid fa-circle-info"></i></button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $value['id_obat'] ?>"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?= $value['id_obat'] ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Obat</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Modal Info -->
        <?php foreach ($obat as $key => $value) { ?>
            <div class="modal fade" id="info<?= $value['id_obat'] ?>">
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
                                        <th width="200px">Pemasok</th>
                                        <td><?php if ($value['pemasok'] == 1) {
                                                echo 'PT Multiverse Anugerah Chemindo';
                                            } elseif ($value['pemasok'] == 2) {
                                                echo 'Dunia Cakrawala Abadi';
                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <td><?= $value['nm_obat'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Obat</th>
                                        <td><?php if ($value['jenis'] == 1) {
                                                echo 'Cair';
                                            } elseif ($value['jenis'] == 2) {
                                                echo 'Tablet';
                                            } elseif ($value['jenis'] == 3) {
                                                echo 'Kapsul';
                                            } elseif ($value['jenis'] == 4) {
                                                echo 'Oles';
                                            } elseif ($value['jenis'] == 5) {
                                                echo 'Supositoria';
                                            } elseif ($value['jenis'] == 6) {
                                                echo 'Tetes';
                                            } elseif ($value['jenis'] == 7) {
                                                echo 'Inhaler';
                                            } elseif ($value['jenis'] == 8) {
                                                echo 'Suntik';
                                            } elseif ($value['jenis'] == 9) {
                                                echo 'Implan';
                                            } elseif ($value['jenis'] == 10) {
                                                echo 'Sublingual';
                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td><?php if ($value['kategori'] == 1) {
                                                echo 'Bebas Terbatas';
                                            } elseif ($value['kategori'] == 2) {
                                                echo 'Bebas';
                                            } elseif ($value['kategori'] == 3) {
                                                echo 'Keras';
                                            } elseif ($value['kategori'] == 4) {
                                                echo 'Wajib Apotek';
                                            } elseif ($value['kategori'] == 5) {
                                                echo 'Golongan Narkotika';
                                            } elseif ($value['kategori'] == 6) {
                                                echo 'Psikotropika';
                                            } elseif ($value['kategori'] == 7) {
                                                echo 'Herbal';
                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Masuk</th>
                                        <td><?= date('d-m-Y H:i:s', strtotime($value['created_at'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Kadaluarsa</th>
                                        <td><?= date('d-m-Y', strtotime($value['tgl_kadaluarsa'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Stok</th>
                                        <td><?= $value['stok'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td><?= $value['harga'] ?></td>
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
                        echo form_open_multipart('master/obat/add');
                        ?>

                        <div class="callout callout-warning">
                            <h5><b>PERHATIAN!</b></h5>
                            <p>Pastikan Anda Memasukkan Tanggal Kadaluarsa Dengan Benar!
                                Karena Setelah Menyimpannya Anda Tidak Dapat Mengubah Tanggal Kadaluarsa Yang Telah Dimasukkan!
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="pemasok">Pemasok</label>
                            <select name="pemasok" id="pemasok" class="form-control select2bs4">
                                <option value="">----- Pemasok Obat -----</option>
                                <option value="1">PT Multiverse Anugerah Chemindo</option>
                                <option value="2">Dunia Cakrawala Abadi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nm_obat">Nama Obat</label>
                            <input type="text" name="nm_obat" class="form-control" id="nm_obat" placeholder="Nama Obat">
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis Obat</label>
                            <select name="jenis" id="jenis" class="form-control select2bs4">
                                <option value="">----- Jenis Obat -----</option>
                                <option value="1">Cair</option>
                                <option value="2">Tablet</option>
                                <option value="3">Kapsul</option>
                                <option value="4">Oles</option>
                                <option value="5">Supositoria</option>
                                <option value="6">Tetes</option>
                                <option value="7">Inhaler</option>
                                <option value="8">Suntik</option>
                                <option value="9">Implan</option>
                                <option value="10">Sublingual</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control select2bs4">
                                <option value="">----- Kategori Obat -----</option>
                                <option value="1">Bebas Terbatas</option>
                                <option value="2">Bebas</option>
                                <option value="3">Keras</option>
                                <option value="4">Wajib Apotek</option>
                                <option value="5">Golongan Narkotika</option>
                                <option value="6">Psikotropika</option>
                                <option value="7">Herbal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tgl_kadaluarsa">Tanggal Kadaluarsa</label>
                            <div class="input-group date" id="tgl_kadaluarsa" data-target-input="nearest">
                                <input type="text" name="tgl_kadaluarsa" class="form-control datetimepicker-input" data-target="#tgl_kadaluarsa" />
                                <div class="input-group-append" data-target="#tgl_kadaluarsa" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="text" name="stok" class="form-control " id="stok" placeholder="Stok">
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" name="harga" class="form-control " id="harga" placeholder="Harga">
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
        <?php foreach ($obat as $key => $value) { ?>
            <div class="modal fade" id="edit<?= $value['id_obat'] ?>">
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
                            echo form_open_multipart('master/obat/edit/' . $value['id_obat']);
                            ?>

                            <div class="form-group">
                                <label for="pemasok">Pemasok</label>
                                <select name="pemasok" id="pemasok" class="form-control select2bs4">
                                    <option <?php if ($value['pemasok'] == '') {
                                                echo 'selected';
                                            } ?> value="">----- Pemasok Obat -----</option>
                                    <option <?php if ($value['pemasok'] == 1) {
                                                echo 'selected';
                                            } ?> value="1">PT Multiverse Anugerah Chemindo</option>
                                    <option <?php if ($value['pemasok'] == 2) {
                                                echo 'selected';
                                            } ?> value="2">Dunia Cakrawala Abadi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nm_obat">Nama Obat</label>
                                <input type="text" name="nm_obat" value="<?= $value['nm_obat'] ?>" class="form-control " id="nm_obat" placeholder="Nama Obat">
                            </div>
                            <div class="form-group">
                                <label for="jenis">Jenis Obat</label>
                                <select name="jenis" id="jenis" class="form-control select2bs4">
                                    <option <?php if ($value['jenis'] == '') {
                                                echo 'selected';
                                            } ?> value="">----- Jenis Obat -----</option>
                                    <option <?php if ($value['jenis'] == 1) {
                                                echo 'selected';
                                            } ?> value="1">Cair</option>
                                    <option <?php if ($value['jenis'] == 2) {
                                                echo 'selected';
                                            } ?> value="2">Tablet</option>
                                    <option <?php if ($value['jenis'] == 3) {
                                                echo 'selected';
                                            } ?> value="3">Kapsul</option>
                                    <option <?php if ($value['jenis'] == 4) {
                                                echo 'selected';
                                            } ?> value="4">Oles</option>
                                    <option <?php if ($value['jenis'] == 5) {
                                                echo 'selected';
                                            } ?> value="5">Supositoria</option>
                                    <option <?php if ($value['jenis'] == 6) {
                                                echo 'selected';
                                            } ?> value="6">Tetes</option>
                                    <option <?php if ($value['jenis'] == 7) {
                                                echo 'selected';
                                            } ?> value="7">Inhaler</option>
                                    <option <?php if ($value['jenis'] == 8) {
                                                echo 'selected';
                                            } ?> value="8">Suntik</option>
                                    <option <?php if ($value['jenis'] == 9) {
                                                echo 'selected';
                                            } ?> value="9">Implan</option>
                                    <option <?php if ($value['jenis'] == 10) {
                                                echo 'selected';
                                            } ?> value="10">Sublingual</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control select2bs4">
                                    <option <?php if ($value['kategori'] == '') {
                                                echo 'selected';
                                            } ?> value="">----- Kategori Obat -----</option>
                                    <option <?php if ($value['kategori'] == 1) {
                                                echo 'selected';
                                            } ?> value="1">Bebas Terbatas</option>
                                    <option <?php if ($value['kategori'] == 2) {
                                                echo 'selected';
                                            } ?> value="2">Bebas</option>
                                    <option <?php if ($value['kategori'] == 3) {
                                                echo 'selected';
                                            } ?> value="3">Keras</option>
                                    <option <?php if ($value['kategori'] == 4) {
                                                echo 'selected';
                                            } ?> value="4">Wajib Apotek</option>
                                    <option <?php if ($value['kategori'] == 5) {
                                                echo 'selected';
                                            } ?> value="5">Golongan Narkotika</option>
                                    <option <?php if ($value['kategori'] == 6) {
                                                echo 'selected';
                                            } ?> value="6">Psikotropika</option>
                                    <option <?php if ($value['kategori'] == 7) {
                                                echo 'selected';
                                            } ?> value="7">Herbal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="text" name="stok" value="<?= $value['stok'] ?>" class="form-control " id="stok" placeholder="Stok">
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="text" name="harga" value="<?= $value['harga'] ?>" class="form-control " id="harga" placeholder="Harga">
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
        <?php foreach ($obat as $key => $value) { ?>
            <div class="modal fade" id="delete<?= $value['id_obat'] ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Hapus Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda Yakin Ingin Menghapus Data <b>Obat <?= $value['nm_obat'] ?></b> ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                            <a href="<?= base_url('master/obat/delete/' . $value['id_obat']) ?>" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->