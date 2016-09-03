<?php namespace mvc\controllers\universal;

/*
|--------------------------------------------------------------------------
| Universal SQL Generator (Optional)
|--------------------------------------------------------------------------
|
| Class ini akan membantu Anda untuk mendapatkan string query dari beberapa
| jenis koneksi Database. Secara umum, Janggelan hanya meggunakan sejumlah
| fungsi query yang bersifat tidak spesifik. Fungsi-fungsi query di Janggelan
| untuk seleksi data adalah Select(), Clause(), BindParam(), Range(), dan Result().
| Proses logika query dilakukan di dalam fungsi "Clause()", yang mana mungkin
| Anda harus memasukkan query sesuai dengan Database yang Anda gunakan, entah itu
| Mysql, Sqlite, dll. Jika Anda membangun aplikasi atau website yang mendukung
| koneksi Database secara universal, agar Anda bisa menghasilkan query yang
| bersifat universal ke dalam fungsi "Clause()", maka Anda bisa menggunakan
| fungsi-fungsi di dalam Class ini.
|
| Jika diperlukan, Anda bisa mengedit atau menambahkan script generator Anda
| sendiri sesuai kebutuhan.
|
*/
class SQLGenerator extends \system\parents\Controller
{
    /**
    * @author   Dali Kewara   <dalikewara@windowslive.com>
    */

    // Variable ini mengindikasikan jenis koneksi Database yang Anda gunakan
    // saat ini.
    private $connection;

    public function __construct()
    {
        // Mendapatkan nama koneksi
        $this->connection = Parent::GET_CONNECTION();
    }

    /**
    ***************************************************************************
    * WHERE
    *
    * $user->where('username', '=', 'linus');
    * output mysql: WHERE username='linus'
    *
    * @param    string           $column
    * @param    string           $operator
    * @param    string|integer   $value
    * @param    string           $type
    * @return   string
    */
    public function where($column, $value, $operator = '=', $type = 'WHERE')
    {
        $value = is_string($value) ? ((preg_match('/^[:]/', $value)) ? $value :
            "'" . $value . "'") : $value ;

        switch($this->connection)
        {
            default:
                return "{$type} {$column}{$operator}{$value} ";
                break;
        }
    }

    /**
    ***************************************************************************
    * SINGLE WHERE
    *
    * $user->singleWhere("username='linus' || city='surabaya' && status=1");
    * output mysql: WHERE username='linus' OR city='surabaya' AND status=1
    *
    * @param    string   $clause
    * @return   string
    */
    public function singleWhere($clause)
    {
        $clause = str_replace('&&', 'AND', str_replace('||', 'OR', $clause));

        switch($this->connection)
        {
            default:
                return "WHERE {$clause} ";
                break;
        }
    }

    /**
    ***************************************************************************
    * WHERE IN
    *
    * $user->whereIn('username', ['linus', 'stallman', 'gosling']);
    * output mysql: WHERE username IN ('linus', 'stallman', 'gosling')
    *
    * @param    string   $column
    * @param    array    $value
    * @return   string
    */
    public function whereIn($column, array $value)
    {
        if(empty($value))
        {
            return FALSE;
        }

        $value = implode(', ', array_map(function($a)
            {return is_string($a) ? ("'" . $a . "'") : (is_int($a) ?
            $a : FALSE);}, $value));

        switch($this->connection)
        {
            default:
                return "WHERE {$column} IN ({$value}) ";
                break;
        }
    }

    /**
    ***************************************************************************
    * ORDER BY
    *
    * $user->orderBy('id', 'DESC');
    * output mysql: ORDER BY id DESC
    *
    * @param    string   $order
    * @param    string   $by
    * @return   string
    */
    public function orderBy($by = 'id', $order = 'ASC')
    {
        switch($this->connection)
        {
            default:
                return "ORDER BY $by $order ";
                break;
        }
    }
}
