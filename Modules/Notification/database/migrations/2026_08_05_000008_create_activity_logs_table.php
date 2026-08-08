<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('tenant_id')->default(1);
                $table->string('module', 50)->default('System');
                $table->string('log_type', 50)->default('info');
                $table->string('action');
                $table->text('description')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->timestamps();
            });
        } elseif (!Schema::hasColumn('activity_logs', 'module')) {
            Schema::table('activity_logs', function (Blueprint $table) {
                $table->string('module', 50)->default('System')->after('tenant_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
