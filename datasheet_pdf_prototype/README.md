# RS PRO Datasheet PDF Prototype

## Avvio rapido su Windows

Doppio click su:

```bat
avvia_locale.bat
```

Lo script:

1. entra automaticamente nella cartella del progetto;
2. installa le dipendenze Composer se manca `vendor\autoload.php`;
3. avvia il server PHP locale su `http://localhost:8000`;
4. apre il browser sul datasheet demo `generate_pdf.php?id=1`.

La finestra del prompt deve restare aperta: se la chiudi, il server locale si ferma.

## Avvio manuale

```bat
cd C:\RS_PRO\datasheet_pdf_prototype
composer install --prefer-source
php -S localhost:8000
```

Poi apri:

```text
http://localhost:8000/generate_pdf.php?id=1
```

## Database

Il database previsto è `rspro`. Lo script completo è:

```text
sql\rspro_schema_definitivo.sql
```

## Versione v5

Questa versione mantiene la struttura stabile della v4 e rifinisce soprattutto:

- pagina 1: proporzioni, blocco features, immagine prodotto e testo approvazione;
- pagina 2: altezza e proporzioni delle sezioni tecniche;
- avvio locale: aggiunto `avvia_locale.bat`.
