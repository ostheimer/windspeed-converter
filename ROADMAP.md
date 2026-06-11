# Roadmap - Windspeed Converter WordPress Plugin

## Status: v1.4.0 live auf WordPress.org - v1.5.0 fertig entwickelt, SVN-Release ausstehend

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
| Git Commit & Push | ✅ Erledigt |
| Code in SVN trunk/ hochladen | ✅ Erledigt (Revision 3456315) |
| Tag 1.3.0 in SVN tags/ erstellen | ✅ Erledigt (Revision 3456315) |
| Antwort-E-Mail an WordPress Plugins Team senden | ✅ Erledigt |

### Zukünftige Verbesserungen (Post-Review)

| Feature | Status |
|---------|--------|
| Mehrsprachigkeit ausbauen (weitere Sprachen) | ✅ Erledigt (v1.4.0, alle 24 EU-Amtssprachen) |
| Block Editor (Gutenberg) Widget | ✅ Erledigt (v1.5.0) |
| Playwright E2E-Tests | ✅ Erledigt (v1.5.0, tests/) |
| Moderne UI/UX-Überarbeitung | 📋 Geplant |
| Unit-Tests mit PHPUnit | 📋 Geplant |
| Übersetzungen ins translate.wordpress.org-System bringen (Language Packs, Polyglots-Prozess) | 📋 Geplant |

### Version 1.4.0 - EU-Übersetzungen & Store-Assets (Juni 2026)

| Aufgabe | Status |
|---------|--------|
| Übersetzungen für alle 24 EU-Amtssprachen (.po/.mo, msgfmt-validiert) | ✅ Erledigt |
| POT-Template (languages/wind-speed-converter.pot) | ✅ Erledigt |
| load_plugin_textdomain() wieder eingebaut (keine Language Packs auf translate.wordpress.org → gebündelte .mo luden nie) | ✅ Erledigt |
| Neue Store-Assets in .wordpress-org/: Icon 128/256, Banner 772+1544 (Retina), Screenshot-1 | ✅ Erledigt |
| deploy-to-svn.sh synct .wordpress-org/ → SVN assets/ | ✅ Erledigt |
| Docker-Testsuite auf WP 7.0 (Plugin Check 0 Fehler, 23 Locales, E2E) | ✅ Erledigt |
| Plugin-Check-Warnung zu load_plugin_textdomain() | ✅ Bewusst akzeptiert (gebündelte Übersetzungen, keine Language Packs auf translate.wordpress.org) |
| SVN-Arbeitskopie /tmp/wind-speed-converter-svn vorbereitet (50 A, 5 M, MIME gesetzt) | ✅ Erledigt |
| Branch in main gemergt und zu GitHub gepusht | ✅ Erledigt |
| SVN-Commit v1.4.0 trunk + assets | ✅ Erledigt (Revision 3569378) |
| SVN-Tag 1.4.0 | ✅ Erledigt (Revision 3569379) |
| Release auf wordpress.org verifizieren | ✅ Erledigt (Verzeichnis liefert 1.4.0 aus, Tested 7.0) |
| Docker-Testumgebung abräumen (docker compose down -v), Worktree + Branch löschen | ⏳ Ausstehend |

### Version 1.5.0 - Onboarding & Gutenberg-Block (Juni 2026)

Hintergrund: Nach der Aktivierung gab es im Backend keinerlei Hinweise zur Verwendung (kein Settings-Link, keine Doku, Shortcode nicht auffindbar).

| Aufgabe | Status |
|---------|--------|
| Gutenberg-Block mit Feld-Toggles (block.json + plain JS, Server-Side-Render, ohne Build-Step) | ✅ Erledigt |
| Hilfeseite unter Werkzeuge → Windspeed Converter (Block, Shortcode-Attribute, Widget, Sprachen, Support) | ✅ Erledigt |
| Einmaliger Aktivierungshinweis mit Link zur Hilfeseite (dismissbar, Nonce-gesichert) | ✅ Erledigt |
| Pluginlisten-Links: „How to use" (Action) + „Documentation"/„Support" (Row-Meta) | ✅ Erledigt |
| Widget-Beschreibung im Widget-Picker | ✅ Erledigt |
| Bugfix: Widget-Backlink wurde nie angezeigt (invertierte Bedingung) | ✅ Erledigt |
| 29 neue Strings in alle 24 EU-Amtssprachen übersetzt (.po/.mo, msgfmt-validiert) | ✅ Erledigt |
| JSON-Übersetzungen für Block-Editor-Strings (wp_set_script_translations) | ✅ Erledigt |
| Playwright-E2E-Tests (tests/, 14 Tests: Konvertierung, Attribute, Block, Admin-Onboarding) | ✅ Erledigt (14/14 bestanden) |
| Manuell verifiziert in Docker (WP 7.0): Notice, Hilfeseite (en/de), Block-Editor inkl. deutscher Editor-Strings | ✅ Erledigt |
| Plugin Check: keine neuen Fehler/Warnungen (nur bekannte, akzeptierte load_plugin_textdomain-Warnung) | ✅ Erledigt |
| SVN-Release v1.5.0 (deploy-to-svn.sh, trunk + tag + ggf. neuer Screenshot) | ⏳ Ausstehend |
