# Roadmap - Windspeed Converter WordPress Plugin

## Status: Alle Fixes eingereicht - Warte auf WordPress.org Review

### Version 1.3.0 - WordPress.org Review-Fixes (Februar 2026)

Alle Probleme aus dem WordPress.org Plugin-Review wurden behoben und mit Plugin Check (PCP) 1.8.0 verifiziert.

| # | Problem | Status |
|---|---------|--------|
| 1 | GPL-Lizenz in readme.txt und Plugin-Header deklarieren | ✅ Erledigt |
| 2 | Dateipfade korrekt bestimmen (WP_PLUGIN_URL → plugin_dir_url()) | ✅ Erledigt |
| 3 | PHP-Funktionen für Remote-Dateien vermeiden (include mit WP_PLUGIN_DIR) | ✅ Erledigt |
| 4 | Text-Domain an Plugin-Slug anpassen ('windspeed' → 'wind-speed-converter') | ✅ Erledigt |
| 5 | Output-Escaping: _e() → esc_html_e(), Variablen escapen, checked() verwenden | ✅ Erledigt |
| 6 | Eindeutige Präfixe für Funktionen/Klassen/Variablen (wsconv_) | ✅ Erledigt |
| 7 | Direkten Dateizugriff verhindern (ABSPATH-Check) | ✅ Erledigt |
| 8 | WordPress-Trademark aus Plugin-Name entfernen | ✅ Erledigt |
| 9 | readme.txt: License, Tested up to 6.9, Tags (max 5) | ✅ Erledigt |
| 10 | Screenshots aus Plugin-Verzeichnis in SVN assets/ verschieben | ✅ Erledigt |
| 11 | JS-Variable 'messages' auf 'wsconv_messages' umbenennen | ✅ Erledigt |
| 12 | Sprachdateien umbenennen und Text-Domain korrigieren | ✅ Erledigt |
| 13 | LICENSE-Datei auf GPLv2 aktualisieren | ✅ Erledigt |
| 14 | load_plugin_textdomain() entfernt (seit WP 4.6 nicht mehr nötig) | ✅ Erledigt |
| 15 | $args Widget-Argumente mit phpcs:ignore annotiert | ✅ Erledigt |
| 16 | .distignore für SVN-Ausschluss erstellt | ✅ Erledigt |

### Test-Ergebnisse

| Test | Ergebnis |
|------|----------|
| Plugin Check (PCP) 1.8.0 | ✅ Keine Fehler in Plugin-Dateien |
| WordPress 6.9.1 mit WP_DEBUG | ✅ Keine PHP-Fehler |
| Shortcode [windspeed_converter] | ✅ Funktioniert |
| Konvertierung (100 km/h Test) | ✅ Korrekte Ergebnisse |

### Noch ausstehend

| Aufgabe | Status |
|---------|--------|
| Git Commit & Push | ⏳ Ausstehend |
| Code in SVN trunk/ hochladen | ✅ Erledigt (Revision 3456315) |
| Tag 1.3.0 in SVN tags/ erstellen | ✅ Erledigt (Revision 3456315) |
| Antwort-E-Mail an WordPress Plugins Team senden | ✅ Erledigt |

### Zukünftige Verbesserungen (Post-Review)

| Feature | Status |
|---------|--------|
| Mehrsprachigkeit ausbauen (weitere Sprachen) | 📋 Geplant |
| Moderne UI/UX-Überarbeitung | 📋 Geplant |
| Block Editor (Gutenberg) Widget | 📋 Geplant |
| Unit-Tests mit PHPUnit | 📋 Geplant |
| Playwright E2E-Tests | 📋 Geplant |
