# Forum Maintenance Mode

Estensione phpBB 3.3 che sostituisce il forum con una pagina di manutenzione a schermo intero,
configurabile dall'ACP.

*Read this in [English](README.en.md).*

| | |
|---|---|
| **Autore** | Salvo Cortesiano |
| **Copyright** | (c) 2026-08-11 20:00 CEST Salvo Cortesiano |
| **Forum** | https://netshadows.de/ombra/ |
| **Licenza** | GNU General Public License, version 2 (GPL-2.0) |
| **Versione** | 1.4.0 |

## Installazione

1. Copia la cartella `salvocortesiano/maintenance` in `ext/` del tuo forum:
   `forum/ext/salvocortesiano/maintenance/`
2. ACP → **Personalizza** → **Gestisci estensioni** → **Abilita** su *Forum Maintenance Mode*.
3. ACP → **Estensioni** → **Modalità manutenzione** → *Gestione modalità manutenzione*.

Requisiti: phpBB 3.3.0+ e PHP 7.1.3+.

## Cosa puoi configurare

Il nome mostrato in cima alla pagina e nel titolo del browser è il **Nome board** che imposti in
ACP → Generale → Impostazioni board: l'estensione lo legge da lì, non va riscritto qui.
Se non imposti un logo, il badge accanto al nome mostra le sue iniziali.

| Sezione | Contenuto |
|---|---|
| Stato attuale | stato, stato del forum phpBB, ora di inizio, durata stimata, attiva/disattiva, anteprima |
| Modalità | radio **Abilitata / Disabilitata**, disattivazione del forum phpBB, pagina visibile agli admin, programmazione, spegnimento automatico |
| Periodo | data e ora di **inizio** e di **fine** (calendario nativo del browser), scorciatoie |
| Opzioni pagina | ingranaggio, rotazione ingranaggio, particelle, conto alla rovescia, card inizio/fine, barra di progresso, selettore IT/EN, pulsante admin, refresh, logo |
| Palette colori | sfumatura sfondo, barra superiore, accento, testo, testo secondario, riquadri, sfumatura del riquadro countdown, barra di progresso, pulsante di ripristino |
| Contatti | email e telefono mostrati nel riquadro |
| Messaggi IT / EN | titolo, sottotitolo, descrizione, frase di chiusura per ogni lingua |
| Log attivazioni | ultima attivazione, ultima disattivazione, totale attivazioni |

## Il riquadro countdown

Compare quando la manutenzione ha una **data di fine** e il conto alla rovescia è attivo. Contiene:

- **Tempo Rimanente** in formato compatto: `5m 35s`, `2h 14m 08s`, `3g 05h 20m`
- **Inizio Manutenzione** e **Fine Stimata** con data e ora nel fuso di chi guarda
- **Progresso Manutenzione**, la barra che si riempie da inizio a fine (serve anche la data di inizio)

Il conto alla rovescia parte dall'orario del server, quindi resta corretto anche se il visitatore
ha l'orologio del computer sbagliato. A zero il visitatore viene riportato all'indice del forum:
se hai attivato lo spegnimento automatico, a quel punto il forum è già di nuovo online.

## Palette colori

Ogni colore ha il suo campione cliccabile. I tre campi che accettano la trasparenza — le due
sfumature del riquadro countdown e lo sfondo dei riquadri — hanno anche un cursore **Opacità**:
il campione sceglie il colore, il cursore la trasparenza, e il campo di testo si ricompone nel
formato esadecimale a 8 cifre. Il pulsante **Colori predefiniti** riporta tutti gli undici campi
ai valori originari; ricordati di salvare per applicare.

## Sincronia con "Disabilita forum" di phpBB

L'opzione **Disattiva anche il forum di phpBB** (attiva di serie) mette a *Sì* la voce
*Disabilita forum* in ACP → Generale → Impostazioni board mentre la manutenzione è in corso, e la
riporta al valore precedente quando finisce. Doppia protezione: se per qualsiasi motivo
l'estensione non intercettasse una pagina, interviene il blocco nativo di phpBB.

## Accesso durante la manutenzione

- Gli amministratori (`a_`) e i fondatori vedono sempre il forum. Per questo, se provi da loggato
  come founder, vedi la home normale: è il comportamento voluto, non un errore. Per controllare
  il risultato usa l'anteprima, una finestra anonima, oppure attiva **Mostra la pagina anche agli
  amministratori**.
- Il permesso utente **Può navigare il forum durante la manutenzione** (`u_agm_bypass`)
  permette di autorizzare altri gruppi, ad esempio i moderatori globali.
- `ucp.php?mode=login` resta raggiungibile, così puoi accedere e poi entrare nell'ACP.
- La pagina risponde con **HTTP 503** e `Retry-After`, il comportamento corretto per i motori di ricerca.

## Il pulsante del pannello admin

phpBB rifiuta con un errore 401 chi apre `adm/index.php` senza l'identificativo di sessione: è
il motivo per cui non si entra nell'ACP digitando l'URL a mano. Il pulsante della pagina di
manutenzione lo include, esattamente come il collegamento in fondo alle pagine del forum. Chi non
ha ancora effettuato l'accesso viene invece portato al modulo di login.

## Responsive

Il layout è a colonna singola e fluido. Sotto i 600 px le due card inizio/fine si impilano,
i contatti vanno in verticale, tipografia e ingranaggio si riducono e la barra in alto si accorcia
troncando il nome del forum invece di andare a capo. Titoli e tempo rimanente usano `clamp()`,
quindi scalano con la larghezza dello schermo senza salti.

## Anteprima

Due modi, entrambi riservati agli amministratori:

- **Anteprima in una nuova scheda** → apre `app.php/maintenance/preview`
- **Anteprima qui** → mostra la pagina in un iframe dentro l'ACP

L'anteprima funziona anche a manutenzione disattivata.

## Note per chi mette mano al codice

Il layout della pagina sta in `styles/all/template/maintenance_page.html`. Per modificarlo senza
toccare l'estensione, copia il file in
`styles/<tuo_stile>/template/ext/salvocortesiano/maintenance/maintenance_page.html`.

Attenzione a una trappola di phpBB: il suo lexer riscrive le graffe nei template, quindi una
quantità come `{6}` dentro un'espressione regolare JavaScript viene trasformata e smette di
funzionare. Nel codice di questa estensione i colori sono infatti interpretati carattere per
carattere, senza espressioni regolari.

## Disinstallazione

ACP → Gestisci estensioni → *Disabilita* (mantiene i dati) oppure *Elimina i dati*
(rimuove configurazione, modulo ACP e permesso).

## Licenza

GNU General Public License, version 2 (GPL-2.0)

Copyright (c) 2026-08-11 20:00 CEST Salvo Cortesiano — https://netshadows.de/ombra/
