<?php namespace system\dragon_fire\artists;

use system\dragon_fire\abstractions\database\ArtistModel as Blueprint;
use system\dragon_fire\exceptions\DragonHandler;
use system\jobs\Validate;

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
    use Validate, \register\paths;

    /**
    ***************************************************************************
    * Fungsi untuk membuka koneksi ke Database. Jika Anda tidak ingin Janggelan
    * melakukan koneksi ke database secara otomatis (configurasi config/database.php),
    * maka Anda bisa menggunakan fungsi ini untuk membuka koneksi secara manual.
    * Untuk mengakhiri koneksi, silahkan menggunakan fungsi 'Die()'.
    *
    * @return   mixed
    *
    */
    public function Open()
    {
        try
        {
            $this->dbConnect = $this->dbProperties->connectProperty();

            $this->dbConnect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch(\PDOException $e)
        {
            die('Connection failed! ' . $e->getMessage() . '<br>' . $e->getLine());
        }
    }

    /**
    ***************************************************************************
    * Fungsi untuk membuat table ke Database. Properti table yang akan dibuat
    * berasal dari fungsi 'tableInformation()' di Modelnya. Pastikan Anda mengisi
    * properti tersebut dengan data yang valid.
    *
    * @return   mixed
    *
    */
    public function Create()
    {
        $this->Open();

        $x          = 0;
        $createData = '';

        foreach($this->defaultColumn as $defColumn)
        {
            $createData .= ' ' . $this->smartColumn[$x] . ' ' . $defColumn . ',';

            $x++;
        }

        $createData = rtrim($createData, ',');

        $this->dbConnect->exec($this->dbProperties->createProperty($this->smartTable, $createData));
        $this->Die();
    }

    /**
    ***************************************************************************
    * Fungsi untuk menambah data ke Database. Pastikan Anda mengisi dengan
    * data yang valid.
    *
    * @param    array   data
    * @return   mixed
    *
    */
    public function Insert(array $data)
    {
        $this->Open();

        $data       = is_array($data) ? $data : array();
        $columnName = implode(', ', array_keys($data));
        $value      = implode(", ", array_keys(array_combine(array_map(function($a){return ":$a";},
            array_keys($data)), array_values($data))));
        $bindParams = $data;
        $prepare    = $this->dbConnect->prepare(
            $this->dbProperties->insertProperty($this->smartTable, $columnName, $value)
        );

        $prepare->execute($bindParams);
        $this->Die();
    }

    /**
    ***************************************************************************
    * Fungsi untuk memperbarui data di Database. Pastikan Anda mengisi dengan
    * data yang valid.
    *
    * @param    array   value
    * @param    array   clause
    * @return   mixed
    *
    */
    public function Update(array $value, array $clause)
    {
        $this->Open();

        $value         = is_array($value) ? $value : array();
        $clause        = is_array($clause) ? $clause : array();
        $paramValue    = array_combine(array_map(function($a){return "{$a}value";},
            array_keys($value)), array_values($value));
        $paramClause   = array_combine(array_map(function($a){return "{$a}clause";},
            array_keys($clause)), array_values($clause));
        $value         = array_combine(array_map(function($a){return "$a=:{$a}value";},
            array_keys($value)), array_values($value));
        $clause        = array_combine(array_map(function($a){return "$a=:{$a}clause";},
            array_keys($clause)), array_values($clause));
        $prepareValue  = implode(', ', array_keys($value));
        $prepareClause = implode(' AND ', array_keys($clause));
        $bindParams    = array_merge($paramValue, $paramClause);
        $prepare       = $this->dbConnect->prepare($this->dbProperties->updateProperty(
            $this->smartTable, $prepareValue,$prepareClause));

        $prepare->execute($bindParams);
        $this->Die();
    }

    /**
    ***************************************************************************
    * Fungsi untuk menghapus data di Database. Pastikan Anda mengisi dengan
    * data yang valid. Data akan berupa sebuah 'Clause' untuk memilih identitas
    * data yang akan dihapus.
    *
    * @param    array   data
    * @return   mixed
    *
    */
    public function Delete($data = [])
    {
        $this->Open();

        $data = is_array($data) ? $data : array();

        if(count($data) > 0)
        {
            $value   = implode(" AND ", array_keys(array_combine(array_map(
                function($a){return "$a=:$a";},array_keys($data)), array_values($data))));
            $prepare = $this->dbConnect->prepare(
                $this->dbProperties->deleteProperty($this->smartTable, $value)
            );

            $prepare->execute($data);
        }
        else
        {
            $this->dbConnect->exec(
                $this->dbProperties->deleteProperty($this->smartTable, '', TRUE)
            );
        }

        $this->Die();
    }

    /**
    ***************************************************************************
    * Fungsi untuk menampilkan dan mendapatkan semua data dari tabel. Fungsi ini juga
    * berfungsi untuk mengembalikan dan memproses data-data dari fungsi-fungsi
    * 'Artist Model' yang lain.
    *
    * @return   array
    *
    */
    public function All()
    {
        $this->Open();

        $x = 0;

        // Di bawah ini merupakan proses untuk membuat properti metode query 'SELECT'.
        // Data properti yang diproses tersebut berasal dari fungsi 'Select()'.
        if($this->artistModelSelect != '*')
        {
            // Variabel 'boolAMS (Boolean Artist Model Select)' digunakan sebagai index
            // apakah ada data yang diseleksi atau tidak. Jika tidak ada, maka fungsi ini
            // akan menampilkan semua data secara 'Default'.
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
            $columnNameIndex = $this->smartColumn;
            $totalColumn     = count($this->smartColumn);
        }

        // Di sini adalah proses untuk meminta data ke Database berdasarkan data
        // yang ada. Proses pemisahan seleksi 'Clause' berlangsung disini, apakah
        // akan menggunakan fungsi 'prepare()' atau tidak.
        $prepare = $this->dbProperties->selectProperty($this->artistModelSelect,
                   $this->smartTable, $this->artistModelClause, $this->artistModelRange);

        if(preg_match('/[:][a-zA-Z0-9]*/', $this->artistModelClause))
        {
            $result = $this->dbConnect->prepare($prepare);

            $result->execute($this->artistModelParam);
        }
        else
        {
            $result = $this->dbConnect->query($prepare);
        }

        // Data yang telah diminta akan dikumpulkan di sini dan dikemas untuk
        // ditampilkan.
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

        $this->Die();

        return $array;
    }

    /**
    ***************************************************************************
    * Fungsi untuk memilih data berdasarkan nama kolom.
    *
    * @param    string   $column
    * @return   $this
    *
    */
    public function Select($column)
    {
        // Data seleksi 'Select()' akan ditampung di dalam variabel ini.
        // Kami juga melakukan validasi terhadap data yang masuk.
        $column                  = is_string($column) ? $column : '';
        $this->artistModelSelect = $this->VALIDATE_SQL_DATA($column);

        return $this;
    }

    /**
    ***************************************************************************
    * Fungsi untuk menyaring data berdasarkan jenis atau 'Clause' yang ditentukan.
    * Anda bisa menggunakan 'Clause' sebagai fungsi 'prepare()' untuk meningkatkan
    * keamanan dengan merubah nilai seleksi menjadi syntax ':exampleName'.
    *
    * Contoh umum: $model->Clause("WHERE user='Linus Torvald'").
    * Contoh prepare: $model->Clause("WHERE user=:user").
    *
    * @param    string   $value
    * @return   $this
    *
    */
    public function Clause($value)
    {
        // Data seleksi 'Clause()' akan ditampung di dalam variabel ini.
        // Kami juga melakukan validasi terhadap data yang masuk.
        $value                   = is_string($value) ? $value : '';
        $this->artistModelClause = $value;

        return $this;
    }

    /**
    ***************************************************************************
    * Fungsi untuk melakukan pengisian parameter 'Clause' jika terdapat 'Clause'
    * yang menggunakan fungsi prepare, biasanya ditandai dengan syntax berikut: ':exampleName'.
    * Jika terdapat yang demikian, maka fungsi ini harus disertakan dengan
    * parameter-parameter yang benar.
    *
    * Contoh: $model->Clause("WHERE user=:user")->BindParam(['user' => 'Linus Torvald']).
    *
    * @param    array   $array
    * @return   $this
    *
    */
    public function BindParam(array $array)
    {
        // Data properti 'BindParam()' akan ditampung di dalam variabel ini.
        // Kami juga melakukan validasi terhadap data yang masuk.
        $array                  = is_array($array) ? $array : array();
        $this->artistModelParam = $array;

        return $this;
    }

    /**
    ***************************************************************************
    * Fungsi untuk membatasi jumlah data yang akan ditampilkan. Fungsi ini menggunakan
    * parameter "take" dan "skip" untuk mengambil dan melewati jumlah data.
    *
    * @param    integer   $take
    * @param    integer   $skip
    * @return   $this
    *
    */
    public function Range($take, $skip = 0)
    {
        $take                   = is_int($take) ? $take : (preg_match('/[0-9]*/',
            $take) ? $take : 0);
        $skip                   = is_int($skip) ? $skip : (preg_match('/[0-9]*/',
            $skip) ? $skip : 0);
        $this->artistModelRange = $this->dbProperties->rangeProperty($take, $skip);

        return $this;
    }

    /**
    ***************************************************************************
    * Fungsi untuk menampilkan dan mendapatkan semua data yang sebelumnya di seleksi.
    * Jika Anda memutuskan untuk menyeleksi data sebelum ditampilkan, maka Anda wajib
    * memanggil fungsi ini di akhir penyeleksian.
    *
    * Contoh: $model->Select('exampleName')->Clause("WHERE user='Linus Torvald'")->Result();
    *
    * @return   array
    *
    */
    public function Result()
    {
        // Disini akan memanggil fungsi 'All()' untuk menampilkan data
        // yang diminta.
        $result = $this->All();

        // Nilai-nilai dari variabel 'Artist Model' yang telah berubah akan
        // dikembalikan ke nilai defaultnya.
        $this->artistModelSelect = $this->artistModelSelectDef;
        $this->artistModelClause = $this->artistModelClauseDef;
        $this->artistModelParam  = $this->artistModelParamDef;
        $this->artistModelRange  = $this->artistModelRangeDef;

        return $result;
    }

    // Sedang dalam proses
    /**
    ***************************************************************************
    *
    * @param    array   $tableName
    * @param    array   $index
    * @return   array
    *
    */
    // public function Relation($tableName, $index)
    // {
    //     try
    //     {
    //         if(((!is_array($tableName) AND !is_array($index)) AND (empty($tableName) AND
    //              empty($index))) OR (count($tableName) + 1) != count($index))
    //         {
    //             Throw new DragonHandler("Parameter dari fungsi 'Relation()' salah. Silahkan periksa kembali.");
    //         }
    //
    //         $clause = NULL;
    //         $select = '_R_ALL';
    //         $model  = explode('\\', get_called_class());
    //         $model  = end($model);
    //
    //         array_unshift($tableName, $model);
    //
    //         $tableNameArray = $tableName;
    //         $tableName      = implode(', ', $tableName);
    //
    //         for($i = 0; $i < count($index); $i++)
    //         {
    //             $clause .= $tableNameArray[$i] . "__$i@WITH__" . $index[$i] . ', ';
    //         }
    //
    //         // Di sini adalah proses untuk meminta data ke Database berdasarkan data
    //         // yang ada.
    //         $prepare = $this->dbProperties->selectProperty($select, $tableName, $clause);
    //     }
    //     catch(DragonHandler $e)
    //     {
    //         $debugConfig = require($this->getPath()['config'] . '/debug.php');
    //
    //         if($debugConfig['display_errors'] == TRUE)
    //         {
    //             die($e->getError());
    //         }
    //     }
    // }

    /**
    ***************************************************************************
    * Fungsi untuk menutup koneksi Database.
    *
    * @return   mixed
    *
    */
    public function Die()
    {
        $this->dbConnect = NULL;
    }
}
