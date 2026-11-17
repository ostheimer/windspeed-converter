# windspeed-converter

WordPress-Plugin „Windspeed Converter“ (Slug auf WordPress.org: `wind-speed-converter`, aktuell 1.5.0): Windgeschwindigkeits-Umrechner (km/h, mph, Beaufort, m/s, Knoten) als Widget, Shortcode `[windspeed_converter]` und Gutenberg-Block. Funktionsumfang und Dateistruktur stehen in `README.md`. Das Plugin liegt direkt in der Repo-Wurzel; Hauptdatei `windspeed-converter.php`, Block ohne Build-Step in `block/`.

- Veröffentlichung: Dieses Repo ist die Entwicklungsquelle, WordPress.org-SVN die Auslieferung. `./deploy-to-svn.sh <version>` checkt das SVN unter `/tmp/wind-speed-converter-svn` aus, gleicht per `rsync --delete` nach `trunk/` ab (Ausschlüsse aus `.distignore`), kopiert die Store-Assets aus `.wordpress-org/` nach `assets/` und gibt nur die `svn commit`/`svn copy`-Befehle aus. Es committet nichts selbst und braucht WordPress.org-Zugangsdaten. Ein Merge auf `main` veröffentlicht nichts.
- Bei einem Release müssen `Version` in `windspeed-converter.php` und `Stable tag` in `readme.txt` übereinstimmen. Alles, was nicht in `.distignore` steht, landet im Plugin-ZIP auf wordpress.org.
- Text-Domain ist `wind-speed-converter`, Funktions- und Variablenpräfix `wsconv_` (beides Vorgabe aus dem WordPress.org-Review). Übersetzungen liegen in `languages/` (POT plus `.po`/`.mo` je Sprache, dazu `*-wsconv-block-editor.json` für den Editor).
- Tests: Playwright-E2E in `tests/` gegen eine lokale Docker-WordPress-Umgebung, deren `docker-compose.yml` nicht in diesem Repo liegt (Anleitung in `tests/README.md`). Keine Workflows.
- Offene Aufgaben für das nächste Release (Link-Umstellung in `readme.txt` und Plugin URI) stehen in `ROADMAP.md`.
