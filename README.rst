Name der Erweiterung: MlStonelexicon

Beschreibung:
Die MlStonelexicon-Erweiterung für TYPO3 bietet eine umfassende Lösung zur Verwaltung und Darstellung eines Naturstein-Lexikons. Die Erweiterung ermöglicht es, Informationen über verschiedene Steine (wie Hartgesteine, Marmor, Kalkstein, etc.) in einer strukturierten und benutzerfreundlichen Weise zu präsentieren. Die Besucher der Website können nach Steinen basierend auf verschiedenen Kriterien wie Farbe, Herkunft und Namen filtern und diese durchsuchen.

Zu den Hauptfunktionen gehören:

Kategorienbasierte Steineübersicht: Die Steine sind in verschiedene Kategorien wie Hartgesteine, Marmor, Sandstein usw. unterteilt. Jede Kategorie ist über eine SEO-freundliche URL erreichbar.

Erweiterte Filtermöglichkeiten: Benutzer können Steine nach Herkunft, Farbe und anderen Kriterien filtern. Die Filterung erfolgt AJAX-basiert, was ein schnelles und nahtloses Nutzererlebnis ermöglicht.

Pagination: Die Erweiterung unterstützt die Paginierung, um die Darstellung von großen Mengen an Einträgen zu ermöglichen, ohne die Ladezeiten zu beeinträchtigen.

Lazy Loading und Ladeanimation: Die Erweiterung unterstützt Lazy Loading und zeigt beim Laden der Daten eine Ladeanimation an, um die Benutzerfreundlichkeit zu verbessern.

SEO-Optimierte URLs: Die URLs für die Steine und Kategorien sind SEO-freundlich und basieren auf den Slugs der Seiten, was die Sichtbarkeit in Suchmaschinen erhöht.

Funktionen:

Unterstützung für den speziellen Seitentyp 169, der speziell für die Verwaltung und Darstellung von Natursteinseiten vorgesehen ist und eine gezielte Darstellung der Inhalte ermöglicht.

Verwaltung und Anzeige von Naturstein-Einträgen in verschiedenen Kategorien, basierend auf Daten aus der Tabelle pages.

AJAX-basierte Filterung nach Herkunft, Farbe und Suchwort mit Autovervollständigung ab den 2 Buchstaben der möglichen Ergebnisse.

SEO-optimierte, benutzerdefinierte URLs für jede Kategorie und jeden Stein.

Unterstützung von Lazy Loading und Ladeanimationen für eine verbesserte Benutzererfahrung.

Paginierung zur effizienten Verwaltung und Anzeige großer Datenmengen.

Es gibt einen speziellen Seitentyp 169, der für die Darstellung der Steinseiten verwendet wird. Dieser Seitentyp ermöglicht eine spezifische Verarbeitung und Darstellung der Natursteininhalte, die optimal auf das Lexikon abgestimmt sind.

Systemvoraussetzungen:

TYPO3 Version: 13.4

PHP Version: PHP 8.3.10

Datenbank: MySQL 8.0.25-15

Webserver: Apache 2.4+

Browser-Kompatibilität: Die Erweiterung funktioniert auf modernen Browsern wie Chrome, Firefox, Safari und Edge.

Zusätzliche Anforderungen:

Die TYPO3-Konfiguration sollte die Verwendung von cHash und URL-Rewriting unterstützen.

Die Slugs für die Kategorien müssen korrekt in der Datenbank gepflegt sein.

Installation und Konfiguration:

Installation: Die Erweiterung kann über den TYPO3 composer installiert werden.

Einrichtung: Konfiguriere den routeEnhancers in der config.yaml, um SEO-freundliche URLs zu ermöglichen.

