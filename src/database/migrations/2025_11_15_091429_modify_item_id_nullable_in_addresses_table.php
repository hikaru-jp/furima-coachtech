<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'item_id')) {
                try {
                    $table->dropForeign(['item_id']);
                } catch (\Exception $e) {
                }

                $table->dropColumn('item_id');
            }
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'item_id')) {
                $table->dropColumn('item_id');
            }
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id');
        });
    }
};
