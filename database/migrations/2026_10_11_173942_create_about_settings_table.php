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
        Schema::create('about_settings', function (Blueprint $table) {
            $table->id();
            $table->string('badge_title')->nullable()->default('About');
            $table->string('heading_prefix')->nullable()->default("Our Techniques Crucial To Learn If You're Going");
            $table->string('heading_highlight')->nullable()->default('To Explore In Learning');
            $table->text('description_1')->nullable();
            $table->text('description_2')->nullable();
            $table->string('button_text')->nullable()->default('LEARN MORE');
            $table->string('button_link')->nullable()->default('/courses');
            $table->string('about_image')->nullable();

            // Stats / Counter Metrics
            $table->string('stat_projects_count')->nullable()->default('200');
            $table->string('stat_projects_label')->nullable()->default('Projects Finished');
            $table->string('stat_clients_count')->nullable()->default('199');
            $table->string('stat_clients_label')->nullable()->default('Satisfied Clients');
            $table->string('stat_students_count')->nullable()->default('150');
            $table->string('stat_students_label')->nullable()->default('Online Students');
            $table->string('stat_years_count')->nullable()->default('20');
            $table->string('stat_years_label')->nullable()->default('Years of Experience');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_settings');
    }
};
