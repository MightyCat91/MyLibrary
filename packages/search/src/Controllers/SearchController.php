<?php
/**
 * Created by PhpStorm.
 * User: MUZHILKIN
 * Date: 04.05.2018
 * Time: 11:25
 */

namespace MyLibrary\Search;


use App\Http\Controllers\Controller;
use DB;
use Schema;

class SearchController extends Controller
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
        dd($searchedText);
        if ($this->tableIsExist()) {
            $collectionSerchedElem = DB::raw('SELECT * FROM ' . $this->table . ' WHERE to_tsvector(name) @@ plainto_tsquery(\'' . $searchedText . '\') LIMIT 10');

        }
    }


    protected function tableIsExist()
    {
        return Schema::hasTable($this->table);
    }
}