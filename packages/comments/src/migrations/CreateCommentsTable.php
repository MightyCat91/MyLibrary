<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 06.06.2018
 * Time: 11:03
 */

namespace MyLibrary\Comments;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    protected $app;
    protected $usersTable;
    protected $commentableTables;

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->app = app();
        $this->usersTable = config('comments.users', 'users');
        $this->commentableTables = config('comments.commentable');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references("id")->on($this->usersTable)
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('com_id')->unsigned();
            $table->integer('parent_id')->nullable();
            $table->enum('com_table', $this->commentableTables);
            $table->enum('depth', [0, 1, 2, 3])->default(0);
//            foreach ($this->commentableTables as $key => $table) {
//                $table->integer($table . '_id')->unsigned();
//                $table->foreign($table . '_id')
//                    ->references("id")->on($this->commentableTables)
//                    ->onUpdate('cascade')->onDelete('cascade');
//            }
            $table->string('text', 1024);
            $table->smallInteger('rating')->nullable();

            $table->boolean('approved')->default(false);
            $table->datetime('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}