<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('code')->nullable()->unique()->after('id');
        });

        Schema::table('warehouses', function (Blueprint $table) {
            $table->string('code')->nullable()->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