ml_stonelexicon/
│
├── Classes/
│   ├── Controller/
│   │   ├── ApiController.php
│   │   ├── JsonController.php  // Zuständig für JSON-APIs, z.B. AJAX-Anfragen.
│   │   └── StoneController.php  // Der Hauptcontroller für die Verwaltung und Anzeige der Steine.
│   │
│   ├── Domain/
│   │   ├── Model/
│   │   │   └── Page.php  // Das Domain Model, das die Struktur eines Steins repräsentiert.
│   │   └── Repository/
│   │       └── PageRepository.php  // Das Repository für den Zugriff auf die Steine, die in der Tabelle `pages` gespeichert sind.
│   │
│   └── ViewHelpers/
│       └── PaginationViewHelper.php  // Ein ViewHelper zur Erzeugung der Pagination.
│   
├── Configuration/
│   ├── Extbase/
│   │   └── Persistence/
│   │       └── Classes.php  // Klasse zum Mapping von Datenbanktabellen auf die Domain-Modelle.
│   │
│   ├── Routes/
│   │   └── Lexikon.yaml
│   │
│   ├── TCA/
│   │   └── Overrides/
│   │       ├── pages.php  // Erweiterung der TCA-Konfiguration für die `pages`-Tabelle.
│   │       ├── sys_template.php  // Anpassung der TCA-Konfiguration für Templates.
│   │       ├── tt_content.php  // Anpassung der TCA-Konfiguration für Inhaltselemente.
│   │       ├── tx_mlstonelexicon_lexicon.php  // TCA-Konfiguration für das Lexikon-Modul.
│   │       └── tx_mlstonelexicon_page.php  // TCA-Konfiguration für die Seite `tx_mlstonelexicon_page`.
│   │
│   ├── TsConfig/
│   │   ├── Page/
│   │   │   ├── Mod/
│   │   │   │   └── WebLayout/
│   │   │   │       ├── BackendLayouts/
│   │   │   │       │   ├── lexicon.tsconfig  // TsConfig für spezifische Backend-Layouts des Lexikons.
│   │   │   │       │   └── BackendLayouts.tsconfig  // Allgemeine TsConfig für Backend-Layouts.
│   │   │   └── All.tsconfig  // Globales TsConfig für die Seite.
│   │   │
│   │   └── User/
│   │       └── UserConfiguration.tsconfig  // TsConfig für benutzerdefinierte Einstellungen.
│   │
│   ├── TypoScript/
│   │    ├── setup.typoscript
│   │    └── constants.typoscript
│   │
│   ├── page.tsconfig
│   ├── Icons.php
│   ├── Routes.yaml
│   └── Services.yaml
│
├── Resources/
│   ├── Private/
│   │   ├── Language/
│   │   │   ├── de.locallang.xlf
│   │   │   └── locallang.xlf
│   │   │
│   │   ├── Templates/
│   │   │   ├── List.html  // Haupttemplate für die Listenansicht der Steine.
│   │   │   └── Stone.html  // Template für die Detailansicht eines Steins.
│   │   │
│   │   ├── Partials/
│   │   │    ├── SearchForm.html  // Partial für das Suchformular.
│   │   │    ├── Pagination.html // Partial für die Pagination.
│   │   │    ├── Images.html  // Partial für die Anzeige von Bildern.
│   │   │    ├── SearchForm.html
│   │   │    └── StoneListPartial.html // Partial für AJAX-Anfragen
│   │   │
│   │   └── Layouts/
│   │       └── Stone.html  // Hauptlayout für die Steine-Ansichten.
│   │
│   └── Public/
│       ├── JavaScript/
│       │   ├── Dist/
│       │   │   └── jquery-ui.min.js  // Minimierte Version von jQuery UI.
│       │   └── Src/
│       │       └── lexikon.js  // Haupt-JavaScript-Datei für die AJAX-Interaktionen.
│       │
│       ├── Scss/
│       │   ├── lexikon.scss  // SCSS-Datei für das Styling des Lexikons.
│       │   └── autocomplete.scss  // SCSS-Datei für die Autovervollständigung.
│       │
│       └── Icons/
│           ├── BackendLayouts/
│           │   ├── diamant.svg  // SVG-Icon für ein spezifisches Backend-Layout.
│           │   └── lexicon_layout.svg  // SVG-Icon für das Lexikon-Layout.
│           └── Extension.svg  // SVG-Icon für die Extension.
│
├── composer.json
├── ext_emconf.php
├── ext_localconf.php
├── ext_tables.php
├── ext_tables.sql
└── README.rst
