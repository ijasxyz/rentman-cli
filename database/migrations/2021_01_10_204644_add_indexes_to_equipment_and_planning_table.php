<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToEquipmentAndPlanningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->index('stock');
        });

        Schema::table('planning', function (Blueprint $table) {
            $table->index('equipment');
            $table->index('quantity');
            $table->index(['start', 'end']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropIndex(['stock']);
        });

        Schema::table('planning', function (Blueprint $table) {
            $table->dropIndex(['equipment']);
            $table->dropIndex(['quantity']);
            $table->dropIndex(['start', 'end']);
        });
    }
}
