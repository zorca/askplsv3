<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('tenant_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('topic_name')->nullable();
            $table->string('type')->default('private');
            $table->integer('url')->unique();
            $table->text('details')->nullable(); 
            $table->string('tags')->nullable();
            $table->boolean('sitedisplay')->default(true);
            $table->boolean('reviewdisplay')->default(true);
            $table->boolean('frontdisplay')->default(false);
            $table->boolean('status')->default(true);  
            $table->datetime('displayuptil')->nullable();          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
