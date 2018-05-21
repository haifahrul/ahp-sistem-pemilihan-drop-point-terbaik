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
$seleksiId = antiinjec(@$_GET['seleksi']);
$stat = @$_GET['stat'];
$id = antiinjec(@$_GET['id']);

if ($stat == "tambah") {
    $td = date('Y-m-d');
} elseif ($stat == "ubah") {
    $hdata = querydb("SELECT nama_alternatif, catatan, tgl_daftar FROM ahp_alternatif WHERE id_alternatif='$id'");
    $data = mysqli_fetch_array($hdata);
    $td = $data['tgl_daftar'];
}

if (@$_POST['stat_simpan']) {

    $id = antiinjec(@$_POST['id']);
    $nama_alternatif = antiinjec(@$_POST['nama_alternatif']);
    $catatan = antiinjec(@$_POST['catatan']);
    $tgl_daftar = antiinjec(@$_POST['tgl_daftar']);
    $seleksi = antiinjec(@$_POST['seleksi']);

    if ($stat == "tambah") {
        querydb("INSERT INTO ahp_alternatif(nama_alternatif, catatan, tgl_daftar, id_seleksi)
				 VALUES ('$nama_alternatif', '$catatan', '$tgl_daftar', '$seleksi')");

        ?>
        <script language="JavaScript">document.location = '?h=alternatif&seleksi=<?php echo $seleksi ?>&con=1'</script>
        <?php
    } elseif ($stat == "ubah") {
        querydb("UPDATE ahp_alternatif SET nama_alternatif='$nama_alternatif', catatan='$catatan', tgl_daftar='$tgl_daftar' 
				 WHERE id_alternatif='$id'");

        ?>
        <script language="JavaScript">document.location = '?h=alternatif&seleksi=<?php echo $seleksi ?>&con=2'</script>
        <?php
    }
}

?>

<div class="card">
    <div class="card-header">
        <h5>
            <?php
            if ($stat == "tambah") {
                echo "Tambah";
            } elseif ($stat == "ubah") {
                echo "Ubah";
            }

            ?> <?php echo $kasus_objek; ?>
        </h5>
    </div>
    <div class="card-block table-border-style">
        <table class="table">
            <tr>
                <td width="6%">Seleksi</td>
                <td width="47%" style="text-align:left;">:
                    <?php
                    $select = $stat == 'ubah' ? $seleksiId : $seleksi;
                    $hseleksi = querydb("SELECT id_seleksi, seleksi, tahun, catatan FROM ahp_seleksi WHERE id_seleksi='$select'");
                    $dseleksi = mysqli_fetch_array($hseleksi);
                    echo $dseleksi['tahun'] . " - " . $dseleksi['seleksi'];

                    ?>
                </td>
                <td width="47%">&nbsp;</td>
            </tr>
        </table> <br>

        <form action="?h=alternatif-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" id="form1">
            <input type="hidden" name="stat_simpan" value="set">
            <input type="hidden" name="seleksi" value="<?php echo $select; ?>" />
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama <?php echo $kasus_objek; ?></label>
                <div class="col-sm-10 validate">
                    <input class="form-control" data-validate-length-range="3" data-validate-words="1" name="nama_alternatif" value="<?php echo!empty($data['nama_alternatif']) ? $data['nama_alternatif'] : null; ?>" required data-toggle="tooltip" data-original-title="Name <?php echo $kasus_objek; ?>, tidak boleh disingkat"/>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-10 validate">
                    <textarea class="form-control" required name="catatan" rows="5"><?php echo!empty($data['catatan']) ? $data['catatan'] : null; ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Daftar</label>
                <div class="col-sm-10 validate">
                    <input class='form-control date' type="date" name="tgl_daftar" value="<?php echo $td; ?>" required>
                </div>
            </div>

            <a href="?h=alternatif&seleksi=<?php echo!empty($seleksiId) ? $seleksiId : $seleksi ?>" id='back' name="btn_kembali" class="btn btn-danger btn-sm btn-round">Kembali</a> &nbsp
            <button id='send' type='submit' name="btn_simpan" class="btn btn-primary btn-sm btn-round">Simpan Data</button>

        </form>
    </div>
</div>
