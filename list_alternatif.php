<script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript">
    function notify(message) {
        $.growl(message, {
            placement: {from: 'top', align: 'center'},
            ele: 'body', // which element to append to
            type: 'info', // (null, 'info', 'danger', 'success')
            offset: {x: 30, y: 20}, // 'top', or 'bottom'
            align: 'center', // ('left', 'right', or 'center')
            width: 250, // (integer, or 'auto')
            delay: 2500, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
//            timer: 5000,
            allow_dismiss: true, // If true then will display a cross to close the popup.
            stackup_spacing: 40 // spacing between consecutively stacked growls.
        });
    }
</script>

<?php
$seleksi = antiinjec(@$_GET['seleksi']);
$stat = @$_GET['stat'];
$id = antiinjec(@$_GET['id']);

if ($stat == "hapus" && !empty($id)) {
    $check = querydb("SELECT * FROM ahp_alternatif WHERE id_alternatif='$id'");

    if (!empty($check->num_rows)) {
        querydb("DELETE FROM ahp_alternatif WHERE id_alternatif='$id'");

        ?>
        <script language="JavaScript">
            notify('Data berhasil dihapus &nbsp');
        </script>
        <?php
    }
}

?>

<div class="card">
    <div class="card-header">
        <h5>Daftar <?php echo $kasus_objek; ?> (Alternatif)</h5>
        <span> Seleksi
            <form method="get" enctype="multipart/form-data" action="">
                <input type="hidden" name="h" value="alternatif">
                <select class="required" name="seleksi" style="width:300px;">
                    <option value="0"></option>
                    <?php
                    $hseleksi = querydb("SELECT id_seleksi, seleksi, tahun, catatan FROM ahp_seleksi ORDER BY tahun DESC, id_seleksi DESC");
                    while ($dseleksi = mysqli_fetch_array($hseleksi)) {

                        ?>
                        <option value="<?php echo $dseleksi['id_seleksi']; ?>" <?php
                        if ($dseleksi['id_seleksi'] == $seleksi) {
                            echo "selected";
                        }

                        ?>><?php echo $dseleksi['tahun'] . " - " . $dseleksi['seleksi']; ?></option>
                            <?php } ?>
                </select> &nbsp
                <button type='submit' name="btn_cari" class="btn btn-primary btn-sm btn-round">Cari</button>
            </form>
        </span>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alternatif</th>
                        <th>Catatan</th>
                        <th>Tgl Terdaftar</th>
                        <th class="text-center">
                            <!--<a href="?h=alternatif-input&stat=tambah" class="btn btn-primary btn-sm btn-round" style="width:98px;">Tambah</a>-->
                            <form method="post" enctype="multipart/form-data" action="?h=alternatif-input&stat=tambah">
                                <input type="hidden" name="seleksi" value="<?php echo $seleksi; ?>" />
                                <?php echo!empty($seleksi) ? "<button type='submit' name='btn_tambah' class='btn btn-primary btn-sm btn-round'>Tambah</button>" : null ?>
                            </form>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    $hquery = querydb("SELECT id_alternatif, nama_alternatif, catatan, tgl_daftar 
					   FROM ahp_alternatif
					   WHERE id_seleksi='$seleksi' ORDER BY id_alternatif ASC");
                    $jml_baris = mysqli_num_rows($hquery);
                    while ($data = mysqli_fetch_array($hquery)) {
                        $no++;

                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $data['nama_alternatif']; ?></td>
                            <td><?php echo $data['catatan']; ?></td>
                            <td><?php echo date("d/m/Y", strtotime($data['tgl_daftar'])); ?></td>
                            <td style="text-align:center;">
                                <a href="?h=alternatif-input&stat=ubah&seleksi=<?php echo $seleksi ?>&id=<?php echo $data['id_alternatif']; ?>" class="btn btn-success btn-sm btn-round">Ubah</a>
                                <!--<a href="#" class="btn btn-danger btn-sm btn-round" onclick="konfirmasi<?php echo $data[0]; ?>()">Hapus</a>-->
                                <a href="#" class="btn btn-danger btn-sm btn-round" onclick="konfirmasi(<?php echo $data[0] ?>, '<?php echo $seleksi ?>', '<?php echo $data['nama_alternatif'] ?>')">Hapus</a>
                            </td>
                        </tr>
                    <?php } if (@$_GET['con'] != "" && !empty($_GET['seleksi'])) { ?>
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
                            </td>
                        </tr>
                    <?php } if (empty($seleksi)) { ?>
                        <tr>
                            <td><img src="images/ico_alert.png" width="22"></td>
                            <td colspan="7" style="color:#F30; font-weight:600; font-size:14px;">Silahkan pilih seleksi</td>
                        </tr>
                    <?php } elseif ($jml_baris == 0) { ?>
                        <tr>
                            <td><img src="images/ico_alert.png" width="22"></td>
                            <td colspan="7" style="color:#F30; font-weight:600; font-size:14px;">Belum ada data</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function konfirmasi(id, seleksi, nama) {
        var answer = confirm("Anda yakin akan menghapus data " + nama + " ?")
        if (answer) {
            window.location = "?h=alternatif&seleksi=" + seleksi + "&stat=hapus&id=" + id;
        }
    }
</script>