<?php

class Pengurus extends Jabatan
{
    function getPengurusJoin()
    {
        $query = "SELECT * FROM pengurus JOIN divisi ON pengurus.divisi_id=divisi.divisi_id JOIN jabatan ON pengurus.jabatan_id=jabatan.jabatan_id ORDER BY pengurus.pengurus_id";

        return $this->execute($query);
    }

    function getPengurus()
    {
        $query = "SELECT * FROM pengurus";
        return $this->execute($query);
    }

    function getPengurusById($id)
    {
        $query = "SELECT * FROM pengurus JOIN divisi ON pengurus.divisi_id=divisi.divisi_id JOIN jabatan ON pengurus.jabatan_id=jabatan.jabatan_id WHERE pengurus_id=$id";
        return $this->execute($query);
    }

    function searchPengurus($keyword)
    {
        $query = "SELECT * FROM pengurus JOIN divisi ON pengurus.divisi_id=divisi.divisi_id JOIN jabatan ON pengurus.jabatan_id=jabatan.jabatan_id WHERE pengurus_nama LIKE '%$keyword%' OR divisi_nama LIKE '%$keyword%' OR jabatan_nama LIKE '%$keyword%' ORDER BY pengurus.pengurus_id;";
        return $this->execute($query);
    }

    function addData($data, $file)
    {
        $foto = $file['foto']['name'];
        $temp_foto = $file['foto']['tmp_name'];
        $folder = 'assets/images/' . $foto;
        $isMoved = move_uploaded_file($temp_foto, $folder);
        if (!$isMoved) {
            $foto = 'default.jpg';
        }
        $nim = $data['nim'];
        $nama = $data['nama'];
        $semester = $data['semester'];
        $divisi = $data['divisi'];
        $jabatan = $data['jabatan'];

        $query = "INSERT INTO pengurus VALUES('', '$foto', '$nim', '$nama', $semester, $divisi, $jabatan);";

        return $this->executeAffected($query);
    }

    function updateData($id, $data, $file)
    {
        $foto = $file['foto']['name'];
        $temp_foto = $file['foto']['tmp_name'];
        $folder = 'assets/images/' . $foto;
        $isMoved = move_uploaded_file($temp_foto, $folder);
        if (!$isMoved) {
            $foto = 'default.jpg';
        }
        $nim = $data['nim'];
        $nama = $data['nama'];
        $semester = $data['semester'];
        $divisi = $data['divisi'];
        $jabatan = $data['jabatan'];

        $query = "UPDATE pengurus SET
                pengurus_foto='$foto',
                pengurus_nim='$nim',
                pengurus_nama='$nama',
                pengurus_semester=$semester,
                divisi_id=$divisi,
                jabatan_id=$jabatan
                WHERE pengurus_id=$id;";

        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        $query = "DELETE FROM pengurus WHERE pengurus_id=$id";
        return $this->executeAffected($query);
    }
}
