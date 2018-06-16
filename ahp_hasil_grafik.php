<?php
include "./config/koneksi.php";
include "./config/library.php";
opendb();

$seleksi = (int) @$_GET['seleksi'];

$dataQuery = "SELECT * FROM ahp_alternatif WHERE id_seleksi='$seleksi'";
$dataQueryDb = querydb($dataQuery);

$data = [];
$label = [];
$xKey = 0;
$yKeys = [];

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
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Grafik Garis</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <link rel="stylesheet" type="text/css" href="assets/css/style.css">
                    <link rel="stylesheet" href="css/morris.css" type="text/css"/>
                    <script src="./js/jquery-1.10.2.min.js"></script>
                    <script src="./js/raphael-min.js"></script>
                    <script src="./js/morris.min.js"></script>
                    </head>
                    <body>
                        <div class="chart" id="line-chart"></div>
                    </body>
                    <script>
                        // LINE CHART
                        new Morris.Line({
                            element: 'line-chart',
                            data: <?php echo json_encode($data) ?>,
                            xkey: <?php echo $xKey ?>, // value x
                            ykeys: <?php echo json_encode($yKeys) ?>, // value y
                            labels: <?php echo json_encode($label[0]) ?>, // Label in popup info
                            lineColors: ['#00cccc', '#f08080', '#3990d2', '#d7b8ff', '#00e595', '#a1f65f', '#41e3e7', '#ff7400', '#fff68f', '#aaaaaa'],
                            hideHover: false,
                            parseTime: false,
                            resize: true,
                            redraw: true
                        });
                    </script>
                    </html>