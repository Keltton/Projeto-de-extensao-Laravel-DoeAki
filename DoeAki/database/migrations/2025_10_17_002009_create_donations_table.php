<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('donations', function (Blueprint $table) {
        $table->id();
        $table->string('item_category');
        $table->integer('quantity')->default(1);
        $table->string('condition')->nullable();
        $table->string('donor_name');
        $table->string('donor_email')->nullable();
        $table->string('donor_phone')->nullable();
        $table->boolean('needs_pickup')->default(false);
        $table->text('pickup_address')->nullable();
        $table->text('notes')->nullable();
        $table->string('status')->default('pending');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
};
