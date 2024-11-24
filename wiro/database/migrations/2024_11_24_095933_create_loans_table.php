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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrower_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('loan_plan_id')->nullable()->constrained()->onDelete('set null'); 
            $table->foreignId('loan_type_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
