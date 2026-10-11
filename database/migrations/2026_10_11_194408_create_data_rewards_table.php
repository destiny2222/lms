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
        Schema::create('data_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('milestone_count')->default(10);
            $table->string('reward_title')->default('1 Month Free Data Subscription');
            $table->string('phone_number')->nullable();
            $table->string('network_provider')->nullable();
            $table->string('status')->default('unlocked'); // unlocked, claimed, fulfilled
            $table->timestamp('unlocked_at')->useCurrent();
            $table->timestamp('claimed_at')->nullable();
            $table->timestamp('fulfilled_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'milestone_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_rewards');
    }
};
