<?php
include "config/library.php";
include "config/koneksi.php";
opendb();
$usernama=antiinjec(@$_SESSION['sesNamaPengguna']);
$usertipe=antiinjec(@$_SESSION['sesTipePengguna']);
if($usernama=="") {
	header("location:login.php");
}
$h=antiinjec(@$_GET['h']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistem Pemilihan Drop Point Terbaik</title>
<link href="css/font.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validator.css" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
	<div id="paling_atas">Sistem Pengambilan Keputusan Drop Point Terbaik</div>
	<div id="atas">
      <div class="boundary">
        <div id='cssmenu'>
        <ul>
           <li class="<?php if($h=="") { echo "active"; } ?>"><a href='?'><span>Beranda</span></a></li>
           <li class='<?php if($h=="seleksi" || $h=="seleksi-input") { echo "active"; } ?>'><a href='?h=seleksi'><span>Area Seleksi</span></a></li>
           <li class="<?php if($h=="kriteria" || $h=="kriteria-input" || $h=="kriteria-seleksi" || $h=="kriteria-seleksi-input") { echo "active"; } ?>  has-sub"><a href='?h=kriteria'><span>Data Kriteria</span><div style="position:absolute; top:13px; padding-left:14px; font-size:13px; text-transform:none;">Kriteria Seleksi</div></a>
           	  <ul>
                 <li><a href='?h=kriteria'><span>1. Data Kriteria</span></a></li>
                 <li><a href='?h=kriteria-seleksi'><span>2. Kriteria Seleksi</span></a></li>
           	  </ul>
           </li>
           <li class="<?php if($h=="alternatif" || $h=="alternatif-input") { echo "active"; } ?>"><a href='?h=alternatif'><span>Data <?php echo $kasus_objek; ?></span><div style="position:absolute; top:13px; padding-left:14px; font-size:13px; text-transform:none;">KANDIDAT</div></a></li>

           <li class='<?php if($h=="nilai-alternatif" || $h=="nilai-kriteria" || $h=="hasil") { echo "active"; } ?> has-sub'><a href='#'><span>Seleksi AHP</span></a>
              <ul>
                 <li><a href='?h=nilai-kriteria'><span>1. Nilai Kriteria</span></a></li>
                 <li><a href='?h=nilai-alternatif'><span>2. Nilai <?php echo $kasus_objek; ?></span></a></li>
                 <li><a href='?h=hasil'><span>3. Hasil Seleksi</span></a></li>
              </ul>
           </li>
           <li class='<?php if($h=="password" || $h=="pengguna" || $h=="pengguna-input") { echo "active"; } ?> has-sub'><a href='#'><span>User <?php echo $usernama; ?></span></a>
              <ul>
                 <?php if($usertipe==2) { ?>
                 <li><a href='?h=pengguna'><span>Data Pengguna</span></a></li>
                 <?php } ?>
                 <li><a href='?h=password'><span>Ubah Password</span></a></li>
                 <li><a href='logout.php'><span>Logout</span></a></li>
              </ul>
           </li>
        </ul>
        </div>
      </div>
    </div>

 	<div id="content">
	  <?php
		switch ($h) {
		case "alternatif":
			include "list_alternatif.php";
			break;
		case "alternatif-input":
			include "input_alternatif.php";
			break;
		case "kriteria":
			include "list_kriteria.php";
			break;
		case "kriteria-input":
			include "input_kriteria.php";
			break;
		case "kriteria-seleksi":
			include "list_kriteria_seleksi.php";
			break;
		case "kriteria-seleksi-input":
			include "input_kriteria_seleksi.php";
			break;
		case "seleksi":
			include "list_seleksi.php";
			break;
		case "seleksi-input":
			include "input_seleksi.php";
			break;
		case "pengguna":
			if($usertipe==2) {
				include "list_pengguna.php";
			} else { include "home.php"; }
			break;
		case "pengguna-input":
			if($usertipe==2) {
				include "input_pengguna.php";
			} else { include "home.php"; }
			break;
		case "password":
			include "input_password.php";
			break;
		case "nilai-kriteria":
			include "ahp_perbandingan_kriteria.php";
			break;
		case "nilai-alternatif":
			include "ahp_perbandingan_alternatif.php";
			break;
		case "hasil":
			include "ahp_hasil.php";
			break;
		default:
			include "home.php";
	  }
	  ?>
    </div>

    <!--
    <div id="content">
    	<a href="" class="tombol-large w_hijau hvr-fade">Tombol</a>
    	<a href="" class="tombol-medium w_biru hvr-fade">Tombol</a>
    	<a href="" class="tombol-mini w_biru hvr-fade">Tombol</a>
    </div>
    -->

	<script src="js/jquery.min.js"></script> <!-- Jquery 1.9.1 -->
    <script src="js/multifield.js"></script>
    <script src="js/validator.js"></script>
	<script>
		// initialize the validator function
		validator.message['date'] = 'not a real date';

		// validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
		$('form')
			.on('blur', 'input[required], input.optional, select.required', validator.checkField)
			.on('change', 'select.required', validator.checkField)
			.on('keypress', 'input[required][pattern]', validator.keypress);

		$('.multi.required')
			.on('keyup blur', 'input', function(){
				validator.checkField.apply( $(this).siblings().last()[0] );
			});

		// bind the validation to the form submit event
		//$('#send').click('submit');//.prop('disabled', true);

		$('form').submit(function(e){
			e.preventDefault();
			var submit = true;
			// evaluate the form using generic validaing
			if( !validator.checkAll( $(this) ) ){
				submit = false;
			}

			if( submit )
				this.submit();
			return false;
		});

		/* FOR DEMO ONLY
		$('#vfields').change(function(){
			$('form').toggleClass('mode2');
		}).prop('checked',false);

		$('#alerts').change(function(){
			validator.defaults.alerts = (this.checked) ? false : true;
			if( this.checked )
				$('form .alert').remove();
		}).prop('checked',false);
		*/
	</script>

</body>
</html>
