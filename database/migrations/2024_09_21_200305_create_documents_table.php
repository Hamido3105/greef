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
        Schema::create('documents', function (Blueprint $table) {
            $table->string('custom_id')->primary(); // Custom ID (e.g., 2024/001)
            $table->date('date');
            $table->string('subject');
            $table->string('sender'); // المرسل اليه
            $table->string('addresse'); // العنوان
            $table->string('person_name_position')->nullable(); // انتقال
            $table->text('notes')->nullable();  // ملاحظات
            $table->string('document_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
