<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePostComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_comments', function ($table) {
            $table->integer('parent_id')->unsigned()->default(0)->after('id');
            $table->integer('commentable_id')->unsigned();
            $table->string('commentable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_comments', function ($table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('commentable_id');
            $table->dropColumn('commentable_type');
        });
    }
}
