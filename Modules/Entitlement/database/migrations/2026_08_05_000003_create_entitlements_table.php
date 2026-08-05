<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('entitlements')) {
            Schema::create('entitlements', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('plan_id');
                $table->string('feature_key');
                $table->string('feature_name');
                $table->integer('limit_value')->default(0);
                $table->string('unit', 50)->default('Count');
                $table->boolean('is_unlimited')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('entitlements');
    }
};
