<?php
$stat = @$_GET['stat'];
$id = antiinjec(@$_GET['id']);
if ($stat == "tambah") {
    $tl = date('Y-m-d', strtotime("-15 years"));
} elseif ($stat == "ubah") {
    $hdata = querydb("SELECT id_kriteria, kriteria, keterangan, is_konversi FROM ahp_kriteria WHERE id_kriteria='$id'");
    $data = mysqli_fetch_array($hdata);
}
if (@$_POST['stat_simpan']) {

    $id = antiinjec(@$_POST['id']);
    $kriteria = antiinjec(@$_POST['kriteria']);
    $keterangan = antiinjec(@$_POST['keterangan']);
    $is_konversi = antiinjec(@$_POST['is_konversi']);
    $is_konversi = empty($is_konversi) ? 1 : $is_konversi;

    if ($stat == "tambah") {
        $d_cek = mysqli_fetch_array(querydb("SELECT count(*) FROM ahp_kriteria WHERE kriteria='$kriteria'"));
        if ($d_cek[0] == 0) {
            querydb("INSERT INTO ahp_kriteria(kriteria, keterangan, is_konversi)
					 VALUES ('$kriteria', '$keterangan', '$is_konversi')");

            ?>
            <script language="JavaScript">document.location = '?h=kriteria&con=1'</script>
            <?php
        } else {
            echo "<div class='warning'>Kriteria $kriteria sudah ada. </div>";

            ?>
            <script language="JavaScript">alert('Kriteria [<?php echo $kriteria; ?>] sudah ada.'); history.go(-1);</script>
            <?php
        }
    } elseif ($stat == "ubah") {
        $d_cek = mysqli_fetch_array(querydb("SELECT count(*) FROM ahp_kriteria WHERE kriteria='$kriteria' AND id_kriteria<>'$id'"));
        echo $kriteria;
        if ($d_cek[0] == 0) {
            querydb("UPDATE ahp_kriteria SET kriteria='$kriteria', keterangan='$keterangan', is_konversi='$is_konversi' WHERE id_kriteria='$id'");

            ?>
            <script language="JavaScript">document.location = '?h=kriteria&con=2'</script>
            <?php
        } else {
            //echo "<div class='warning'>Kriteria [$kriteria] sudah ada. </div>";

            ?>
            <script language="JavaScript">alert('Kriteria [<?php echo $kriteria; ?>] sudah ada.'); history.go(-1);</script>
            <?php
        }
    }
} elseif ($stat == "hapus" && $id != "") {
    querydb("DELETE FROM ahp_kriteria WHERE id_kriteria='$id'");

    ?>
    <script language="JavaScript">document.location = '?h=kriteria&con=3'</script>
    <?php
}

?>
<div class="card form">
    <div class="card-block">
        <h4 class="sub-title">
            <?php
            if ($stat == "tambah") {
                echo "Tambah";
            } elseif ($stat == "ubah") {
                echo "Ubah";
            }

            ?> Kriteria
        </h4>
        <section class='form'>
            <form action="?h=kriteria-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="stat_simpan" value="set">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Krieria</label>
                    <div class="col-sm-10 validate">
                        <input class="form-control" data-validate-length-range="5" data-validate-words="1" name="kriteria" value="<?php echo!empty($data['kriteria']) ? $data['kriteria'] : null; ?>" required data-toggle="tooltip" data-original-title="Isi dengan nama kriteria"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10 validate">
                        <textarea class="form-control" name="keterangan" rows="5"><?php echo!empty($data['keterangan']) ? $data['keterangan'] : null ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Apakah Butuh Nilai Konversi?</label>
                    <div class="col-sm-10 validate">

                        <input type="radio" name="is_konversi" value="1" <?php echo !empty($data['is_konversi']) ? $data['is_konversi'] == 1 ? 'checked' : null : NULL ?>> Tidak<br>
                        <input type="radio" name="is_konversi" value="2" <?php echo !empty($data['is_konversi']) ? $data['is_konversi'] == 2 ? 'checked' : null : null ?>> Ya<br>
                    </div>
                </div>

                <button id='send' type='submit' name="btn_simpan" class="btn btn-primary btn-sm btn-round">Simpan Data</button>
                <button id='send' type='button' class="btn btn-danger btn-sm btn-round" onclick="window.history.back();">Batal</button>
            </form>
        </section>
    </div>
</div>
