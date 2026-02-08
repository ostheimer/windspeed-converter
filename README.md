# Windspeed Converter - WordPress Plugin

Ein WordPress-Plugin, das einen Windgeschwindigkeits-Umrechner als Widget oder Shortcode bereitstellt. Der Benutzer gibt einen von fünf Werten ein und das Plugin berechnet die anderen.

## Unterstützte Einheiten

- **Km/h** (Kilometer pro Stunde)
- **Mph** (Meilen pro Stunde)
- **Beaufort** (Beaufort-Skala)
- **M/s** (Meter pro Sekunde)
- **Knoten** (Nautische Meilen pro Stunde)

## Installation

1. Lade den Ordner `wind-speed-converter` in das Verzeichnis `/wp-content/plugins/` hoch
2. Aktiviere das Plugin über das Menü 'Plugins' in WordPress
3. Füge den Windspeed Converter zu deinem Widget-Bereich hinzu

## Verwendung

### Shortcode

```
[windspeed_converter]
```

### Optionen

- Backlink ausblenden: `[windspeed_converter link="false"]`
- Einzelne Felder deaktivieren: `[windspeed_converter beaufort="false" ms="false"]`

### Widget

Füge das Widget einfach in die gewünschte Sidebar ein, gib einen Titel ein und aktiviere die gewünschten Optionen.

## Entwicklung

### Voraussetzungen

- WordPress 5.0+
- PHP 7.4+

### Workflow: GitHub → WordPress.org SVN

Dieses Repository ist die primäre Entwicklungsquelle. Die Synchronisation zu WordPress.org SVN erfolgt über das Deploy-Skript:

```bash
chmod +x deploy-to-svn.sh
./deploy-to-svn.sh 1.3.0
```

Das Skript synchronisiert die Dateien nach SVN trunk/ und gibt Anweisungen zum Committen und Taggen.

### Dateistruktur

```
windspeed-converter/
├── windspeed-converter.php          # Haupt-Plugin-Datei
├── widget.php                       # Widget-Klasse
├── windspeed-converter.js           # Konvertierungslogik (Frontend)
├── windspeed-converter-beaufort-scala.js  # Beaufort-Skala-Daten
├── windspeed-converter.css          # Plugin-Styles
├── languages/                       # Übersetzungsdateien
│   ├── wind-speed-converter-de_DE.po
│   └── wind-speed-converter-de_DE.mo
├── readme.txt                       # WordPress.org Plugin-Readme
├── LICENSE                          # GPLv2 Lizenz
├── ROADMAP.md                       # Projekt-Roadmap
├── deploy-to-svn.sh                 # SVN-Deploy-Skript
└── .gitignore
```

## Lizenz

GPLv2 or later - siehe [LICENSE](LICENSE)

## Autor

Andreas Ostheimer - [ostheimer.at](https://www.ostheimer.at)
