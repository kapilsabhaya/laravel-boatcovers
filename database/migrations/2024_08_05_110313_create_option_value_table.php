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
        Schema::create('option_value', function (Blueprint $table) {
            $table->id();
            $table->string('option_value',30);
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')->references('id')->on('option')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_default')->default(true);
            $table->unsignedInteger('sort_order');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_value');
    }
};
