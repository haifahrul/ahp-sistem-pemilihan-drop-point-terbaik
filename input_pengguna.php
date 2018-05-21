<?php
$stat = @$_GET['stat'];
$id = antiinjec(@$_GET['id']);
if ($stat == "tambah") {
    $tl = date('Y-m-d', strtotime("-15 years"));
} elseif ($stat == "ubah") {
    $hdata = querydb("SELECT id_pengguna, nama, no_telp, username, password, tipe FROM ahp_pengguna WHERE id_pengguna='$id'");
    $data = mysqli_fetch_array($hdata);
}
if (@$_POST['stat_simpan']) {

    $id = antiinjec(@$_POST['id']);
    $nama = antiinjec(@$_POST['nama']);
    $no_telp = antiinjec(@$_POST['no_telp']);
    $username = antiinjec(@$_POST['username']);
    $password = antiinjec(@$_POST['password']);
    $password = md5($password);
    $tipe = antiinjec(@$_POST['tipe']);

    if ($stat == "tambah") {
        $d_cek = mysqli_fetch_array(querydb("SELECT count(*) FROM ahp_pengguna WHERE username='$username'"));
        if ($d_cek[0] == 0) {
            querydb("INSERT INTO ahp_pengguna(nama, no_telp, username, password, tipe)
					 VALUES ('$nama', '$no_telp', '$username', '$password', '$tipe')");

            ?>
            <script language="JavaScript">document.location = '?h=pengguna&con=1'</script>
            <?php
        } else {
            //echo "<div class='warning'>Periode [$pengguna] sudah ada. </div>";

            ?>
            <script language="JavaScript">alert('Pengguna [<?php echo $username; ?>] sudah ada.'); history.go(-1);</script>
            <?php
        }
    } elseif ($stat == "ubah") {
        $d_cek = mysqli_fetch_array(querydb("SELECT count(*) FROM ahp_pengguna WHERE username='$username' AND id_pengguna<>'$id'"));
        echo $pengguna;
        if ($d_cek[0] == 0) {
            querydb("UPDATE ahp_pengguna SET nama='$nama', no_telp='$no_telp', username='$username', password='$password', tipe='$tipe' WHERE id_pengguna='$id'");

            ?>
            <script language="JavaScript">document.location = '?h=pengguna&con=2'</script>
            <?php
        } else {
            //echo "<div class='warning'>Periode [$pengguna] sudah ada. </div>";

            ?>
            <script language="JavaScript">alert('Periode [<?php echo $tahun . "-" . $pengguna; ?>] sudah ada.'); history.go(-1);</script>
            <?php
        }
    }
} elseif ($stat == "hapus" && $id != "") {
    querydb("DELETE FROM ahp_pengguna WHERE id_pengguna='$id'");

    ?>
    <script language="JavaScript">document.location = '?h=pengguna&con=3'</script>
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

            ?> Pengguna
        </h4>
        <form action="?h=pengguna-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="stat_simpan" value="set">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-10 validate">
                    <input class="form-control" data-validate-length-range="3" data-validate-words="1" name="nama" value="<?php echo!empty($data['nama']) ? $data['nama'] : null; ?>" placeholder="" required type="text" data-toggle="tooltip" data-original-title="Nama lengkap, tidak boleh disingkat"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nomor Telepon/HP</label>
                <div class="col-sm-10 validate">
                    <input class="form-control" type="tel" class="tel" name="no_telp" value="<?php echo!empty($data['no_telp']) ? $data['no_telp'] : null; ?>" data-validate-length-range="10,15" required data-toggle="tooltip" data-original-title="Nomor telepon minimal 10 digit, maksimal 15 digit."/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Hak Akses</label>
                <div class="col-sm-10 validate">
                    <select class="required form-control" name="tipe" style="width:210px;">
                        <option value=""></option>
                        <option value="1" <?php
                        if (!empty($data['tipe'])) {
                            if ($data['tipe'] == 1) {
                                echo "selected";
                            }
                        }

                        ?>>Normal</option>
                        <option value="2" <?php
                        if (!empty($data['tipe'])) {
                            if ($data['tipe'] == 2) {
                                echo "selected";
                            }
                        }

                        ?>>Administrator</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10 validate">
                    <input class="form-control" data-validate-length-range="5,15" <?php
                    if ($stat == "ubah") {
                        echo "readonly='readonly'";
                    }

                    ?> name="username" value="<?php echo!empty($data['username']) ? $data['username'] : null; ?>" placeholder="" required type="text" data-toggle="tooltip" data-original-title="Username 5 s/d 15 karakter."/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10 validate">
                    <input class="form-control" type="password" name="password" value="" <?php
                    if ($stat == "ubah") {
                        echo "placeholder='Tulis ulang'";
                    }

                    ?> data-validate-length-range="6,10" required data-toggle="tooltip" data-original-title="Minimum 6 karakter dan maksimum 10 karakter.">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Ulangi Password</label>
                <div class="col-sm-10 validate">
                    <input class="form-control" type="password" name="password2" value="" <?php
                    if ($stat == "ubah") {
                        echo "placeholder='Tulis ulang'";
                    }

                    ?> data-validate-linked='password' required>
                </div>
            </div>

            <button id='send' type='submit' name="btn_simpan" class="btn btn-primary btn-sm btn-round">Simpan Data</button>
            <button id='send' type='button' class="btn btn-danger btn-sm btn-round" onclick="window.history.back();">Batal</button>
        </form>
    </div>
</div>
