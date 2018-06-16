<?php
include "config/library.php";
include "config/koneksi.php";
opendb();
$usernama = antiinjec(@$_SESSION['sesNamaPengguna']);
$usertipe = antiinjec(@$_SESSION['sesTipePengguna']);
if ($usernama == "") {
    header("location:login.php");
}
$h = antiinjec(@$_GET['h']);

$seleksi = antiinjec(@$_GET['seleksi']);

$getNamaSeleksi = mysqli_fetch_row(querydb("SELECT tahun, seleksi FROM ahp_seleksi WHERE id_seleksi='$seleksi'"));
$namaSeleksi = $getNamaSeleksi[0] . ' - ' . $getNamaSeleksi[1];

//HITUNG HASIL AKHIR
$tampil = "SELECT id_alternatif, nama_alternatif FROM ahp_alternatif WHERE id_seleksi='$seleksi' ORDER BY id_alternatif ASC";
$h_tampil = querydb($tampil);
$no = 1;
while ($r = mysqli_fetch_array($h_tampil)) {
    $nilai_akhir = 0;
    $h_kriteria = querydb("SELECT a.id_kriteria_seleksi, nilai FROM ahp_kriteria_seleksi as a, ahp_kriteria as b, ahp_nilai_eigen as c WHERE a.id_kriteria=b.id_kriteria AND c.id_node_0=0 AND c.id_node=a.id_kriteria_seleksi AND a.id_seleksi='$seleksi' ORDER BY a.id_kriteria_seleksi ASC");
    while ($d_kriteria = mysqli_fetch_array($h_kriteria)) {
        //Ambil Nilai Hasil Alternatif
        $h_nilai = querydb("SELECT nilai FROM ahp_nilai_eigen WHERE id_node_0='$d_kriteria[id_kriteria_seleksi]' AND id_node='$r[id_alternatif]'");
        $d_nilai = mysqli_fetch_array($h_nilai);

        $nilai_akhir = number_format($nilai_akhir + ($d_nilai['nilai'] * $d_kriteria['nilai']), 2);
    }

    //Simpan Hasil
    $jml_baris = mysqli_num_rows(querydb("SELECT id_alternatif FROM ahp_nilai_hasil WHERE id_alternatif='$r[id_alternatif]'"));
    if ($jml_baris == 0) {
        //Simpan
        querydb("INSERT INTO ahp_nilai_hasil (id_seleksi, id_alternatif, nilai) VALUES ('$seleksi', '$r[id_alternatif]', '$nilai_akhir')");
    } else {
        querydb("UPDATE ahp_nilai_hasil SET nilai='$nilai_akhir' WHERE id_seleksi='$seleksi' AND id_alternatif='$r[id_alternatif]'");
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

// GRAFIK

$dataQuery = "SELECT * FROM ahp_alternatif WHERE id_seleksi='$seleksi'";
$dataQueryDb = querydb($dataQuery);
$kriteriaQuery = mysqli_fetch_all(querydb("SELECT b.kriteria FROM ahp_kriteria_seleksi as a 
LEFT JOIN ahp_kriteria as b 
ON a.id_seleksi=a.id_seleksi WHERE a.id_seleksi='$seleksi'
GROUP BY b.id_kriteria"));

$data = [];
$label = [];
$xKey = 0;
$yKeys = [];
$kriteriaColors = [];
$lineColors = ['#00cccc', '#f08080', '#3990d2', '#d7b8ff', '#00e595', '#a1f65f', '#41e3e7', '#ff7400', '#fff68f', '#aaaaaa'];

foreach ($dataQueryDb as $key => $value) {
    $getNliaiEigen = querydb("SELECT a.id_node_0, a.nilai, d.kriteria FROM ahp_nilai_eigen a
LEFT JOIN ahp_kriteria_seleksi c ON c.id_kriteria_seleksi = a.id_node_0
LEFT JOIN ahp_kriteria d ON d.id_kriteria = c.id_kriteria
WHERE tipe=1 AND a.id_node='$value[id_alternatif]' ORDER BY a.id_nilai_eigen ASC");

    if ($key != 0) {
        $yKeys[] = $key;
    }

    $i = 1;
    $data[$key][] = $value['catatan'];
    foreach ($getNliaiEigen as $value2) {
        $data[$key][$i] = $value2['nilai'];
        $label[$key][] = $value2['kriteria'];
        $i++;
    };
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Sistem Pengambilan Keputusan Drop Point Terbaik</title>
        <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
          <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Gradient Able Bootstrap admin template made using Bootstrap 4. The starter version of Gradient Able is completely free for personal project." />
        <meta name="keywords" content="free dashboard template, free admin, free bootstrap template, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
        <meta name="author" content="codedthemes">
        <!-- Favicon icon -->
        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
        <!-- themify-icons line icon -->
        <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
        <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
        <!-- ico font -->
        <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" href="css/morris.css" type="text/css"/>
        <style>
            .table td, .table th, .table tr {
                padding: 5px;
                word-wrap: break-word;
            }

            .card .card-header {
                padding-bottom: 0px;
            }
        </style>
    </head>
    <body>
        <div class="card" >
            <div class="card-header"><h4>4-3. Hasil Seleksi Metode AHP</h4></div>
            <div class="card-header"><h5>Tahun <?php echo $namaSeleksi ?></h5></div>

            <?php if (!empty($seleksi)) { ?>
                <div class="card-body csstable">
                    <!--|&nbsp;-->
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
                        <div class="table-responsive">
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
                                        <td style="font-weight:bold; color:#039;"><?php echo number_format($d_kriteria['nilai'], 2, ',', '.'); ?></td>
                                    <?php } ?>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                $tampil = "SELECT a.id_alternatif, a.nama_alternatif, b.nilai, b.rank
              FROM ahp_alternatif as a, ahp_nilai_hasil as b
              WHERE a.id_alternatif=b.id_alternatif AND a.id_seleksi='$seleksi'
			  ORDER BY b.rank ASC";
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
                                            <td><?php echo number_format($d_nilai['nilai'], 2, ',', '.'); ?></td>
                                            <?php
                                        }

                                        ?>
                                        <td style="font-weight:bold; color:#F30;"><?php echo number_format($r['nilai'], 2, ',', '.'); ?></td>
                                        <td style="font-weight:bold; color:#360; text-align:center;"><?php echo $r['rank']; ?></td>
                                    </tr>
                                    <?php
                                    $no++;
                                }

                                ?>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <?php if (!empty($seleksi)) { ?>
            <div class="card" style="page-break-before: always">
                <div class="card-header"><h5>Grafik Nilai Eigen Kriteria dan Hasil</h5></div>
                <div class="chart" id="line-chart"></div>
                <!--                <div class="card-body">
                                    <iframe style="width: 100%; height: 600px;" src="cetak_ahp_hasil_grafik.php?seleksi=<?php echo $seleksi ?>" frameborder="0" scrolling="auto"></iframe>
                                </div>-->
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <th>No</th>
                            <th>Kriteria</th>
                            <th>Warna</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($kriteriaQuery as $key => $val) { ?>
                                    <tr>
                                        <td><?php echo $no ?></td>
                                        <td><?php echo $kriteriaColors[$key][] = $val[0]; ?></td>
                                        <td><div style="border: 2px solid <?php echo $kriteriaColors[$key][] = $lineColors[$key]; ?>"></div></td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php } ?>

    </body>
    <script src="./js/jquery-1.10.2.min.js"></script>
    <script src="./js/raphael-min.js"></script>
    <script src="./js/morris.min.js"></script>
    <script>
        // LINE CHART
        new Morris.Line({
            element: 'line-chart',
            data: <?php echo json_encode($data) ?>,
            xkey: <?php echo $xKey ?>, // value x
            ykeys: <?php echo json_encode($yKeys) ?>, // value y
            labels: <?php echo json_encode($label[0]) ?>, // Label in popup info
            lineColors: <?php echo json_encode($lineColors) ?>,
            hideHover: true,
            parseTime: false,
            resize: true,
            redraw: true
        });

        window.print();
        window.close();
    </script>
</html>