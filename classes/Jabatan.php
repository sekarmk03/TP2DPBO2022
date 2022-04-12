<?php

class Jabatan extends Divisi
{
    function getJabatan()
    {
        $query = "SELECT * FROM jabatan";
        return $this->execute($query);
    }

    function getJabatanById($id)
    {
        $query = "SELECT * FROM jabatan WHERE jabatan_id=$id";
        return $this->execute($query);
    }

    function addJabatan($data)
    {
        $nama = $data['nama'];
        $query = "INSERT INTO jabatan VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    function updateJabatan($id, $data)
    {
        $nama = $data['nama'];
        $query = "UPDATE jabatan SET jabatan_nama='$nama' WHERE jabatan_id=$id";
        return $this->executeAffected($query);
    }

    function deleteJabatan($id)
    {
        $query = "DELETE FROM jabatan WHERE jabatan_id=$id";
        return $this->executeAffected($query);
    }
}
