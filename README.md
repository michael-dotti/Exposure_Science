# EXPOSURE SCIENCE

## Introduzione 
Questa è un'applicazione web per la gestione e la promozione di un gruppo di ricerca universitario. Si divide in una parte pubblica, accessibile a tutti, e una parte privata, riservata agli utenti autenticati. 


### 1. Parte pubblica: 
È la vetrina del gruppo di ricerca e può essere consultata da chiunque, senza necessità di autenticazione. L'obiettivo è fornire una panoramica completa e trasparente sulle attività del gruppo. Gli utenti potranno visualizzare le seguenti informazioni:
- **Descrizione del gruppo:** una panoramica sulle aree di ricerca, la missione e gli obiettivi del gruppo. 
- **Membri del gruppo:** un elenco completo dei componenti, con i rispettivi ruoli, biografie, corsi insegnati e contatti. 
- **Pubblicazioni:** una pagina dedicata alla ricerca e alla consultazione delle pubblicazioni scientifiche del gruppo, con filtri e strumenti di ricerca. 
- **Progetti:** una sezione che elenca i progetti di ricerca, suddivisi per stato (attivi, conclusi e futuri). 
- **Novità ed eventi:** una bacheca aggiornata con seminari, articoli appena pubblicati, comunicazioni di servizio e altri eventi rilevanti.



### 2. Parte privata: 
Sezione del sito nascosta agli utenti che non hanno eseguito l’accesso, utilizzata per la modifica dei contenuti del sito. Le azioni che l’utente registrato può compiere dipendono dal ruolo a lui assegnato nel gruppo di ricerca:
- **Ricercatore:** può pubblicare nuovi articoli, modificare quelli a cui ha partecipato e aggiornare la propria pagina personale con biografia e informazioni di contatto.
- **Amministratore:** eredita tutti i permessi del ricercatore, può aggiungere, rimuovere e modificare i membri del gruppo, pubblicare e modificare articoli senza limiti di partecipazione, gestire pagine personali dei membri e gestire bacheca informazioni.
	

### 3. Tecnologie utilizzate:
- **Front-end:** HTML, Tailwind, JavaScript;
- **Back-end:** Laravel (con Jetstream per l'autenticazione e Spatie per la gestione dei ruoli ), php, mySQL.


## Requisiti di sistema
- **PHP >= 8.2** con le seguenti estensioni abilitate: `fileinfo`, `gd` (o `imagick`), `mbstring`, `openssl`, `pdo`, `bcmath`, `xml`.
- **Limiti PHP consigliati** (nel `php.ini`) per la gestione dei file:
  - `post_max_size = 256M`
  - `upload_max_filesize = 256M`
  - `memory_limit = 512M`
- Composer
- Node.js & NPM
- MariaDB 


## Istruzioni per l'installazione
1. **Clona il repository:**
```bash
git clone <URL_DEL_TUO_REPOSITORY>
cd nome-cartella-progetto
```

2. **Installa le dipendenze PHP**
```bash
composer install
```

3. **Configura l'ambiente**
- duplica il file **`.env.example`** e rinominalo in **`.env`**.
- Genera la chiave dell'applicazione:
```bash
php artisan key:generate 
```

4. **Configura il Database**
- Crea un database locale vuoto chiamato **`exposure_science`**.
- Verifica che i parametri di connessione nel file **`.env`** (**`DB_USERNAME`** e **`DB_PASSWORD`**) corrispondano al tuo ambiente locale.

5. **Esegui le migrazioni del database e carica i dati di default:**
```bash
php artisan migrate --seed
```

6. **Installa le dipendenze Frontend:**
```bash
npm install
```

7. **Avvia l'applicazione**
Tieni aperti due terminali separati:
- Terminale 1 (Compilatore Asset Vite):
```bash
npm run dev
```
- Terminale 2 (Server Locale Laravel):
```bash
php artisan serve
```

8. **Accedi All'applicazione**
Apri il browser all'indirizzo **`http://127.0.0.1:8000`**

