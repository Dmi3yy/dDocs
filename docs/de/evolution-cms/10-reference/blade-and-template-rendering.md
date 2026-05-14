# Blade und Referenz zum Rendern von Vorlagen

[Zurück](roles-and-permissions.md) / [Nach oben](../README.md) / [Weiter](parser-tags.md)

Evolution CMS unterstützt sowohl klassische Evolution-Parser-Vorlagen als auch Blade-gestützte Vorlagen
Vorlagen. Die aktuelle Laufzeit wählt den Rendering-Pfad aus der Ressource
Vorlage und der verfügbaren Blade-Ansichtszuordnung.

## Rendering-Fluss

| Schritt | Laufzeitverhalten |
| --- | --- |
| Ressource laden | Core lädt das Ressourcenobjekt, validiert den gelöschten/veröffentlichten/Referenzstatus und bereitet Dokumentdaten vor. |
| Vorlage auflösen | Runtime fragt den Vorlagenprozessor nach einer Blade-Dokumentansicht. Wenn keiner verfügbar ist, wird der Vorlagencode aus der Datenbank geladen. |
| Daten teilen | Blade-Vorlagen empfangen `modx`, `documentObject` und zeigen Daten von der Laufzeit an. |
| Rendern Sie Blade | Wenn eine Blade-Ansicht vorhanden ist, wird sie von der Ansichtsfabrik gerendert und die Ressource wird für diesen Durchgang als nicht zwischenspeicherbar behandelt. |
| Klassische Vorlage analysieren | Wenn keine Blade-Ansicht vorhanden ist, wird der klassische Vorlagencode vom Evolution-Parser analysiert. |
| Ereignisse aufrufen | `OnLoadWebDocument` wird ausgeführt, nachdem der Dokumentinhalt vorbereitet wurde. Ausgabeereignisse und Verhalten nach der Analyse werden später im Antwortfluss ausgeführt. |

Wenn einer Ressource keine Vorlage zugewiesen ist, verwendet die Laufzeit `[*content*]` als Vorlage
leere klassische Vorlage.

## Vorlagenquellen

| Quelle | Syntax oder Oberfläche | Notizen |
| --- | --- | --- |
| Datenbankvorlage | Manager Vorlagenelement | Klassische Evolution-Parser-Vorlage. |
| Blade Dokumentansicht | Vom Vorlagenprozessor aufgelöste Ansicht | Aktueller Blade-Pfad für Ressourcenvorlagen. |
| Beim Speichern erstellte Vorlagendatei | Manager-Vorlagenoption | Durch das Speichern der Vorlage kann eine entsprechende `.blade.php`-Datei erstellt werden. |
| `@FILE` Block-/Vorlagenmodus | `@FILE:path` | Liest eine Vorlagendatei unter dem konfigurierten Vorlagenpfad und der konfigurierten Erweiterung. |
| `@CODE` / `@INLINE` / `@TPL` | Inline-Codezeichenfolge | Wird von Parser-Chunk-/Template-Helfern verwendet. |
| `@DOCUMENT` / `@DOC` | Dokumentinhalt nach ID oder aktuellem Dokument | Zieht Dokumentinhalte in Parser-Vorlagen. |
| `@B_FILE` | Blade Dateimodus | Rendert eine Blade-Datei über die geklonte Ansichtsfabrik. |
| `@B_CODE` | Blade-Codemodus | Schreibt eine generierte Blade-Cache-Datei und rendert sie über einen `cache::`-Namespace. |

## Blade Daten

Blade-Dokumentvorlagen empfangen die aktuellen Laufzeitobjekt- und Dokumentdaten.

| Variable | Bedeutung |
| --- | --- |
| `$modx` | Aktuelles Evolution CMS Kern-/Laufzeitobjekt. |
| `$documentObject` | Aktuelle Ressourcenobjektdaten. |
| Daten anzeigen | Zusätzliche Laufzeitdaten, vorbereitet durch `getDataForView()`. |

Wenn der Chunk-Prozessor `DLTemplate` aktiv ist, sind dieselben gemeinsam genutzten Daten ebenfalls aktiv
in seine Blade-Integration übergeben.

## Manager Blade Ansichten

Die Manager-Benutzeroberfläche verwendet Blade-Ansichten unter dem Manager-Ansichts-Namespace.

