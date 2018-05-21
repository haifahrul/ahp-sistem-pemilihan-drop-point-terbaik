<?php
$seleksi = antiinjec(@$_POST['seleksi']);
if ($seleksi == "") {
    $d_seleksi = mysqli_fetch_array(querydb("SELECT id_seleksi FROM ahp_seleksi ORDER BY tahun DESC, id_seleksi DESC LIMIT 0, 1"));
    $seleksi = $d_seleksi['id_seleksi'];
}

$_SESSION['seleksi'] = $seleksi;

//HITUNG HASIL AKHIR
$tampil = "SELECT id_alternatif, nama_alternatif FROM ahp_alternatif WHERE id_seleksi='$seleksi' ORDER BY id_alternatif ASC";
$h_tampil = querydb($tampil);
$no = 1;
while ($r = mysqli_fetch_array($h_tampil)) {
    $nilai_akhir = 0;
    $h_kriteria = querydb("SELECT a.id_kriteria_seleksi, nilai FROM ahp_kriteria_seleksi as a, ahp_kriteria as b, ahp_nilai_eigen as c
							 WHERE a.id_kriteria=b.id_kriteria AND c.id_node_0=0 AND c.id_node=a.id_kriteria_seleksi
  								AND a.id_seleksi='$seleksi' ORDER BY a.id_kriteria_seleksi ASC");
    while ($d_kriteria = mysqli_fetch_array($h_kriteria)) {
        //Ambil Nilai Hasil Alternatif
        $h_nilai = querydb("SELECT nilai FROM ahp_nilai_eigen WHERE id_node_0='$d_kriteria[id_kriteria_seleksi]' AND id_node='$r[id_alternatif]'");
        $d_nilai = mysqli_fetch_array($h_nilai);

        $nilai_akhir = $nilai_akhir + ($d_nilai['nilai'] * $d_kriteria['nilai']);
    }
    //Simpan Hasil
    $jml_baris = mysqli_num_rows(querydb("SELECT id_alternatif FROM ahp_nilai_hasil WHERE id_alternatif='$r[id_alternatif]'"));
    if ($jml_baris == 0) {
        //Simpan
        querydb("INSERT INTO ahp_nilai_hasil (id_alternatif, nilai) VALUES ('$r[id_alternatif]', '$nilai_akhir')");
    } else {
        querydb("UPDATE ahp_nilai_hasil SET nilai='$nilai_akhir' WHERE id_alternatif='$r[id_alternatif]'");
    }
    $no++;
}

//Urutkan (Beri ranking)
$rank = 1;
$hasil_rank = querydb("SELECT id_alternatif, nilai FROM ahp_nilai_hasil WHERE id_alternatif IN (SELECT id_alternatif FROM ahp_alternatif WHERE id_seleksi='$seleksi') ORDER BY nilai DESC");
while ($d_hasil_rank = mysqli_fetch_array($hasil_rank)) {
    querydb("UPDATE ahp_nilai_hasil SET rank='$rank' WHERE id_alternatif='$d_hasil_rank[id_alternatif]'");
    $rank++;
}

?>


<div class="card" >
    <div class="card-header"><h5>4-3. Hasil Seleksi Metode AHP</h5></div>
    <form class="card-body" method="post" action="?h=hasil" enctype="multipart/form-data">
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="4">
            <tr>
                <td width="13%" style="text-align:left;">Pilih Seleksi :</td>
                <td width="87%" style="text-align:left;">
                    <select name="seleksi" onchange="this.form.submit()" style="font-size:16px; color:#333; padding-top:2px; width:auto;">
                        <?php
                        $q_seleksi = "SELECT id_seleksi, seleksi, tahun FROM ahp_seleksi ORDER BY tahun DESC, id_seleksi DESC";
                        $h_node = querydb($q_seleksi);
                        while ($dseleksi = mysqli_fetch_array($h_node)) {

                            ?>
                            <option value="<?php echo $dseleksi['id_seleksi']; ?>" <?php
                            if ($dseleksi['id_seleksi'] == $seleksi) {
                                echo "selected";
                            }

                            ?>><?php echo $dseleksi['tahun'] . " - " . $dseleksi['seleksi']; ?></option>
                                <?php } ?>
                    </select>
                </td>
            </tr>
        </table>
    </form>

    <div class="card-body csstable">
        |&nbsp;
        <?php
        if ($seleksi != "") {
            $j = 1;
            $h_kriteria = querydb("SELECT a.id_kriteria_seleksi, b.kriteria, nilai FROM ahp_kriteria_seleksi as a, ahp_kriteria as b, ahp_nilai_eigen as c
						 WHERE a.id_kriteria=b.id_kriteria AND c.id_node_0=0 AND c.id_node=a.id_kriteria_seleksi
  							AND a.id_seleksi='$seleksi' ORDER BY a.id_kriteria_seleksi ASC");
            while ($d_kriteria = mysqli_fetch_array($h_kriteria)) {
                echo "<b>" . sprintf("K%02d", $j) . "</b> = " . $d_kriteria['kriteria'] . " | ";
                $j++;
            }

            ?>
            <table class="table" width="100%" border="0" cellspacing="0" cellpadding="4">
                <?php
                $h_kriteria = querydb("SELECT a.id_kriteria_seleksi, nilai FROM ahp_kriteria_seleksi as a, ahp_kriteria as b, ahp_nilai_eigen as c
						 WHERE a.id_kriteria=b.id_kriteria AND c.id_node_0=0 AND c.id_node=a.id_kriteria_seleksi
  							AND a.id_seleksi='$seleksi' ORDER BY a.id_kriteria_seleksi ASC");
                $jml_kriteria = mysqli_num_rows($h_kriteria);

                ?>
                <tr>
                    <td width='5%'>No.</td>
                    <td><?php echo $kasus_objek; ?></td>
                    <?php
                    for ($i = 1; $i <= $jml_kriteria; $i++) {

                        ?>
                        <td><?php echo sprintf("K%02d", $i); ?></td>
                    <?php } ?>
                    <td style="font-weight:bold; color:#F60;">Nilai</td>
                    <td style="font-weight:bold; color:#390; text-align:center;">Rank</td>
                </tr>
                <tr>
                    <td style="font-weight:bold; color:#039;">&nbsp;</td>
                    <td style="font-weight:bold; color:#039;">Eigen Kriteria</td>
                    <?php
                    while ($d_kriteria = mysqli_fetch_array($h_kriteria)) {

                        ?>
                        <td style="font-weight:bold; color:#039;"><?php echo number_format($d_kriteria['nilai'], 3, ',', '.'); ?></td>
                    <?php } ?>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $tampil = "SELECT a.id_alternatif, a.nama_alternatif, b.nilai, b.rank 
              FROM ahp_alternatif as a, ahp_nilai_hasil as b
              WHERE a.id_alternatif=b.id_alternatif AND a.id_seleksi='$seleksi' 
			  ORDER BY a.id_alternatif ASC";
                $h_tampil = querydb($tampil);
                $no = 1;
                while ($r = mysqli_fetch_array($h_tampil)) {
                    $n_alternatif = sprintf("A%03d", $no);

                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $n_alternatif . ' - ' . $r['nama_alternatif']; ?></td>
                        <?php
                        $nilai_akhir = 0;
                        $h_kriteria = querydb("SELECT a.id_kriteria_seleksi, c.nilai FROM ahp_kriteria_seleksi as a, ahp_kriteria as b, ahp_nilai_eigen as c
							   WHERE a.id_kriteria=b.id_kriteria AND c.id_node_0=0 AND c.id_node=a.id_kriteria_seleksi
								   AND a.id_seleksi='$seleksi' ORDER BY a.id_kriteria_seleksi ASC");
                        while ($d_kriteria = mysqli_fetch_array($h_kriteria)) {
                            //Ambil Nilai Hasil Alternatif
                            $h_nilai = querydb("SELECT nilai FROM ahp_nilai_eigen WHERE id_node_0='$d_kriteria[id_kriteria_seleksi]' AND id_node='$r[id_alternatif]'");
                            $d_nilai = mysqli_fetch_array($h_nilai);

                            ?>
                            <td><?php echo number_format($d_nilai['nilai'], 3, ',', '.'); ?></td>
                            <?php
                        }

                        ?>
                        <td style="font-weight:bold; color:#F30;"><?php echo number_format($r['nilai'], 3, ',', '.'); ?></td>
                        <td style="font-weight:bold; color:#360; text-align:center;"><?php echo $r['rank']; ?></td>
                    </tr>
                    <?php
                    $no++;
                }

                ?>
            </table>
        <?php } ?>
    </div>
</div>

<div class="card"><?php include "grafik_1_container.php"; ?></div>
