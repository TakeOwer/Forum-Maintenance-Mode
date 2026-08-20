<?php
/**
 * Forum Maintenance Mode - phpBB extension
 *
 * @author     Salvo Cortesiano
 * @copyright  (c) 2026-08-11 20:00 CEST Salvo Cortesiano
 * @link       https://netshadows.de/ombra/
 * @license    GNU General Public License, version 2 (GPL-2.0)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_AGM_SETTINGS_EXPLAIN'	=> 'Con la manutenzione attiva i visitatori vedono una pagina a schermo intero al posto del forum. Gli amministratori mantengono l\'accesso completo.',

	'AGM_CURRENT_STATUS'		=> 'Stato attuale',
	'AGM_STATUS'				=> 'Stato',
	'AGM_STATUS_ACTIVE'			=> 'Attiva',
	'AGM_STATUS_INACTIVE'		=> 'Disattiva',
	'AGM_STATUS_WAITING'		=> 'Manutenzione abilitata ma non ancora in corso: la programmazione la fa partire alla data di inizio. I visitatori vedono il forum normale.',
	'AGM_STATUS_SHOWING'		=> 'I visitatori stanno vedendo la pagina di manutenzione.',
	'AGM_START_TIME'			=> 'Ora di inizio',
	'AGM_ESTIMATED_DURATION'	=> 'Durata stimata',
	'AGM_NOT_AVAILABLE'			=> 'Non disponibile',
	'AGM_TURN_ON'				=> 'Attiva manutenzione',
	'AGM_TURN_OFF'				=> 'Disattiva manutenzione',
	'AGM_PREVIEW'				=> 'Anteprima in una nuova scheda',
	'AGM_PREVIEW_INLINE'		=> 'Anteprima qui',

	'AGM_REOPEN_BOARD'			=> 'Riapri subito il forum',
	'AGM_BOARD_REOPENED'		=> 'Il forum è stato riaperto.',
	'AGM_BOARD_STUCK_WARN'		=> 'Attenzione: la manutenzione non è in corso, ma il forum risulta disabilitato in Generale → Impostazioni board. I visitatori vedono il messaggio standard di phpBB al posto della pagina di manutenzione. Usa il pulsante "Riapri subito il forum" per rimetterlo online.',
	'AGM_PAGE_CHECK'			=> 'Cosa mostrerà la pagina',
	'AGM_PAGE_CHECK_EXPLAIN'	=> 'Ogni blocco compare solo se la sua condizione è soddisfatta. Le voci in rosso non appariranno, né nell\'anteprima né ai visitatori.',
	'AGM_CHECK_COUNTDOWN'		=> 'Conto alla rovescia: serve la spunta e una data di fine',
	'AGM_CHECK_DATES'			=> 'Card inizio e fine: serve la spunta e almeno una delle due date',
	'AGM_CHECK_PROGRESS'		=> 'Barra di progresso: serve la spunta ed entrambe le date, con la fine dopo l\'inizio',
	'AGM_CHECK_CONTACT'			=> 'Riquadro contatti: serve almeno una fra email e telefono',
	'AGM_ADMIN_BANNER'			=> 'Manutenzione ATTIVA: gli utenti stanno vedendo la pagina di manutenzione. Tu vedi il forum normale perché sei amministratore. Per vederla come la vedono loro apri il forum in una finestra anonima, oppure attiva "Mostra la pagina anche agli amministratori" nel pannello.',
	'AGM_MODE'					=> 'Modalità manutenzione',
	'AGM_ENABLED'				=> 'Manutenzione',
	'AGM_ENABLED_EXPLAIN'		=> 'Attiva o disattiva la pagina di manutenzione.',
	'AGM_ENABLED_ON'			=> 'Abilitata',
	'AGM_ENABLED_OFF'			=> 'Disabilitata',
	'AGM_USE_SCHEDULE'			=> 'Usa la programmazione',
	'AGM_USE_SCHEDULE_EXPLAIN'	=> 'Se selezionata, la pagina compare solo tra la data di inizio e quella di fine.',
	'AGM_AUTO_OFF'				=> 'Disattiva automaticamente alla data di fine',
	'AGM_AUTO_OFF_EXPLAIN'		=> 'Spegne la manutenzione alla prima visita dopo la data di fine.',

	'AGM_SYNC_BOARD'			=> 'Disattiva anche il forum di phpBB',
	'AGM_SYNC_BOARD_EXPLAIN'	=> 'Mette a "Sì" la voce Disabilita forum in Generale → Impostazioni board quando attivi la manutenzione, e la riporta com\'era quando la disattivi.',
	'AGM_SHOW_TO_ADMINS'		=> 'Mostra la pagina anche agli amministratori',
	'AGM_SHOW_TO_ADMINS_EXPLAIN' => 'Utile per verificare il risultato senza sloggarti. Il pannello ACP resta sempre raggiungibile.',
	'AGM_BOARD_DISABLE_STATE'	=> 'Forum phpBB',
	'AGM_BOARD_OFF'				=> 'Disabilitato',
	'AGM_BOARD_ON'				=> 'Abilitato',

	'AGM_NOTICE'				=> 'Abilitare messaggio visivo a tutti gli utenti?',
	'AGM_NOTICE_EXPLAIN'		=> 'Mostra un avviso in cima a tutte le pagine del forum prima che la manutenzione inizi. Richiede la programmazione con data di inizio e di fine.',
	'AGM_NOTICE_DAYS'			=> 'Giorni di anticipo',
	'AGM_NOTICE_DAYS_EXPLAIN'	=> 'Mostra l\'avviso solo entro questi giorni dall\'inizio. Usa 0 per mostrarlo sempre.',
	'AGM_NOTICE_DAYS_UNIT'		=> 'giorni (0 = sempre)',
	'AGM_NOTICE_NOW'			=> 'Avviso attualmente visibile',
	'AGM_NOTICE_NOW_EXPLAIN'	=> 'È esattamente il testo che gli utenti stanno vedendo adesso sul forum.',
	'AGM_M_NOTICE'				=> 'Testo dell\'avviso preventivo',
	'AGM_M_NOTICE_EXPLAIN'		=> 'Segnaposto disponibili: {START} data e ora di inizio, {END} data e ora di fine, {SITENAME} nome del forum.',

	'AGM_PERIOD'				=> 'Periodo di manutenzione',
	'AGM_DATE_START'			=> 'Data e ora di inizio',
	'AGM_DATE_START_EXPLAIN'	=> 'Usa il fuso orario del tuo account. Lascia vuoto per non impostare un inizio.',
	'AGM_DATE_END'				=> 'Data e ora di fine',
	'AGM_DATE_END_EXPLAIN'		=> 'È anche il traguardo del conto alla rovescia. Lascia vuoto per non impostare una fine.',
	'AGM_TOOLS'					=> 'Scorciatoie',
	'AGM_SET_NOW'				=> 'Imposta ora attuale',
	'AGM_PLUS_ONE_HOUR'			=> 'Fine = inizio + 1 ora',
	'AGM_CLEAR_DATES'			=> 'Cancella date',

	'AGM_APPEARANCE'			=> 'Opzioni della pagina',
	'AGM_SHOW_GEAR'				=> 'Mostra la rotellina ingranaggio',
	'AGM_SHOW_GEAR_EXPLAIN'		=> 'Compare sopra al titolo.',
	'AGM_SPIN_GEAR'				=> 'Fai ruotare l\'ingranaggio',
	'AGM_SPIN_GEAR_EXPLAIN'		=> 'Ignorato per chi ha richiesto animazioni ridotte.',
	'AGM_PARTICLES'				=> 'Caduta e movimento delle particelle',
	'AGM_PARTICLES_EXPLAIN'		=> 'Puntini animati che scendono sullo sfondo.',
	'AGM_PARTICLE_STYLE'	=> 'Effetto dello sfondo',
	'AGM_PARTICLE_STYLE_EXPLAIN'	=> 'Con le particelle attive, decidi cosa disegnare: fiocchi che scendono, stelle che luccicano, o entrambi.',
	'AGM_PARTICLE_SNOW'	=> 'Fiocchi che scendono',
	'AGM_PARTICLE_STARS'	=> 'Stelle che luccicano',
	'AGM_PARTICLE_BOTH'	=> 'Fiocchi e stelle',
	'AGM_COUNTDOWN'				=> 'Mostra il conto alla rovescia',
	'AGM_COUNTDOWN_EXPLAIN'		=> 'Conta verso la data di fine. Serve una data di fine per vederlo.',
	'AGM_LANG_SWITCHER'			=> 'Mostra il selettore delle lingue',
	'AGM_LANG_SWITCHER_EXPLAIN'	=> 'Mostra in alto un pulsante per ognuna delle 18 lingue, così il visitatore legge la pagina nella sua.',
	'AGM_ADMIN_LINK'			=> 'Mostra il pulsante del pannello admin',
	'AGM_ADMIN_LINK_EXPLAIN'	=> 'Aggiunge il collegamento all\'ACP in fondo alla pagina.',
	'AGM_DEFAULT_LANG'			=> 'Lingua predefinita',
	'AGM_DEFAULT_LANG_EXPLAIN'	=> 'Usata quando la lingua del visitatore non è fra quelle disponibili.',
	'AGM_REFRESH'				=> 'Aggiornamento automatico',
	'AGM_REFRESH_EXPLAIN'		=> 'Ricarica la pagina a questo intervallo. Usa 0 per disattivarlo.',
	'AGM_SECONDS'				=> 'secondi',
	'AGM_LOGO_URL'				=> 'URL del logo',
	'AGM_LOGO_URL_EXPLAIN'		=> 'Facoltativo. Se vuoto vengono mostrate le iniziali del nome del forum.',

	'AGM_SHOW_DATES'			=> 'Mostra inizio e fine nel riquadro',
	'AGM_SHOW_DATES_EXPLAIN'	=> 'Le due card "Inizio Manutenzione" e "Fine Stimata" sotto al tempo rimanente.',
	'AGM_PROGRESS_BAR'			=> 'Mostra la barra di progresso',
	'AGM_PROGRESS_BAR_EXPLAIN'	=> 'Si riempie da inizio a fine manutenzione. Servono entrambe le date.',
	'AGM_C_CD_FROM'				=> 'Riquadro countdown, inizio sfumatura',
	'AGM_C_CD_EXPLAIN'			=> 'Con esadecimale a 8 cifre puoi renderlo semitrasparente, es. #2b3f8fcc.',
	'AGM_C_CD_TO'				=> 'Riquadro countdown, fine sfumatura',
	'AGM_C_PROG_A'				=> 'Barra di progresso, colore iniziale',
	'AGM_C_PROG_B'				=> 'Barra di progresso, colore finale',

	'AGM_LOGO_UPLOAD'	=> 'Carica un logo',
	'AGM_LOGO_UPLOAD_EXPLAIN'	=> 'Scegli un file PNG o JPEG dal tuo computer: viene caricato in images/ e il campo qui sopra viene compilato da solo. Massimo 2 MB.',
	'AGM_LOGO_UPLOAD_BTN'	=> 'Carica',
	'AGM_LOGO_UPLOADED'	=> 'Il logo è stato caricato.',
	'AGM_ERR_UPLOAD_NONE'	=> 'Scegli prima un file da caricare.',
	'AGM_ERR_UPLOAD_TYPE'	=> 'Sono accettate solo immagini PNG o JPEG.',
	'AGM_ERR_UPLOAD_SIZE'	=> 'Il file è troppo grande: il limite è 2 MB.',
	'AGM_ERR_UPLOAD_DIR'	=> 'La cartella %s non esiste o non è scrivibile. Creala e dalle i permessi di scrittura.',
	'AGM_ERR_UPLOAD_MOVE'	=> 'Non è stato possibile salvare il file caricato nella cartella %s. Controlla i permessi di scrittura.',
	'AGM_LOGO_DELETE_BTN'	=> 'Elimina Immagine',
	'AGM_LOGO_DELETED'	=> 'Il logo è stato eliminato.',
	'AGM_LOGO_DELETE_CONFIRM'	=> 'Vuoi davvero eliminare il file %s dal server? L\'operazione non è reversibile.',
	'AGM_ERR_DELETE'	=> 'Non è stato possibile eliminare il file. Controlla i permessi, oppure rimuovilo via FTP.',
	'AGM_ERR_DELETE_NONE'	=> 'Non c\'è nessuna immagine da eliminare.',
	'AGM_PALETTE'				=> 'Palette colori',
	'AGM_C_BG_START'			=> 'Sfondo, inizio sfumatura',
	'AGM_C_BG_END'				=> 'Sfondo, fine sfumatura',
	'AGM_C_TOPBAR'				=> 'Barra superiore',
	'AGM_C_ACCENT'				=> 'Accento (pulsanti e link)',
	'AGM_C_TEXT'				=> 'Testo principale',
	'AGM_C_MUTED'				=> 'Testo secondario',
	'AGM_C_CARD'				=> 'Sfondo dei riquadri',
	'AGM_C_CARD_EXPLAIN'		=> 'Accetta esadecimali a 8 cifre per la trasparenza, es. #16255180.',

	'AGM_OPACITY'				=> 'Opacità',
	'AGM_RESET_COLORS'			=> 'Ripristina i colori',
	'AGM_RESET_COLORS_EXPLAIN'	=> 'Riporta tutti i campi della palette ai colori originari. Ricordati di salvare per applicare.',
	'AGM_RESET_COLORS_BTN'		=> 'Colori predefiniti',

	'AGM_CONTACTS'				=> 'Contatti',
	'AGM_CONTACT_EMAIL'			=> 'Email contatto',
	'AGM_CONTACT_PHONE'			=> 'Telefono contatto',

	'AGM_MESSAGES'				=> 'Messaggi della pagina',
	'AGM_MESSAGES_EXPLAIN'		=> 'I testi che il visitatore legge arrivano dai file di lingua dell\'estensione. Qui puoi sovrascriverli con parole tue, una lingua alla volta.',
	'AGM_EDIT_LANG'				=> 'Lingua da modificare',
	'AGM_EDIT_LANG_EXPLAIN'		=> 'Scegli la lingua e premi Carica per vederne i testi. I campi partono dalla traduzione del file di lingua: svuotane uno per tornare a quella di serie.',
	'AGM_LOAD_LANG'				=> 'Carica',
	'AGM_RESET_TEXTS_BTN'	=> 'Ripristina i testi di serie',
	'AGM_TEXTS_RESET'	=> 'I testi di questa lingua sono tornati a quelli del file di lingua.',
	'AGM_EDITING_NOW'	=> 'Stai modificando i testi di:',
	'AGM_M_TITLE'				=> 'Titolo',
	'AGM_M_SUBTITLE'			=> 'Sottotitolo',
	'AGM_M_DESCRIPTION'			=> 'Descrizione',
	'AGM_M_FOOTER'				=> 'Frase di chiusura',

	'AGM_LOG'					=> 'Log attivazioni',
	'AGM_LAST_ON'				=> 'Ultima attivazione',
	'AGM_LAST_OFF'				=> 'Ultima disattivazione',
	'AGM_TOTAL_ON'				=> 'Totale attivazioni',

	'AGM_SETTINGS_SAVED'		=> 'Impostazioni di manutenzione salvate.',
	'AGM_ACTIVATED'				=> 'La modalità manutenzione è ora attiva.',
	'AGM_DEACTIVATED'			=> 'La modalità manutenzione è ora disattiva.',
	'AGM_ERR_START'				=> 'La data di inizio non è una data e ora valida.',
	'AGM_ERR_END'				=> 'La data di fine non è una data e ora valida.',
	'AGM_ERR_RANGE'				=> 'La data di fine deve essere successiva a quella di inizio.',
	'AGM_ERR_EMAIL'				=> 'L\'indirizzo email di contatto non è valido.',

	'AGM_UNIT_DAYS'				=> 'g',
	'AGM_UNIT_HOURS'			=> 'h',
	'AGM_UNIT_MINUTES'			=> 'min',

	'ACL_U_AGM_BYPASS'			=> 'Può navigare il forum durante la manutenzione',
));
