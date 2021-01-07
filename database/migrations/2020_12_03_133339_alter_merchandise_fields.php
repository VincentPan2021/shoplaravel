<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMerchandiseFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchandise', function (Blueprint $table) {
            //C:建立中，S:可販售
            $table->string('status', 1)->default('C');

            $table->string('name', 80)->nullable();

            $table->string('name_en', 80)->nullable();

            $table->text('introduction')->nullable();

            $table->text('introduction_en')->nullable();

            $table->string('photo', 50)->nullable();

            $table->integer('price')->default(0);

            $table->integer('remain_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchandise');
    }
}
