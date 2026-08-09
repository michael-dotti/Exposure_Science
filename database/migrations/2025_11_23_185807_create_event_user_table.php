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
        Schema::create('event_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unique(['event_id','user_id']);
            $table->timestamp('deleted_at')->nullable(); 
            /* la colonna "deleted_at" è "un'etichetta" che salva informazioni
            che riguardano il legame tra le due tabelle (users e events) nella loro
            tabella pivot.

            quando un utente clicca su "elimina" evento ( a meno che
            non sia un admin o un responsabile di eventi) non lo elimina davvero
            né rimuove il legame che ha con esso, ma segnamo nella
            colonna "deleted_at" la data in cui l'utente ha premuto elimina. 
            L'admin potrà ancora vedere i destinatari dell'evento, ma l'utente che lo
            ha eliminato per se, grazie al controllo che facciamo nel controller sulal
            colonna deleted_at, non vede l'evento nella sua pagina
            Questo è il "soft Delete" (o Eliminazione logica)
            */ 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_user');
    }
};
