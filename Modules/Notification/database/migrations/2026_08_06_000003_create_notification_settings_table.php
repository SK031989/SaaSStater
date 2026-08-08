<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('notification_settings')) {
            Schema::create('notification_settings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('tenant_id')->default(1);
                $table->unsignedBigInteger('user_id')->nullable();
                $table->boolean('email_notifications')->default(true);
                $table->boolean('system_notifications')->default(true);
                $table->boolean('billing_alerts')->default(true);
                $table->boolean('security_alerts')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
