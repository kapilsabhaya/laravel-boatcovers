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
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_category_id')->nullable();
            $table->foreign('master_category_id')->references('id')->on('master_category')->onDelete('cascade')->onUpdate('cascade');
            $table->string('category_name',70);
            $table->string('sub_category_name',70)->nullable();
            $table->binary('image')->nullable();
            $table->string('slug',60)->unique();
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
        Schema::dropIfExists('category');
    }
};
