<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 08.05.2018
 * Time: 12:24
 */

namespace MyLibrary\Search;


use DB;
use Schema;

class Search
{
    protected $table;
    protected $app;

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->app = app();
        $this->table = $this->app['config']->get('search.database', 'searched');
    }

    public function search($searchedText)
    {
        if ($this->tableIsExist()) {
            return json_encode(DB::select('SELECT * FROM ' . $this->table . ' WHERE LOWER(name) LIKE LOWER(\'%' . $searchedText . '%\') LIMIT 10'));
        }
        return response()->json([]);
    }


    protected function tableIsExist()
    {
        return Schema::hasTable($this->table);
    }
}