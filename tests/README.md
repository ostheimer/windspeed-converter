# Tests – Windspeed Converter

Playwright-E2E-Tests gegen die lokale Docker-Testumgebung (WordPress + MariaDB, `http://localhost:8080`, Login `admin`/`admin123`).

## Voraussetzungen

1. Laufende Docker-Testumgebung (Verzeichnis mit der `docker-compose.yml` der Testumgebung):

```bash
docker compose up -d
```

2. Plugin in den gemounteten Ordner syncen (`/tmp/wsc-dist/wind-speed-converter`, siehe `docker-compose.yml`-Volume).

3. Testseiten anlegen und Aktivierungshinweis scharf schalten (idempotent, im Compose-Verzeichnis ausführen):

```bash
bash tests/setup-test-pages.sh
```

## Tests ausführen

```bash
cd tests
npm install
npx playwright install chromium
npm test
```

Basis-URL und Admin-Zugang lassen sich per Umgebungsvariablen ändern: `WP_BASE_URL`, `WP_ADMIN_USER`, `WP_ADMIN_PASS`.

## Abgedeckte Szenarien

### `e2e/frontend.spec.ts`

| Szenario | Schritte | Erwartung |
|---|---|---|
| Shortcode-Basis | `/converter/` öffnen | 5 Eingabefelder + Backlink „by Ostheimer.at" sichtbar |
| Umrechnung km/h | 100 in km/h tippen (keyup-basiert) | mph 62.14, m/s 27.78, Knoten 54.00, Beaufort 10 |
| Umrechnung m/s | 10 in m/s tippen | km/h 36.00, mph 22.37, Knoten 19.44, Beaufort 5 |
| Beaufort-Bereiche | 5 in Beaufort tippen | km/h „29 - 38", mph „19 - 24", m/s „8.0 - 10.7", Knoten „16 - 21" |
| Beaufort-Validierung | 13 in Beaufort tippen | Meldung „Number between 1 and 12", Felder zeigen „-" |
| Dezimaltrennzeichen | „10,5" in km/h tippen | Meldung „Use . (dot) as comma." |
| Attribut `link="false"` | `/nolink/` öffnen | Kein Backlink |
| Attribute `beaufort`/`ms` | `/partial/` öffnen | Beaufort- und m/s-Feld fehlen, Rest sichtbar |
| Zwei Konverter | `/double/` öffnen | Zwei `.wind_converter`-Container |
| Block-Rendering | `/block-test/` öffnen (Block mit `beaufort:false, link:false`) | Beaufort + Backlink fehlen, Umrechnung funktioniert |

### `e2e/admin.spec.ts`

| Szenario | Schritte | Erwartung |
|---|---|---|
| Pluginliste | Login → Plugins | Links „How to use", „Documentation", „Support" in der Plugin-Zeile |
| Hilfeseite | Werkzeuge → Windspeed Converter | H1 „… How to use", Shortcode-Beispiele für alle 6 Attribute |
| Aktivierungshinweis | Dashboard → „Open the guide" klicken | Hinweis verlinkt zur Hilfeseite und verschwindet danach dauerhaft |

## Manuelle Tests (nicht automatisiert)

| Szenario | Schritte | Erwartung |
|---|---|---|
| Sprachen (Frontend/Admin) | Einstellungen → Allgemein → Sprache z. B. auf Deutsch stellen | Feldbeschriftungen („Knoten"), Hilfeseite („… Anleitung") und Hinweise übersetzt |
| Block-Editor i18n | Bei deutscher Site-Sprache Block einfügen | Panel „Felder", Toggle „Backlink anzeigen", übersetzte Blockbeschreibung (JSON-Übersetzungen) |
| Block-Editor-Vorschau | Block einfügen, Felder togglen | Server-side Vorschau aktualisiert sich live |
| Widget (Legacy) | Design → Widgets, Widget platzieren | Beschreibung im Picker, Felder-Checkboxen, „Hide Link?" blendet Backlink aus |
| Plugin Check | Werkzeuge → Plugin Check | Nur die bekannte, akzeptierte Warnung zu `load_plugin_textdomain()` |
