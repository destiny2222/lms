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
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('direction', ['outbound', 'inbound'])->default('outbound');
            $table->string('phone_number');
            $table->string('message_type')->default('text'); // text, template, interactive
            $table->text('message_body');
            $table->string('meta_message_id')->nullable();
            $table->string('trigger_type')->default('reminder'); // reminder_unstarted, reminder_incomplete, deadline_alert, congratulation, bulk_announcement, bot_reply, user_message
            $table->string('status')->default('sent'); // queued, sent, delivered, read, failed
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['phone_number', 'direction']);
            $table->index('trigger_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_messages');
    }
};
