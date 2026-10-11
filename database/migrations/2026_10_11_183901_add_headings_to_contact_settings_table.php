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
        Schema::table('contact_settings', function (Blueprint $table) {
            $table->string('section_title')->nullable()->default('For More Information Get In');
            $table->string('section_title_highlight')->nullable()->default('Touch With RACAi Discipleship');
            $table->string('form_title')->nullable()->default('Leave A Message');
            $table->string('form_subtitle')->nullable()->default('Your email address will not be published. Required fields are marked *');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            $table->dropColumn([
                'section_title',
                'section_title_highlight',
                'form_title',
                'form_subtitle',
            ]);
        });
    }
};
