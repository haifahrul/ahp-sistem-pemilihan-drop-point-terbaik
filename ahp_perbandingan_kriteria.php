<?php
$seleksi = !empty(antiinjec(@$_POST['seleksi'])) ? antiinjec(@$_POST['seleksi']) : !empty($_POST['seleksi']) ? $_POST['seleksi'] : NULL;

if (!empty($seleksi)) {

    $d_seleksi = mysqli_fetch_array(querydb("SELECT id_seleksi FROM ahp_seleksi ORDER BY tahun DESC, id_seleksi DESC LIMIT 0, 1"));

    $q_kriteria1 = "SELECT a.id_kriteria_seleksi FROM ahp_kriteria_seleksi as a, ahp_kriteria as b WHERE a.id_kriteria=b.id_kriteria AND a.id_seleksi='$seleksi' ORDER BY a.id_kriteria_seleksi ASC";
    $h_kriteria1 = querydb($q_kriteria1);

    while ($d_kriteria1 = mysqli_fetch_array($h_kriteria1)) {
        $q_kriteria2 = "SELECT a.id_kriteria_seleksi FROM ahp_kriteria_seleksi as a, ahp_kriteria as b WHERE a.id_kriteria=b.id_kriteria AND a.id_seleksi='$seleksi' AND a.id_kriteria_seleksi<>'$d_kriteria1[id_kriteria_seleksi]' AND a.id_seleksi='$seleksi' ORDER BY a.id_kriteria_seleksi ASC";
        $h_kriteria2 = querydb($q_kriteria2);
        while ($d_kriteria2 = mysqli_fetch_array($h_kriteria2)) {

            $q_sql_cek = "SELECT count(*) FROM ahp_nilai_pasangan WHERE tipe=2 AND id_node_0=0 AND id_node_1='$d_kriteria1[id_kriteria_seleksi]' AND id_node_2='$d_kriteria2[id_kriteria_seleksi]'";
            $h_sql_cek = querydb($q_sql_cek);
            $d_sql_cek = mysqli_fetch_array($h_sql_cek);

            if ($d_sql_cek[0] == 0) {
                $q_sql_cek = "SELECT count(*) FROM ahp_nilai_pasangan WHERE tipe=2 AND id_node_0=0 AND id_node_2='$d_kriteria1[id_kriteria_seleksi]' AND id_node_1='$d_kriteria2[id_kriteria_seleksi]'";
                $h_sql_cek = querydb($q_sql_cek);
                $d_sql_cek = mysqli_fetch_array($h_sql_cek);
                if ($d_sql_cek[0] == "" || $d_sql_cek[0] == 0) {
                    $query = "INSERT INTO ahp_nilai_pasangan (tipe, id_node_0, id_node_1, id_node_2, nilai_1, nilai_2)
							   VALUES (2,0,'$d_kriteria1[id_kriteria_seleksi]','$d_kriteria2[id_kriteria_seleksi]',1,1)";
                    querydb($query);
                }
            }
        }
    }

    if (@$_POST['status'] == "save") {
        //Simpan Nilai yang dipilih
        $id_nilai_pasangan = @$_POST['id_nilai_pasangan'];

        $jml_matrix = count($id_nilai_pasangan);
        for ($i = 0; $i < $jml_matrix; $i++) {
            $id_pasang = $id_nilai_pasangan[$i];
            $nilai = antiinjec(@$_POST['pilih' . $id_pasang]);
//            var_dump($nilai);
            $nilai_1 = 0;
            $nilai2 = 0;
            if ($nilai == -9) {
                $nilai_1 = 9;
                $nilai_2 = 1 / 9;
            } elseif ($nilai == -8) {
                $nilai_1 = 8;
                $nilai_2 = 1 / 8;
            } elseif ($nilai == -7) {
                $nilai_1 = 7;
                $nilai_2 = 1 / 7;
            } elseif ($nilai == -6) {
                $nilai_1 = 6;
                $nilai_2 = 1 / 6;
            } elseif ($nilai == -5) {
                $nilai_1 = 5;
                $nilai_2 = 1 / 5;
            } elseif ($nilai == -4) {
                $nilai_1 = 4;
                $nilai_2 = 1 / 4;
            } elseif ($nilai == -3) {
                $nilai_1 = 3;
                $nilai_2 = 1 / 3;
            } elseif ($nilai == -2) {
                $nilai_1 = 2;
                $nilai_2 = 1 / 2;
            } elseif ($nilai == 1) {
                $nilai_1 = 1;
                $nilai_2 = 1;
            } elseif ($nilai == 2) {
                $nilai_1 = 1 / 2;
                $nilai_2 = 2;
            } elseif ($nilai == 3) {
                $nilai_1 = 1 / 3;
                $nilai_2 = 3;
            } elseif ($nilai == 4) {
                $nilai_1 = 1 / 4;
                $nilai_2 = 4;
            } elseif ($nilai == 5) {
                $nilai_1 = 1 / 5;
                $nilai_2 = 5;
            } elseif ($nilai == 6) {
                $nilai_1 = 1 / 6;
                $nilai_2 = 6;
            } elseif ($nilai == 7) {
                $nilai_1 = 1 / 7;
                $nilai_2 = 7;
            } elseif ($nilai == 8) {
                $nilai_1 = 1 / 8;
                $nilai_2 = 8;
            } elseif ($nilai == 9) {
                $nilai_1 = 1 / 9;
                $nilai_2 = 9;
            }

            $query = "UPDATE ahp_nilai_pasangan SET nilai_1='$nilai_1', nilai_2='$nilai_2'
				   WHERE id_nilai_pasangan='$id_pasang'";
            querydb($query);
        }
    }
}

