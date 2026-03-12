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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_user_id')->nullable()->constrained('users')->onDelete('set null'); // punta all'id dell'amministratore che ha generato l'evento
            /* nullable()-> se il creatore dell'evento non viene eliminato,
            constrained('users')-> indica che l'id fa riferimento alla tabella "users"
            onDelete('setNull')-> quando l'amministratore che ha creato l'evento viene eliminato l'attributo diventa false
            */ 
            $table->string("title");
            $table->string('type'); 
            $table->text("content");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
