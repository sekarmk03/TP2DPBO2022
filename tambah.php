<?php

include('config.php');
include('classes/DB.php');
include('classes/Divisi.php');
include('classes/Jabatan.php');
include('classes/Pengurus.php');
include('classes/Template.php');

$pengurus = new Pengurus($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$divisi = new Divisi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$jabatan = new Jabatan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$pengurus->open();
$divisi->open();
$jabatan->open();

$divisi->getDivisi();
$jabatan->getJabatan();

$divs = [];
while ($div = $divisi->getResult()) {
    $divs[] = $div;
}

$jabs = [];
while ($jab = $jabatan->getResult()) {
    $jabs[] = $jab;
}

$dataDiv = null;
$dataJab = null;

if (isset($_POST['btn-save'])) {
    if ($pengurus->addData($_POST, $_FILES) > 0) {
        echo "<script>
            alert('Data berhasil ditambah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambah!');
            document.location.href = 'index.php';
        </script>";
    }
}

$title = 'Tambah';

foreach ($divs as $div) {
    $dataDiv .= '<option value="' . $div['divisi_id'] . '">' . $div['divisi_nama'] . '</option>';
}

foreach ($jabs as $jab) {
    $dataJab .= '<option value="' . $jab['jabatan_id'] . '">' . $jab['jabatan_nama'] . '</option>';
}

$pengurus->close();
$divisi->close();
$jabatan->close();

$tambah = new Template('templates/skintambah.html');
$tambah->replace('DATA_TITLE', $title);
$tambah->replace('DATA_DIVISI', $dataDiv);
$tambah->replace('DATA_JABATAN', $dataJab);
$tambah->write();