?>

<style>
    input[type=radio], input[type=checkbox] {
        /* display:none; */
        margin:10px;
        position: absolute;
        z-index: -1;
    }

    input[type=radio] + label, input[type=checkbox] + label {
        display:inline-block;
        margin:-2px;
        padding: 4px 11px;
        margin-bottom: 0;
        font-size: 14px;
        line-height: 20px;
        color: #333;
        text-align: center;
        text-shadow: 0 1px 1px rgba(255,255,255,0.75);
        vertical-align: middle;
        cursor: pointer;
        background-color: #f5f5f5;
        /*background-image: -moz-linear-gradient(top,#fff,#e6e6e6);*/
        background-image: -moz-linear-gradient(top,#fff,#e6e6e6);
        background-image: -webkit-gradient(linear,0 0,0 100%,from(#fff),to(#e6e6e6));
        background-image: -webkit-linear-gradient(top,#fff,#e6e6e6);
        background-image: -o-linear-gradient(top,#fff,#e6e6e6);
        background-image: linear-gradient(to bottom,#fff,#e6e6e6);
        background-repeat: repeat-x;
        border: 1px solid #ccc;
        border-color: #e6e6e6 #e6e6e6 #bfbfbf;
        border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
        border-bottom-color: #b3b3b3;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff',endColorstr='#ffe6e6e6',GradientType=0);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
        -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
    }

    input[type=radio]:checked + label, input[type=checkbox]:checked + label{
        background-image: none;
        outline: 0;
        -webkit-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
        -moz-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
        background-color:#0066CC;
        color:#FFF;
        border-bottom:1px solid #06C;
    }
</style>

<div class="card">
    <div class="card-header"><h4>1. Perbandingan Kriteria (Untuk Menentukan Bobot Kriteria)</h4></div>

    <!-- PILIH SELEKSI -->
    <form class="card-block table-border-style" method="post" action="?h=nilai-kriteria" enctype="multipart/form-data">
        <div class="table-responsive">
            <table width="100%" border="0" cellspacing="0" cellpadding="4">
                <tr><td colspan="2"></td></tr>
                <tr>
                    <td width="14%">Pilih Seleksi :</td>
                    <td width="86%">
                        <select name="seleksi" onchange="this.form.submit()" style="font-size:16px; color:#333; padding-top:2px; width:auto;">
                            <option value="0"></option>
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
        </div>
    </form>

    <?php if (!empty($seleksi)) { ?>
        <form class="card-block table-border-style" method="post" action="?h=nilai-kriteria" class="row-fluid margin-none">
            <input type="hidden" name="status" value="save" />
            <input type="hidden" name="seleksi" value="<?php echo $seleksi ?>" />
            <input type="hidden" name="alternatif" value="<?php echo!empty($alternatif) ? $alternatif : null; ?>" />
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td width='4%'>No.</td>
                        <td width='18%'>Nama Kriteria</td>
                        <td width='55%' style="text-align:center;">Pilih Nilai</td>
                        <td width='18%'>Nama Kriteria</td>
                    </tr>
                    <?php
                    $tampil = "SELECT b.id_kriteria_seleksi, a.kriteria, c.tipe, c.id_node_0, c.id_node_1, c.id_node_2, c.id_nilai_pasangan, c.nilai_1, c.nilai_2
	  			FROM ahp_kriteria as a, ahp_kriteria_seleksi as b, ahp_nilai_pasangan as c
				WHERE c.tipe=2 AND c.id_node_0=0 AND a.id_kriteria=b.id_kriteria AND b.id_kriteria_seleksi=c.id_node_1 AND b.id_seleksi='$seleksi' ORDER BY c.id_nilai_pasangan ASC, b.id_kriteria_seleksi ASC";
                    $h_tampil = querydb($tampil);
                    $no = 1;
                    while ($r = mysqli_fetch_array($h_tampil)) {
                        //$harga=format_rupiah($r['harga']);
                        $tampil2 = "SELECT b.id_kriteria_seleksi, a.kriteria, c.tipe, c.id_node_0, c.id_node_1, c.id_node_2, c.id_nilai_pasangan, c.nilai_1, c.nilai_2
	  			   FROM ahp_kriteria as a, ahp_kriteria_seleksi as b, ahp_nilai_pasangan as c
				   WHERE c.tipe=2 AND c.id_node_0=0 AND a.id_kriteria=b.id_kriteria AND b.id_kriteria_seleksi=c.id_node_2 AND b.id_seleksi='$seleksi' AND c.id_nilai_pasangan='$r[id_nilai_pasangan]' ORDER BY c.id_nilai_pasangan ASC, b.id_kriteria_seleksi ASC";
                        $h_tampil2 = querydb($tampil2);
                        $r2 = mysqli_fetch_array($h_tampil2);

                        $nilai = 0;
                        if ($r['nilai_1'] < 1) {
                            $nilai = $r['nilai_2'];
                        } elseif ($r['nilai_1'] > 1) {
                            $nilai = -$r['nilai_1'];
                        } elseif ($r['nilai_1'] == 1) {
                            $nilai = 1;
                        }

                        ?>
                        <tr>
                            <td>
                                <input type="hidden" name="id_nilai_pasangan[]" value="<?php echo $r['id_nilai_pasangan']; ?>" />
                                <?php echo $no; ?>
                            </td>
                            <td><?php echo $r['kriteria']; ?></td>
                            <td style="text-align:center;">
                                <input type="radio" id="radio1<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="-9" <?php
                                if ($nilai == -9) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio1<?php echo $no; ?>"><a title="ABCDEFGH">9</a></label>
                                <input type="radio" id="radio2<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="-8" <?php
                                if ($nilai == -8) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio2<?php echo $no; ?>">8</label>
                                <input type="radio" id="radio3<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="-7" <?php
                                if ($nilai == -7) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio3<?php echo $no; ?>">7</label>
                                <input type="radio" id="radio4<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="-6" <?php
                                if ($nilai == -6) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio4<?php echo $no; ?>">6</label>
                                <input type="radio" id="radio5<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="-5" <?php
                                if ($nilai == -5) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio5<?php echo $no; ?>">5</label>
                                <input type="radio" id="radio6<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="-4" <?php
                                if ($nilai == -4) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio6<?php echo $no; ?>">4</label>
                                <input type="radio" id="radio7<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="-3" <?php
                                if ($nilai == -3) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio7<?php echo $no; ?>">3</label>
                                <input type="radio" id="radio8<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="-2" <?php
                                if ($nilai == -2) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio8<?php echo $no; ?>">2</label>
                                <input type="radio" id="radio9<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="1"  <?php
                                if ($nilai == 1) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio9<?php echo $no; ?>">1</label>
                                <input type="radio" id="radio10<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="2" <?php
                                if ($nilai == 2) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio10<?php echo $no; ?>">2</label>
                                <input type="radio" id="radio11<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="3" <?php
                                if ($nilai == 3) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio11<?php echo $no; ?>">3</label>
                                <input type="radio" id="radio12<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="4" <?php
                                if ($nilai == 4) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio12<?php echo $no; ?>">4</label>
                                <input type="radio" id="radio13<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="5" <?php
                                if ($nilai == 5) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio13<?php echo $no; ?>">5</label>
                                <input type="radio" id="radio14<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="6" <?php
                                if ($nilai == 6) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio14<?php echo $no; ?>">6</label>
                                <input type="radio" id="radio15<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="7" <?php
                                if ($nilai == 7) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio15<?php echo $no; ?>">7</label>
                                <input type="radio" id="radio16<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="8" <?php
                                if ($nilai == 8) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio16<?php echo $no; ?>">8</label>
                                <input type="radio" id="radio17<?php echo $no; ?>" name="pilih<?php echo $r['id_nilai_pasangan']; ?>" value="9" <?php
                                if ($nilai == 9) {
                                    echo "checked";
                                }

                                ?>>
                                <label for="radio17<?php echo $no; ?>">9</label>
                            </td>
                            <td><?php echo $r2['kriteria']; ?></td>
                        </tr>
                        <?php
                        $no++;
                    }

                    ?>
                </table>
            </div>
            <button id='send' type='submit' name="btn_simpan" class="btn btn-primary btn-sm btn-round">Simpan Data</button>
        </form>
    </div>

    <div class="card">
        <!-- Matriks Nilai Perbandingan -->
        <?php if ($seleksi != "") { ?>
            <!-- ++++++++++++++ DIHITUNG EIGENNYA DISINI ++++++++++++++++ -->
            <div class="card-header"><h5>Matriks Nilai Perbandingan</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" border="0" cellspacing="0" cellpadding="4">
                        <?php
                        $h_node = querydb("SELECT a.id_kriteria_seleksi FROM ahp_kriteria_seleksi as a, ahp_kriteria as b
					 WHERE a.id_kriteria=b.id_kriteria AND a.id_seleksi='$seleksi'
					 ORDER BY a.id_kriteria_seleksi ASC");
                        $jml_node = mysqli_num_rows($h_node);

                        ?>
                        <tr>
                            <td width='3%'>No.</td>
                            <td>Kriteria</td>
                            <?php
                            for ($i = 1; $i <= $jml_node; $i++) {

                                ?>
                                <td><?php echo sprintf("K%02d", $i); ?></td>
                            <?php } ?>
                        </tr>
                        <?php
                        $total = array();  //Array untuk menyimpan jumlah total
                        $tampil = "SELECT a.id_kriteria_seleksi, b.kriteria FROM ahp_kriteria_seleksi as a, ahp_kriteria as b
			  WHERE a.id_kriteria=b.id_kriteria AND a.id_seleksi='$seleksi'
			  ORDER BY a.id_kriteria_seleksi ASC";
                        $h_tampil = querydb($tampil);
                        $no = 1;
                        while ($r = mysqli_fetch_array($h_tampil)) {
                            $n_node = sprintf("K%02d", $no);

                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $n_node . ' - ' . $r['kriteria']; ?></td>
                                <?php
                                $n = 0;
                                $h_node = querydb("SELECT a.id_kriteria_seleksi FROM ahp_kriteria_seleksi as a, ahp_kriteria as b
						   WHERE a.id_kriteria=b.id_kriteria AND a.id_seleksi='$seleksi'
						   ORDER BY a.id_kriteria_seleksi ASC");
                                while ($d_node = mysqli_fetch_array($h_node)) {
                                    $nilai_pasang = 0;
                                    $h_nilai1 = querydb("SELECT nilai_1 FROM ahp_nilai_pasangan WHERE tipe=2 AND id_node_0=0 AND
                                  id_node_1='$r[id_kriteria_seleksi]' AND id_node_2='$d_node[id_kriteria_seleksi]'");
                                    $d_nilai1 = mysqli_fetch_array($h_nilai1);
                                    $h_nilai2 = querydb("SELECT nilai_2 FROM ahp_nilai_pasangan WHERE tipe=2 AND id_node_0=0 AND
                                  id_node_2='$r[id_kriteria_seleksi]' AND id_node_1='$d_node[id_kriteria_seleksi]'");
                                    $d_nilai2 = mysqli_fetch_array($h_nilai2);
                                    if ($d_nilai1[0] == 0) {
                                        $nilai_pasang = $d_nilai2[0];
                                    } else {
                                        $nilai_pasang = $d_nilai1[0];
                                    }
                                    if ($nilai_pasang == 0 || $nilai_pasang == "") {
                                        $nilai_pasang = 1;
                                    }

                                    ?>
                                    <td><?php echo number_format($nilai_pasang, 2, ',', '.'); ?></td>
                                    <?php
                                    $jumlah[$n][] = $nilai_pasang;

                                    ?>
                                    <?php
                                    $n++;
                                }

                                ?>
                            </tr>
                            <?php
                            $no++;
                        }

                        ?>
                        <tr>
                            <td></td>
                            <td style="font-weight:bold; color:#333;">Jumlah</td>
                            <?php
                            for ($i = 0; $i < $jml_node; $i++) {
                                $sum = array_sum($jumlah[$i]);
                                $total[$i] = $sum;

                                ?>
                                <td style="font-weight:bold; color:#333;"><?php echo number_format($sum, 2, ",", '.'); ?></td>
                            <?php } ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Normalisasi Dan Nilai Eigen</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <?php
                        $h_node = querydb("SELECT a.id_kriteria_seleksi, b.kriteria FROM ahp_kriteria_seleksi as a, ahp_kriteria as b
					 WHERE a.id_kriteria=b.id_kriteria AND a.id_seleksi='$seleksi'
					 ORDER BY a.id_kriteria_seleksi ASC");
                        $jml_node = mysqli_num_rows($h_node);

                        ?>
                        <tr>
                            <td width='3%'>No.</td>
                            <td>Kriteria</td>
                            <?php
                            for ($i = 1; $i <= $jml_node; $i++) {

                                ?>
                                <td><?php echo sprintf("K%02d", $i); ?></td>
                            <?php } ?>
                            <td style="font-weight:bold; color:#09F;">Eigen</td>
                        </tr>
                        <?php
                        $eigen = array();
                        $tampil = "SELECT a.id_kriteria_seleksi, b.kriteria FROM ahp_kriteria_seleksi as a, ahp_kriteria as b
			  WHERE a.id_kriteria=b.id_kriteria AND a.id_seleksi='$seleksi'
			  ORDER BY a.id_kriteria_seleksi ASC";
                        $h_tampil = querydb($tampil);
                        $no = 1;
                        while ($r = mysqli_fetch_array($h_tampil)) {
                            $n_node = sprintf("K%02d", $no);

                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $n_node . ' - ' . $r['kriteria']; ?></td>
                                <?php
                                $n = 0;
                                $jumlah_normalisasi = 0;
                                $h_node = querydb("SELECT a.id_kriteria_seleksi, b.kriteria FROM ahp_kriteria_seleksi as a, ahp_kriteria as b
						   WHERE a.id_kriteria=b.id_kriteria AND a.id_seleksi='$seleksi'
						   ORDER BY a.id_kriteria_seleksi ASC");
                                while ($d_node = mysqli_fetch_array($h_node)) {
                                    $nilai_pasang = 0;
                                    $h_nilai1 = querydb("SELECT nilai_1 FROM ahp_nilai_pasangan WHERE tipe=2 AND id_node_0=0 AND
                                  id_node_1='$r[id_kriteria_seleksi]' AND id_node_2='$d_node[id_kriteria_seleksi]'");
                                    $d_nilai1 = mysqli_fetch_array($h_nilai1);
                                    $h_nilai2 = querydb("SELECT nilai_2 FROM ahp_nilai_pasangan WHERE tipe=2 AND id_node_0=0 AND
                                  id_node_2='$r[id_kriteria_seleksi]' AND id_node_1='$d_node[id_kriteria_seleksi]'");
                                    $d_nilai2 = mysqli_fetch_array($h_nilai2);
                                    if ($d_nilai1[0] == 0) {
                                        $nilai_pasang = $d_nilai2[0];
                                    } else {
                                        $nilai_pasang = $d_nilai1[0];
                                    }
                                    if ($nilai_pasang == 0 || $nilai_pasang == "") {
                                        $nilai_pasang = 1;
                                    }
                                    $nilai_normalisasi = $nilai_pasang / $total[$n];
                                    $jumlah_normalisasi = $jumlah_normalisasi + $nilai_normalisasi;

                                    ?>
                                    <td><?php echo number_format($nilai_normalisasi, 3, ',', '.'); ?></td>
                                    <?php
                                    $n++;
                                }
                                $eigen[$no - 1] = $jumlah_normalisasi / $jml_node;
                                $urut = $no - 1;
                                //Simpan Bobot di Tabel
                                $cek_data = mysqli_fetch_array(querydb("SELECT COUNT(*) FROM ahp_nilai_eigen WHERE tipe=2 AND id_node_0=0 AND id_node='$r[id_kriteria_seleksi]'"));
                                if ($cek_data[0] == 0) {
                                    querydb("INSERT INTO ahp_nilai_eigen(tipe, id_node_0, id_node, nilai) VALUES (2, 0, '$r[id_kriteria_seleksi]', '$eigen[$urut]')");
                                } else {
                                    querydb("UPDATE ahp_nilai_eigen SET nilai='$eigen[$urut]' WHERE tipe=2 AND id_node_0=0 AND id_node='$r[id_kriteria_seleksi]'");
                                }

                                ?>
                                <td style="font-weight:bold; color:#333;"><?php echo number_format($eigen[$no - 1], 3, ',', '.'); ?></td>
                            </tr>
                            <?php
                            $no++;
                        }

                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Cek Konsistensi</h5><span>Hasil Cek Nilai Konsistensi</span></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td width="21%">(A)(W^t)</td>
                            <td width="1%">:</td>
                            <td width="78%">
                                <?php
                                //Menghitung (A)(Wt)
                                $AWt = array();
                                $tampil = "SELECT a.id_kriteria_seleksi, b.kriteria FROM ahp_kriteria_seleksi as a, ahp_kriteria as b
					  WHERE a.id_kriteria=b.id_kriteria AND a.id_seleksi='$seleksi'
					  ORDER BY a.id_kriteria_seleksi ASC";
                                $h_tampil = querydb($tampil);
                                $no = 0;
                                while ($r = mysqli_fetch_array($h_tampil)) {
                                    $AWt_line = 0; //Nilai AWt per baris
                                    $n = 0;
                                    $h_node = querydb("SELECT a.id_kriteria_seleksi, b.kriteria FROM ahp_kriteria_seleksi as a, ahp_kriteria as b
							   WHERE a.id_kriteria=b.id_kriteria AND a.id_seleksi='$seleksi'
							   ORDER BY a.id_kriteria_seleksi ASC");
                                    while ($d_node = mysqli_fetch_array($h_node)) {
                                        $nilai_pasang = 0;
                                        $h_nilai1 = querydb("SELECT nilai_1 FROM ahp_nilai_pasangan WHERE tipe=2 AND id_node_0=0 AND
									id_node_1='$r[id_kriteria_seleksi]' AND id_node_2='$d_node[id_kriteria_seleksi]'");
                                        $d_nilai1 = mysqli_fetch_array($h_nilai1);
                                        $h_nilai2 = querydb("SELECT nilai_2 FROM ahp_nilai_pasangan WHERE tipe=2 AND id_node_0=0 AND
									id_node_2='$r[id_kriteria_seleksi]' AND id_node_1='$d_node[id_kriteria_seleksi]'");
                                        $d_nilai2 = mysqli_fetch_array($h_nilai2);
                                        if ($d_nilai1[0] == 0) {
                                            $nilai_pasang = $d_nilai2[0];
                                        } else {
                                            $nilai_pasang = $d_nilai1[0];
                                        }
                                        if ($nilai_pasang == 0 || $nilai_pasang == "") {
                                            $nilai_pasang = 1;
                                        }
                                        $AWt_line = $AWt_line + ($nilai_pasang * $eigen[$n]);
                                        $n++;
                                    }
                                    $AWt[$no] = $AWt_line;
                                    $no++;
                                }
                                for ($i = 0; $i < $jml_node; $i++) {
                                    echo "[" . number_format($AWt[$i], 4, ',', '.') . "] ";
                                }

                                ?>
                            </td>

                        <tr>
                            <td>t</td>
                            <td>:</td>
                            <td>
                                <?php
                                $t = 0;
                                $tot_AWt_per_Eigen = 0;  //Nilai jumlah AWt/Eigen
                                for ($i = 0; $i < $jml_node; $i++) {
                                    $tot_AWt_per_Eigen = $tot_AWt_per_Eigen + ($AWt[$i] / $eigen[$i]);
                                }
                                $t = $tot_AWt_per_Eigen / $jml_node;
                                echo number_format($t, 4, ',', '.');

                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Index Konsistensi (CI)</td>
                            <td>:</td>
                            <td>
                                <?php
                                $CI = 0; //Index konsistensi
                                $CI = ($t - $jml_node) / ($jml_node - 1);
                                echo number_format($CI, 4, ',', '.');

                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Rasio Konsistensi</td>
                            <td>:</td>
                            <td>
                                <?php
                                //Ambil nilai RI berdasar besar matrix/jumlah kriteria
                                $h_nilaiRI = querydb("SELECT nilai FROM ahp_nilai_random_index WHERE matrix='$jml_node'");
                                $d_nilaiRI = mysqli_fetch_array($h_nilaiRI);
                                $nilai_RI = $d_nilaiRI['nilai'];

//                        var_dump($jml_node);
//                        var_dump($CI);
//                        exit(var_dump($nilai_RI));
                                $Rasio_Konsistensi = $CI / $nilai_RI; //Nilai Rasio Konsisitensi
                                echo number_format($Rasio_Konsistensi, 4, ',', '.');

                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold; color:#333;">Hasil Konsistensi</td>
                            <td style="font-weight:bold; color:#333;">:</td>
                            <td style="font-weight:bold; color:#333;">
                                <?php
                                //Cek bila Nilai Rasio Konsisitensi <= 0,1 maka sudah Cukup Konsisten, jika > 0,1 maka tidak konsisten
                                if ($Rasio_Konsistensi <= 0.1) {
                                    echo "KONSISTEN";
                                } else {
                                    echo "Belum Konsisten";
                                }

                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        </div>
    <?php } ?>