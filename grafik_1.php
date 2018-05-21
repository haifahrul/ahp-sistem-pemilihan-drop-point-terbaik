<?php 
include "./config/koneksi.php";
include "./config/library.php";
opendb();
$seleksi=(int)@$_SESSION['seleksi'];
$kriteria=(int)@$_POST['kriteria'];
$urut=@$_POST['urut'];
if($urut=="") { $urut="DESC"; }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>		
		<title>Grafik Garis</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="css/elegant-press.css" type="text/css" />
        <script src="scripts/elegant-press.js" type="text/javascript"></script>
		<script src="./js/jquery-1.10.2.min.js"></script>
		<script src="./js/knockout-3.0.0.js"></script>
		<script src="./js/globalize.min.js"></script>
		<script src="./js/dx.chartjs.js"></script>
    <style>
		body { background:none; }
		table { border:none; }
		table tr td { border:none; }
	</style>                     
	</head>
	<body>
    <script>
	$(function ()  
				{
   var dataSource = [
    <?php
	if($kriteria==0) {
		$krit="";
	} else {
		$krit="AND b.id_kriteria_seleksi='".$kriteria."'";
	}
	
	$queryX="SELECT a.id_alternatif, a.nama_alternatif, b.nilai 
			 FROM ahp_alternatif as a, ahp_nilai_hasil as b
			 WHERE a.id_alternatif=b.id_alternatif AND a.id_seleksi='$seleksi' ORDER BY b.nilai $urut";
	$hqueryX=querydb($queryX);
	while ($dquX=mysqli_fetch_array($hqueryX)){
		$no=$no+1;
    ?>
    { country: "<?php echo $dquX['nama_alternatif'];?>", 
		<?php
		$qk2="SELECT b.id_kriteria_seleksi, a.id_kriteria, a.kriteria 
			  FROM ahp_kriteria as a, ahp_kriteria_seleksi as b
			  WHERE a.id_kriteria=b.id_kriteria AND b.id_seleksi=$seleksi $krit 
			  ORDER BY a.id_kriteria ASC";
		$hk2=querydb($qk2);
		while($dk2=mysqli_fetch_array($hk2)){
			//Ambil Nilai yang sudah disimpan (lalu tampilkan)
			$qn="SELECT nilai FROM ahp_nilai_eigen WHERE tipe=1 AND id_node_0='$dk2[id_kriteria_seleksi]' AND id_node='$dquX[id_alternatif]'";
			$hn=querydb($qn);
			$dn=mysqli_fetch_array($hn);
			?>
			dua<?php echo"$dk2[id_kriteria_seleksi]"; ?>: <?php echo number_format($dn['nilai'],2,'.','.'); ?>, 
		<?php } ?>
	},
	<?php } ?>
    /*
    { country: "China", SKHUN: 74.2, BP: 308.6, BTT: 35.1, },
    { country: "Russia", SKHUN: 40, BP: 128.5, BTT: 361.8, },
    { country: "Japan", SKHUN: 22.6, BP: 241.5, BTT: 64.9, },
    { country: "India", SKHUN: 19, BP: 119.3, BTT: 28.9, },
    { country: "Germany", SKHUN: 6.1, BP: 123.6, BTT: 77.3, },
	*/
];

$("#chartContainer").dxChart({
	equalBarWidth: false,
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "country",
        type: "bar"
    },
    series: [
		<?php
		$qk2="SELECT b.id_kriteria_seleksi, a.id_kriteria, a.kriteria 
			  FROM ahp_kriteria as a, ahp_kriteria_seleksi as b
			  WHERE a.id_kriteria=b.id_kriteria AND b.id_seleksi=$seleksi $krit 
			  ORDER BY a.id_kriteria ASC";
		$hk2=querydb($qk2);
		while($dk2=mysqli_fetch_array($hk2)){
		?>
        { valueField: "dua<?php echo $dk2['id_kriteria_seleksi']; ?>", name: "<?php echo $dk2['kriteria']; ?>" },
        <?php } ?>
		/*
		{ valueField: "oil", name: "Oil" },
        { valueField: "gas", name: "Natural gas" },
        { valueField: "coal", name: "Coal" },
        { valueField: "nuclear", name: "Nuclear" }
		*/
    ],
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center",
        itemTextPosition: "bottom"
    },
    title: "",
    tooltip: {
        enabled: true,
        customizeText: function () {
            return this.valueText;
        }
    }
});
}

			);
		</script>
        <div class="cek">
        <form id="form1" name="form1" method="post" action="grafik_1.php">
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="6%">Kriteria</td>
            <td width="1%">:</td>
            <td width="84%">
            <select name="kriteria" style="height:25px;">
                <option value="" <?php if($kriteria=="") { echo"selected"; } ?>>- Semua Kriteria -</option>
                <?php
                      opendb();
                      $query="SELECT b.id_kriteria_seleksi, a.id_kriteria, a.kriteria FROM ahp_kriteria as a, ahp_kriteria_seleksi as b
					  		  WHERE a.id_kriteria=b.id_kriteria AND b.id_seleksi=$seleksi ORDER BY id_kriteria ASC";
                      $hquery=querydb($query);
                      closedb();
                      while ($dqu=mysqli_fetch_array($hquery)) { ?>
                <option value="<?php echo"$dqu[id_kriteria_seleksi]";?>" <?php if($kriteria==$dqu['id_kriteria_seleksi']) { echo"selected"; } ?>><?php echo"$dqu[kriteria]";?></option>
                <?php } ?>
            </select>
            <select name="urut" style="height:25px;">
              		<option value="DESC" <?php if($urut=="DESC") { echo"selected"; } ?>>DESC</option>
              		<option value="ASC" <?php if($urut=="ASC") { echo"selected"; } ?>>ASC</option>
            </select>
            </td>
            <td width="9%"><input type="submit" name="b_lihat"  value="Perbarui Grafik" class="tombol"/></td>
          </tr>
        </table>
        </form>
        </div>
 		<div style="width:100%; height:5px; margin-bottom:20px; border-bottom:2px solid #09F;"></div>
		<div class="content">
			<div class="pane">
				<div class="long-title"><h3></h3></div>
				<div id="chartContainer" class="case-container" style="width: 100%; height: 350px;"></div>
			</div>
		</div>
        

	</body>
</html>