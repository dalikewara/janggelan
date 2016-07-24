<?php namespace system\dragon_fire\artists;

use system\dragon_fire\abstractions\database\ArtistModel as Blueprint;
use system\dragon_fire\controllers\DatabaseDataController;

/*
||***************************************************************************||
|| Kelas Artist Model menangani fungsi-fungsi interaktif yang bisa digunakan ||
|| oleh sebuah Model untuk membantu pekerjaan menjadi lebih mudah.           ||
|| Fungsi-fungsi yang tersedia hanya bisa di pakai untuk objek Model saja.   ||
||***************************************************************************||
||
*/
class Model extends Blueprint
{
    /**
    ***************************************************************************
    * Fungsi untuk membuka koneksi ke Database.
    *
    * @return   mixed
    *
    */
    public function Open()
    {
        // Mendapatkan data database
        $dbProperties = new DatabaseDataController;
        $dbProperties = $dbProperties->data();

        // Mendapatkan koneksi bawaan
        static::$smartConnection = $dbProperties['DB_DEFAULT_CONNECTION'];

        // Proses koneksi ke Database
        try
        {
            switch($dbProperties['DB_DEFAULT_CONNECTION'])
            {
                default:
                    static::$dbConnect = new \PDO(
                        static::$smartConnection . ':host=' .
                        $dbProperties['DB_HOST'] . ';dbname=' . $dbProperties['DB_NAME'],
                        $dbProperties['DB_USERNAME'], $dbProperties['DB_PASSWORD']
                    );
                    break;
            }

            static::$dbConnect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch(\PDOException $e)
        {
            die('Connection failed! ' . $e->getMessage() . '<br>' . $e->getLine());
        }
    }

    /**
    ***************************************************************************
    * Menampilkan dan mendapatkan semua data dari tabel
    *
    * @return   array
    *
    */
    public function All()
    {
        $x = 0;

        // Membuat properti untuk metode query 'SELECT'
        if($this->artistModelSelect != '*')
        {
            $boolAMS         = FALSE;
            $columnNameIndex = explode(' ', $this->artistModelSelect);

            if(isset($columnNameIndex[1]))
            {
                $columnNameIndex = explode(',', $columnNameIndex[1]);
            }
            else
            {
                $columnNameIndex = explode(',', $columnNameIndex[0]);
            }

            $totalColumn = count($columnNameIndex);
        }
        else
        {
            $boolAMS         = TRUE;
            $columnNameIndex = static::$smartColumn;
            $totalColumn     = count(static::$smartColumn);
        }

        // Menyaring proses query dari koneksi-koneksi Database
        switch(static::$smartConnection)
        {
            case 'mysql':
                $result = static::$dbConnect->query(
                    "SELECT $this->artistModelSelect FROM " . static::$smartTable .
                    " $this->artistModelClause"
                );
                break;
        }

        // Proses untuk mendapatkan data
        if($result->rowCount() > 0)
        {
            while($row = $result->fetch())
            {
                for($i = 0; $i < $totalColumn; $i++)
                {
                    if($boolAMS)
                    {
                        $array[$x][$columnNameIndex[$i]] = $row[$columnNameIndex[$i]];
                    }
                    else
                    {
                        $array[$x] = $row[$columnNameIndex[$i]];
                    }
                }

                $x++;
            }
        }
        else
        {
            $array = [];
        }

        return $array;
    }

    /**
    ***************************************************************************
    * Menampilkan semua data berdasarkan nama kolom yang dipilih
    *
    * @param    string   $column
    * @return   $this
    *
    */
    public function Select($column)
    {
        $this->artistModelSelect = $column;

        return $this;
    }

    /**
    ***************************************************************************
    * Menyaring data berdasarkan tipe yang ditentukan
    *
    * @param    string   $value
    * @return   $this
    *
    */
    public function Clause($value)
    {
        $this->artistModelClause = $value;

        return $this;
    }

    /**
    ***************************************************************************
    * Menampilkan dan mendapatkan semua data yang sebelumnya di seleksi
    *
    * @return   array
    *
    */
    public function Result()
    {
        $result = $this->All();

        // Mengembalikan nilai ke bawaan(default)
        $this->artistModelSelect = '*';
        $this->artistModelClause = '';

        return $result;
    }

    /**
    ***************************************************************************
    * Membuat table ke Database
    *
    * @return   mixed
    *
    */
    public function Create()
    {
        switch(static::$smartConnection)
        {
            case 'mysql':
                // Get data
                $x          = 0;
                $createData = '';

                foreach(static::$defaultColumn as $defColumn)
                {
                    $createData .= ' ' . static::$smartColumn[$x] . ' ' . $defColumn . ',';

                    $x++;
                }

                $createData     = rtrim($createData, ',');
                $createProperty = "CREATE TABLE " . static::$smartTable . "($createData)";

                static::$dbConnect->exec($createProperty);
                break;
        }
    }

    /**
    ***************************************************************************
    * Menutup koneksi Database
    *
    * @return   mixed
    *
    */
    public function Die()
    {
        static::$dbConnect = NULL;
    }
}
