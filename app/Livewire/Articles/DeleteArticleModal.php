<?php

namespace App\Livewire\Articles;

use Livewire\Component;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DeleteArticleModal extends Component
{
    public Article $article; // Riceverà l'articolo dalla vista principale
    public bool $confirmingDeletion = false;

    public function deleteArticle()
    {
        // 1. Elimina l'articolo dal database
        if ($this->article->image_path) {
            Storage::disk('public')->delete($this->article->image_path);
        }

        if ($this->article->file_path) {
            Storage::disk('public')->delete($this->article->file_path);
        }
        
        // 3. Esegui la cancellazione in blocco tramite DB per evitare che Livewire si perda i pezzi
        DB::transaction(function () use ($articleId) {
            // Sgancia le relazioni direttamente dalle tabelle pivot usando l'ID
            DB::table('article_user')->where('article_id', $articleId)->delete();
            DB::table('article_research_area')->where('article_id', $articleId)->delete();
            
            // Elimina l'articolo direttamente con una query di pulizia
            DB::table('articles')->where('id', $articleId)->delete();
        });

        // 2. Chiude il modale (opzionale se fai il redirect)
        $this->confirmingDeletion = false;

        // 3. Ricarica la pagina per mostrare la lista aggiornata
        // (Se la pagina principale non è un componente Livewire, il redirect è il modo più semplice)
        // 4. Metodo nativo di Livewire 3 per un reindirizzamento pulito senza crash
        return redirect()->to('/articles');
    }

    public function render()
    {
        return view('livewire.articles.delete-article-modal');
    }
}