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
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('nickname')->nullable()->after('name');
            $table->integer('age')->nullable()->after('nickname');
            $table->string('program')->nullable()->after('address');
            $table->decimal('nominal', 15, 2)->nullable()->after('program');
            $table->string('location')->nullable()->after('nominal');
            $table->string('schedule_day')->nullable()->after('location');
            $table->string('schedule_time')->nullable()->after('schedule_day');
            $table->string('source')->nullable()->after('schedule_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'nickname', 'age', 'program', 'nominal', 'location', 
                'schedule_day', 'schedule_time', 'source'
            ]);
        });
    }
};
