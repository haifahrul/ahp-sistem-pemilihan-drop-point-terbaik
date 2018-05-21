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
$seleksi = antiinjec(@$_POST['seleksi']);
$stat = @$_GET['stat'];
$id = antiinjec(@$_GET['id']);

if (@$_POST['stat_simpan']) {

    $seleksi = antiinjec(@$_POST['seleksi']);
    $id_kriteria = @$_POST['id_kriteria'];

    if ($stat == "tambah") {
        $jml = count($id_kriteria);
        for ($i = 0; $i < $jml; $i++) {
            opendb();
            $query = "INSERT INTO ahp_kriteria_seleksi(id_seleksi, id_kriteria)
				 	 VALUES ('$seleksi', '$id_kriteria[$i]')";
            querydb($query);
            closedb();
        }

        ?>
        <script language="JavaScript">
            notify('Data berhasil disimpan &nbsp');
        </script>
        <?php
    }
}

?>

<div class="card">
    <div class="card-header">
        <h5>Tambah Kriteria Untuk Seleksi (ke Dalam Seleksi)</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td width="6%">Seleksi</td>
                    <td width="47%" style="text-align:left;">:
                        <?php
                        $hseleksi = querydb("SELECT id_seleksi, seleksi, tahun, catatan FROM ahp_seleksi WHERE id_seleksi='$seleksi'");
                        $dseleksi = mysqli_fetch_array($hseleksi);
                        echo $dseleksi['tahun'] . " - " . $dseleksi['seleksi'];

                        ?>
                    </td>
                    <td width="47%">&nbsp;</td>
                </tr>
                <form action="?h=kriteria-seleksi-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" id="form1">
                    <input type="hidden" name="seleksi" value="<?php echo $seleksi; ?>" />
                    <input type="hidden" name="stat_simpan" value="set">
                    <table width="100%" border="0" cellspacing="0" cellpadding="4">
                        <tr>
                            <td width="3%">No.</td>
                            <td width="2%"><img src="images/ico_cek.png" width="20px" /></td>
                            <td width="36%">Nama Kriteria</td>
                            <td width="59%">Keterangan</td>
                        </tr>
                        <?php
                        $no = 0;
                        $hquery = querydb("SELECT a.id_kriteria, a.kriteria, a.keterangan
					   FROM ahp_kriteria as a
					   WHERE (a.id_kriteria NOT IN (SELECT id_kriteria FROM ahp_kriteria_seleksi WHERE id_seleksi='$seleksi'))
					   ORDER BY a.id_kriteria ASC");
                        $jml_baris = mysqli_num_rows($hquery);
                        while ($data = mysqli_fetch_array($hquery)) {
                            $no++;

                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><input type="checkbox" name="id_kriteria[]" value="<?php echo"$data[id_kriteria]"; ?>"/></td>
                                <td><?php echo $data['kriteria']; ?></td>
                                <td><?php echo $data['keterangan']; ?></td>
                            </tr>
                        <?php } if ($jml_baris == 0) { ?>
                            <tr>
                                <td><img src="images/ico_alert.png" width="22"></td>
                                <td colspan="7" style="color:#F30; font-weight:600; font-size:14px;">Belum ada data</td>
                            </tr>
                        <?php } ?>
                    </table> <br>
                    <a href="?h=kriteria-seleksi&seleksi= <?php echo $seleksi ?>" id='back' name="btn_kembali" class="btn btn-danger btn-sm btn-round">Kembali</a> &nbsp
                    <?php if ($jml_baris > 0) { ?>
                        <button id='send' type='submit' name="btn_simpan" class="btn btn-primary btn-sm btn-round">Simpan Data</button>
                    <?php } ?>
                </form>
            </table>
        </div>
    </div>
</div>

