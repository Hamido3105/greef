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
            $table->string('subject');
            $table->date('date');
            $table->string('sender');
            $table->string('addressed_to');
            $table->string('transferred_to')->nullable();
            $table->integer('attached_documents_count')->nullable();
            $table->string('person_name_position')->nullable();
            $table->text('notes')->nullable();
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
