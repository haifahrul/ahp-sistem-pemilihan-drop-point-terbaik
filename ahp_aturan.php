<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ahp_aturan
{

    public static function denda($seleksi, $getIdKriteria, $value)
    {
        $aturanQuery = "SELECT ak.value FROM ahp_kandidat ak WHERE ak.id_seleksi='$seleksi' AND ak.id_kriteria='$getIdKriteria'";
        $aturanQueryDb = querydb($aturanQuery);
        $aturan = mysqli_fetch_all($aturanQueryDb);

        $nilaiKonversi = [];
        if ($value <= 100000) {
            $nilaiKonversi[0] = 9;
        } elseif ($value <= 200000) {
            $nilaiKonversi[0] = 8;
        } elseif ($value <= 300000) {
            $nilaiKonversi[0] = 7;
        } elseif ($value <= 400000) {
            $nilaiKonversi[0] = 6;
        } elseif ($value <= 500000) {
            $nilaiKonversi[0] = 5;
        } elseif ($value <= 600000) {
            $nilaiKonversi[0] = 4;
        } elseif ($value <= 700000) {
            $nilaiKonversi[0] = 3;
        } elseif ($value <= 800000) {
            $nilaiKonversi[0] = 2;
        } elseif ($value <= 900000) {
            $nilaiKonversi[0] = 1;
        } else {
            $nilaiKonversi[0] = 1;
        }

        return $nilaiKonversi;
    }
}
