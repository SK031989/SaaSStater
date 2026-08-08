<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('notification_templates')) {
            Schema::create('notification_templates', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique(); // e.g. welcome_email, subscription_renewal, invoice_paid
                $table->string('title');
                $table->string('subject');
                $table->text('body');
                $table->string('channel', 50)->default('email'); // email, in_app, sms, push
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
