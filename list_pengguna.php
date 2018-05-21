<div class="card">
    <div class="card-header">
        <h5>Daftar Kriteria</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>No Telp</th>
                        <th>Hak Akses</th>
                        <th class="text-center">
                            <a href="?h=pengguna-input&stat=tambah" class="btn btn-primary btn-sm btn-round" style="width:98px;">Tambah</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    $hquery = querydb("SELECT id_pengguna, nama, no_telp, username, tipe FROM ahp_pengguna ORDER BY id_pengguna ASC");
                    while ($data = mysqli_fetch_array($hquery)) {
                        $no++;
                        if ($data['tipe'] == 1) {
                            $tipe_adm = "Normal";
                        } elseif ($data['tipe'] == 2) {
                            $tipe_adm = "Administrator";
                        }

                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $data['username']; ?></td>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['no_telp']; ?></td>
                            <td><?php echo $tipe_adm; ?></td>
                            <td width="8%" style="text-align:center;">
                                <script type="text/javascript">
                                    function konfirmasi<?php echo $data[0]; ?>() {
                                        var answer = confirm("Anda yakin akan menghapus data (<?php $data['username']; ?>) ini ?")
                                        if (answer) {
                                            window.location = "?h=pengguna-input&stat=hapus&id=<?php echo"$data[0]"; ?>";
                                        }
                                    }
                                </script>
                                <a href="?h=pengguna-input&stat=ubah&id=<?php echo $data['id_pengguna']; ?>" class="btn btn-success btn-sm btn-round">Ubah</a>
                                <a href="#" class="btn btn-danger btn-sm btn-round" onclick="konfirmasi<?php echo $data[0]; ?>()">Hapus</a>
                            </td>
                        </tr>
                    <?php } if (@$_GET['con'] != "") { ?>
                        <tr>
                            <td><img src="images/ico_cek.png" width="22"></td>
                            <td colspan="7" style="color:#360; font-weight:600; font-size:14px;">
                                <?php
                                if (@$_GET['con'] == 1) {
                                    echo "Data berhasil ditambahkan.";
                                } elseif (@$_GET['con'] == 2) {
                                    echo "Data berhasil diubah.";
                                } elseif (@$_GET['con'] == 3) {
                                    echo "Data berhasil dihapus.";
                                }

                                ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
