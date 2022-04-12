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

if (isset($_POST['btn-save'])) {
    $id = $_GET['id'];
    if ($pengurus->updateData($id, $_POST, $_FILES) > 0) {
        echo "<script>
            alert('Data berhasil diubah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal diubah!');
            document.location.href = 'index.php';
        </script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $pengurus->getPengurusById($id);
        $row = $pengurus->getResult();

        $pengurus->getPengurusById($id);
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

        $dataPeng = [];
        $dataDiv = null;
        $dataJab = null;

        foreach ($divs as $div) {
            $dataDiv .= '<option value="' . $div['divisi_id'] . '">' . $div['divisi_nama'] . '</option>';
        }

        foreach ($jabs as $jab) {
            $dataJab .= '<option value="' . $jab['jabatan_id'] . '">' . $jab['jabatan_nama'] . '</option>';
        }

        $title = 'Ubah';

        $dataPeng[0] = $row['pengurus_nim'];
        $dataPeng[1] = $row['pengurus_nama'];
        $dataPeng[2] = $row['pengurus_semester'];
        $dataPeng[3] = $row['divisi_id'];
        $dataPeng[4] = $row['jabatan_id'];
    }
}

$pengurus->close();
$divisi->close();
$jabatan->close();

$tambah = new Template('templates/skintambah.html');
$tambah->replace('DATA_TITLE', $title);
$tambah->replace('DATA_DIVISI', $dataDiv);
$tambah->replace('DATA_JABATAN', $dataJab);
$tambah->replace('DATA_NIM', $dataPeng[0]);
$tambah->replace('DATA_NAMA', $dataPeng[1]);
$tambah->replace('DATA_SMT', $dataPeng[2]);
$tambah->replace('DATA_DIV', $dataPeng[3]);
$tambah->replace('DATA_JAB', $dataPeng[4]);
// for ($i = 0; $i < 5; $i++) {
//     $tambah->replace('DATA_VAL[' . $i . ']', $dataPeng[$i]);
// }
$tambah->write();
