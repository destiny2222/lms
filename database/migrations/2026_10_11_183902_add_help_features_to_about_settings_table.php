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
        Schema::table('about_settings', function (Blueprint $table) {
            $table->string('help_title')->nullable()->default('How Can We');
            $table->string('help_title_highlight')->nullable()->default('Help');
            $table->string('help_title_suffix')->nullable()->default('You');

            $table->string('feature_1_title')->nullable()->default('Scriptural Foundation');
            $table->text('feature_1_desc')->nullable();

            $table->string('feature_2_title')->nullable()->default('Spiritual Maturity');
            $table->text('feature_2_desc')->nullable();

            $table->string('feature_3_title')->nullable()->default('Kingdom Leadership');
            $table->text('feature_3_desc')->nullable();

            $table->string('feature_4_title')->nullable()->default('Lifelong Discipleship');
            $table->text('feature_4_desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_settings', function (Blueprint $table) {
            $table->dropColumn([
                'help_title',
                'help_title_highlight',
                'help_title_suffix',
                'feature_1_title',
                'feature_1_desc',
                'feature_2_title',
                'feature_2_desc',
                'feature_3_title',
                'feature_3_desc',
                'feature_4_title',
                'feature_4_desc',
            ]);
        });
    }
};
