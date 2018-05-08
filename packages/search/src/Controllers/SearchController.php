<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 08.05.2018
 * Time: 12:35
 */

class SearchController
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
        \Debugbar::info($searchedText);
        \Debugbar::info($this->table);
        if ($this->tableIsExist()) {

            $collectionSerchedElem = DB::raw('SELECT * FROM ' . $this->table . ' WHERE to_tsvector(name) @@ plainto_tsquery(\'' . $searchedText . '\') LIMIT 10');

        }
    }


    protected function tableIsExist()
    {
        return Schema::hasTable($this->table);
    }
}