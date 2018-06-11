<?php
$stat = @$_GET['stat'];
$id = antiinjec(@$_GET['id']);
if ($stat == "tambah") {
    $tl = date('Y-m-d', strtotime("-15 years"));
} elseif ($stat == "ubah") {
    $hdata = querydb("SELECT id_seleksi, seleksi, tahun, catatan FROM ahp_seleksi WHERE id_seleksi='$id'");
    $data = mysqli_fetch_array($hdata);
}

if (@$_POST['stat_simpan']) {

    $id = antiinjec(@$_POST['id']);
    $tahun = antiinjec(@$_POST['tahun']);
    $seleksi = antiinjec(@$_POST['seleksi']);
    $catatan = antiinjec(@$_POST['catatan']);

    if ($stat == "tambah") {
        $d_cek = mysqli_fetch_array(querydb("SELECT count(*) FROM ahp_seleksi WHERE seleksi='$seleksi' AND tahun='$tahun'"));
        if ($d_cek[0] == 0) {
            querydb("INSERT INTO ahp_seleksi(seleksi, catatan, tahun)
					 VALUES ('$seleksi', '$catatan', '$tahun')");

            ?>
            <script language="JavaScript">document.location = '?h=seleksi&con=1'</script>
            <?php
        } else {
            //echo "<div class='warning'>Periode [$seleksi] sudah ada. </div>";

            ?>
            <script language="JavaScript">alert('Periode [<?php echo $tahun . "-" . $seleksi; ?>] sudah ada.'); history.go(-1);</script>
            <?php
        }
    } elseif ($stat == "ubah") {
        $d_cek = mysqli_fetch_array(querydb("SELECT count(*) FROM ahp_seleksi WHERE seleksi='$seleksi' AND tahun='$tahun' AND id_seleksi<>'$id'"));
        echo $seleksi;
        if ($d_cek[0] == 0) {
            querydb("UPDATE ahp_seleksi SET seleksi='$seleksi', catatan='$catatan', tahun='$tahun' WHERE id_seleksi='$id'");

            ?>
            <script language="JavaScript">document.location = '?h=seleksi&con=2'</script>
            <?php
        } else {
            //echo "<div class='warning'>Periode [$seleksi] sudah ada. </div>";

            ?>
            <script language="JavaScript">alert('Periode [<?php echo $tahun . "-" . $seleksi; ?>] sudah ada.'); history.go(-1);</script>
            <?php
        }
    }
} elseif ($stat == "hapus" && $id != "") {
    querydb("DELETE FROM ahp_seleksi WHERE id_seleksi='$id'");

    ?>
    <script language="JavaScript">document.location = '?h=seleksi&con=3'</script>
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

            ?> Seleksi
        </h4>
        <form action="?h=seleksi-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="stat_simpan" value="set">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Seleksi</label>
                <div class="col-sm-10 validate">
                    <input type="text" class="form-control" data-validate-length-range="5" data-validate-words="1" name="seleksi" value="<?php echo!empty($data['seleksi']) ? $data['seleksi'] : null; ?>" required data-toggle="tooltip" data-original-title="Isi dengan nama seleksi (untuk seleksi)"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tahun Seleksi</label>
                <div class="col-sm-10 validate">
                    <input type="number" maxlength="4" name="tahun" class="form-control" required data-validate-minmax="2015,9999" value="<?php echo!empty($data['tahun']) ? $data['tahun'] : null ?>" data-toggle="tooltip" data-original-title="Isi dengan tahun seleksi (Misal = 2015)"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-10 validate">
                    <textarea class="form-control" name="catatan" rows="5"><?php echo!empty($data['catatan']) ? $data['catatan'] : null ?></textarea>
                </div>
            </div>
            <button id='send' type='submit' name="btn_simpan" class="btn btn-primary btn-sm btn-round">Simpan Data</button>
            <button id='send' type='button' class="btn btn-danger btn-sm btn-round" onclick="window.history.back();">Batal</button>
        </form>
    </div>
</div>

<!--<section class='form'>
    <form action="?h=seleksi-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="stat_simpan" value="set">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <fieldset>
            <div class="item">
                <label>
                    <span>Nama Seleksi</span>
                    <input type="text" data-validate-length-range="5" data-validate-words="1" name="seleksi" value="<?php echo!empty($data['seleksi']) ? $data['seleksi'] : null; ?>" placeholder="" required/>
                </label>
                <div class='tooltip help'>
                    <span>?</span>
                    <div class='content'>
                        <b></b>
                        <p>Isi dengan nama seleksi (untuk seleksi)</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <label>
                    <span>Tahun Seleksi</span>
                    <input type="number" maxlength="4" name="tahun" data-validate-minmax="2015,9999" value="<?php echo!empty($data['tahun']) ? $data['tahun'] : null ?>" required style="width:60px;"/>
                </label>
                <div class='tooltip help'>
                    <span>?</span>
                    <div class='content'>
                        <b></b>
                        <p>Isi dengan tahun seleksi (Misal = 2015).</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <label>
                    <span>Catatan</span>
                    <textarea required name="catatan" style="width:200px; height:50px;"><?php echo!empty($data['catatan']) ? $data['catatan'] : null ?></textarea>
                </label>
            </div>
        </fieldset>

    </form>
</section>-->
