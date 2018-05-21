<?php
$stat	= @$_GET['stat'];
$id		= antiinjec(@$_GET['id']);
if($stat=="tambah") {
	$tl=date('Y-m-d', strtotime("-15 years"));
}elseif($stat=="ubah") {
	$hdata=querydb("SELECT id_pemain_posisi, posisi, singkatan FROM anp_pemain_posisi WHERE id_pemain_posisi='$id'");
	$data=mysqli_fetch_array($hdata);
}
if(@$_POST['stat_simpan']) {
	
	$id				= antiinjec(@$_POST['id']);
	$posisi			= antiinjec(@$_POST['posisi']);
	$singkatan		= antiinjec(@$_POST['singkatan']);
	
	if($stat=="tambah") {
		$d_cek=mysqli_fetch_array(querydb("SELECT count(*) FROM anp_pemain_posisi WHERE posisi='$posisi'"));
		if($d_cek[0]==0) {
			querydb("INSERT INTO anp_pemain_posisi(posisi, singkatan)
					 VALUES ('$posisi', '$singkatan')");
			?>
			<script language="JavaScript">document.location='?h=posisi&con=1'</script>
			<?php
		} else {
			//echo "<div class='warning'>Posisi [$posisi] sudah ada. </div>";
			?>
			<script language="JavaScript">alert('Posisi [<?php echo $posisi; ?>] sudah ada.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysqli_fetch_array(querydb("SELECT count(*) FROM anp_pemain_posisi WHERE posisi='$posisi' AND id_pemain_posisi<>'$id'"));
		echo $posisi;
		if($d_cek[0]==0) {
			querydb("UPDATE anp_pemain_posisi SET posisi='$posisi', singkatan='$singkatan' WHERE id_pemain_posisi='$id'");
			?>
			<script language="JavaScript">document.location='?h=posisi&con=2'</script>
			<?php
		} else {
			//echo "<div class='warning'>Posisi [$posisi] sudah ada. </div>";
			?>
			<script language="JavaScript">alert('Posisi [<?php echo $posisi; ?>] sudah ada.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM anp_pemain_posisi WHERE id_pemain_posisi='$id'");
	?>
	<script language="JavaScript">document.location='?h=posisi&con=3'</script>
	<?php
}
?>
<div class="judul"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Posisi Pemain</div>
<section class='form'>
  <form action="?h=posisi-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" novalidate>
  	  <input type="hidden" name="stat_simpan" value="set">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <fieldset>
          <div class="item">
              <label>
                  <span>Posisi Pemain</span>
                  <input data-validate-length-range="5" maxlength="30" data-validate-words="1" name="posisi" value="<?php echo $data['posisi']; ?>" placeholder="" required/>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Isi dengan nama posisi, semisal "Gelandang Tengah".</p>
                  </div>
              </div>
          </div>
          <div class="item">
              <label>
                  <span>Kode/Singkatan</span>
                  <input data-validate-length-range="2" maxlength="3" data-validate-words="1" name="singkatan" value="<?php echo $data['singkatan']; ?>" placeholder="" required style="width:50px;"/>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Isi dengan singkatan posisi, semisal "CM" untuk Gelandang Tengah.</p>
                  </div>
              </div>
          </div>
      </fieldset>
      <button id='send' type='submit' name="btn_simpan" class="tombol-large w_biru hvr-fade">Simpan Data</button>
      <button id='send' type='button' class="tombol-large w_orange hvr-fade" onclick="window.history.back();">Batal</button>
  </form>
</section>
