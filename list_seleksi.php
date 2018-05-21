<div class="card">
    <div class="card-header">
        <h5>Daftar Seleksi</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Seleksi (Nama Seleksi)</th>
                        <th>Catatan</th>
                        <th class="text-center">
                            <a href="?h=seleksi-input&stat=tambah" class="btn btn-primary btn-sm btn-round" style="width:98px;">Tambah</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    $hquery = querydb("SELECT id_seleksi, seleksi, tahun, catatan FROM ahp_seleksi ORDER BY id_seleksi ASC");
                    while ($data = mysqli_fetch_array($hquery)) {
                        $no++;

                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $data['tahun']; ?></td>
                            <td><?php echo $data['seleksi']; ?></td>
                            <td><?php echo $data['catatan']; ?></td>
                            <td width="10%" style="text-align:center;">
                                <script type="text/javascript">
                                    function konfirmasi<?php echo $data[0]; ?>() {
                                        var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['tahun'] . "-" . $data['seleksi']; ?>) ini ?")
                                        if (answer) {
                                            window.location = "?h=seleksi-input&stat=hapus&id=<?php echo"$data[0]"; ?>";
                                        }
                                    }
                                </script>
                                <a href="?h=seleksi-input&stat=ubah&id=<?php echo $data['id_seleksi']; ?>" class="btn btn-success btn-sm btn-round">Ubah</a>
                                <a href="#" onclick="konfirmasi<?php echo $data[0]; ?>()" class="btn btn-danger btn-sm btn-round">Hapus</a>
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

<script type="text/javascript">
    
</script>