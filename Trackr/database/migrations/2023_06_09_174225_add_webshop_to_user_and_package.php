<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('webshop_id')->nullable();
            $table->foreign('webshop_id')->references('id')->on('webshops')->onDelete('cascade');
        });
        Schema::table('packages', function (Blueprint $table) {
            $table->unsignedBigInteger('webshop_id')->nullable();
            $table->foreign('webshop_id')->references('id')->on('webshops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['webshop_id']);
            $table->dropColumn('webshop_id');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropForeign(['webshop_id']);
            $table->dropColumn('webshop_id');
        });
    }
};