| Muster anzeigen | Zweck |
| --- | --- |
| `manager::template.page` | Standard-Manager-Seiten-Shell. |
| `manager::template.blank` | Minimale Manager-Seiten-Shell. |
| `manager::partials.header` | Manager-Header-Assets und Top-Skriptstapel. |
| `manager::partials.footer` | Manager Fußzeile und unterer Skriptstapel. |
| `manager::partials.actionButtons` | Standardmäßige Aktionsschaltflächen auf der Managerseite. |
| `manager::form.*` | Gemeinsam genutzte Manager-Formularzeilen, Eingaben, Optionsfelder, Auswahlmöglichkeiten und Textbereiche. |
| `manager::page.*` | Manager Seitenbildschirme und verschachtelte Seitenteile. |

Zu den gängigen Blade-Stacks, die von Manageransichten verwendet werden, gehören `scripts.top` und
`scripts.bot`.

## Kern-Blade-Richtlinien

| Richtlinie | Ausgabe |
| --- | --- |
| `@evoConfig($key)` | Escape-Wert aus `evo()->getConfig($key)`. |
| `@makeUrl($value)` | Vom URL-Prozessor generierte Escape-URL. |
| `@evoParser($value)` | Evolution-Inhalte wurden über `evo_parser()` analysiert. |
| `@evoRole($role)` | Öffnet einen bedingten Block, wenn `evo_role($role)` wahr ist. |
| `@evoElseRole($role)` | Fügt einen `elseif`-Zweig für eine weitere Rollenprüfung hinzu. |
| `@evoEndRole` | Schließt den rollenbedingten Block. |
| `@auth` | Wahr, wenn `evo()->getLoginUserID()` nicht falsch ist. |
| `@guest` | True, wenn kein Frontend-Benutzer angemeldet ist. |
| `@svg($name, ...)` | Rendert ein Blade Icons SVG über den Evolution-Adapter. |Ältere benutzerdefinierte Direktiven können weiterhin von `view.directive` registriert werden, aber
Dieser Pfad ist veraltet und sollte nicht für die Dokumentation neuer Produkte verwendet werden.

## Direktive-Helfer unterstützen

Die Support-Hilfsklasse definiert auch Legacy-Anweisungsrückrufe, die von älteren verwendet werden
Konfigurationsgesteuerte Direktivenregistrierung:

| Helfer | Bedeutung |
| --- | --- |
| `csrf()` | Gibt ein CSRF-Feld aus. Veraltet. |
| `evoLang($key)` | Liest einen Manager-Lexikonwert. |
| `evoStyle($key)` | Liest einen Manager-Stilwert. |
| `evoAdminLang()` | Liest den Namen der aktiven Managersprache. |
| `evoCharset()` | Liest den Manager-Zeichensatz. |
| `evoAdminThemeUrl()` | Liest die Manager-Theme-URL. |
| `evoAdminThemeName()` | Liest den Namen des Manager-Themes. |

Neue Manager-Seiten sollten stattdessen aktuelle Manager-Helfer und gemeinsame Ansichten bevorzugen
des Hinzufügens neuer konfigurationsgesteuerter Anweisungen.

## Blade-Symbole

Evolution CMS liefert einen Adapter für Blade-Symbole. Der Adapter:

- führt die Kernkonfiguration `blade-icons` zusammen;
- registriert die Icon-Fabrik und das Manifest;
- registriert die `@svg`-Direktive;
– registriert Symbolkomponenten, wenn das Symbolmanifest vorhanden ist;
– veröffentlicht die `blade-icons.php`-Konfiguration im Konsolenmodus.

Verwenden Sie Symbole über die konfigurierten Symbolsätze und sorgen Sie dafür, dass die Symbolnamen der Manager-Benutzeroberfläche stabil bleiben
wenn Paketdokumente oder Screenshots darauf verweisen.

## Dokumentationsregel

Geben Sie beim Dokumentieren des Vorlagenverhaltens an, ob es sich bei dem Beispiel um einen klassischen Parser handelt
Syntax oder Blade-Syntax. Parser-Tags und Blade-Direktiven dürfen nicht gleichzeitig gemischt werden
Beispiel, es sei denn, auf der Seite wird explizit erläutert, wie die beiden Rendering-Pfade interagieren.
