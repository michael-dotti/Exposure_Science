import './bootstrap';

// 1. Importa la versione "full" di Quill
import Quill from 'quill';

// 2. Importa il CSS del tema base ("snow")
import 'quill/dist/quill.snow.css';

// 3. Rendi Quill disponibile globalmente (per poterlo usare nei tag <script> di Blade)
window.Quill = Quill;

// 4. Importa Flowbite
import 'flowbite';