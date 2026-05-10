<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('warehouse_id')->nullable()->after('category_id')->constrained()->onDelete('set null');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('warehouse_id')->nullable()->after('user_id')->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('warehouse_id');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('warehouse_id');
        });

        Schema::dropIfExists('warehouses');
    }
};
