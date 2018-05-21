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

    $id = $usernama;
    $password_lama = md5($_POST['password_lama']);
    $password = md5($_POST['password']);
    $password2 = md5($_POST['password2']);

    if ($stat == "ubah") {
        $hquery = querydb("SELECT password FROM ahp_pengguna WHERE username='$usernama'");
        $userdata = mysqli_fetch_array($hquery);

        if ($password_lama <> $userdata['password']) {

            ?>
            <script language="JavaScript">alert('Password lama salah.');
                document.location = '?h=password'</script>
            <?php
        } else {
            if (($password <> $password2) or ( $password == "") or ( $password2 == "")) {

                ?>
                <script language="JavaScript">alert('Pasword baru dan password baru ulangi tidak sama (tidak boleh kosong)');
                    document.location = '?h=password'</script>
                <?php
            } else {
                opendb();
                $query = "UPDATE ahp_pengguna SET password='$password' WHERE username='$usernama'";
                querydb($query);
                closedb();

                ?>
                <script language="JavaScript">alert('Perubahan berhasil disimpan. Sistem logout.');
                    document.location = 'logout.php'</script>
                <?php
            }
        }
    }
}

?>

<div class="card form">
    <div class="card-block">
        <h4 class="sub-title">
            Ubah Password
        </h4>
        <section class='form'>
            <form action="?h=password&stat=ubah" method="post" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="stat_simpan" value="set">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password Lama</label>
                    <div class="col-sm-10 validate">
                        <input class="form-control" type="password" name="password_lama" value="" <?php
                        if ($stat == "ubah") {
                            echo "placeholder='Tulis ulang'";
                        }

                        ?> data-validate-length-range="6,10" required='required' data-toggle="tooltip" data-original-title="Minimum 6 karakter dan maksimum 10 karakter (Password lama adalah password yang Anda gunakan sekarang).">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password Baru</label>
                    <div class="col-sm-10 validate">
                        <input class="form-control" type="password" name="password" value="" <?php
                        if ($stat == "ubah") {
                            echo "placeholder='Tulis ulang'";
                        }

                        ?> data-validate-length-range="6,10" required='required' data-toggle="tooltip" data-original-title="Minimum 6 karakter dan maksimum 10 karakter.">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ulangi Password</label>
                    <div class="col-sm-10 validate">
                        <input class="form-control" type="password" name="password2" value="" <?php
                        if ($stat == "ubah") {
                            echo "placeholder='Tulis ulang'";
                        }

                        ?> data-validate-linked='password' required='required'>
                    </div>
                </div>

                <button id='send' type='submit' name="btn_simpan" class="btn btn-primary btn-sm btn-round">Simpan Data</button>
                <button id='send' type='button' class="btn btn-danger btn-sm btn-round" onclick="window.history.back();">Batal</button>
            </form>
        </section>
    </div>
</div>
