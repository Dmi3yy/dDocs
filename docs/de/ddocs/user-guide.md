# Benutzerguide

Dieser Guide zeigt Manager-Benutzern, wie sie Dokumentation in dDocs lesen und
pflegen. Er konzentriert sich auf Aufgaben innerhalb des Evolution CMS Managers.

## Dokumentationsmodul öffnen

1. Melde dich im Evolution CMS Manager an.
2. Öffne das Documentation-Modul aus dem Manager-Menü.
3. Warte, bis der linke Dokumentationsbaum und das rechte Viewer-Panel geladen sind.

Die Startansicht listet verfügbare Dokumentationsquellen. Eine Quelle kann ein
Paket, das dDocs-Paket selbst oder Project Documentation sein.

## Paketdokumentation durchsuchen

1. Wähle eine Quelle aus der Startansicht oder aus dem linken Baum.
2. Klappe Ordner mit dem Chevron auf.
3. Wähle ein Dokument.
4. Lies das gerenderte Markdown im rechten Panel.

Vendor-Paketdokumentation ist read-only. Um Vendor-Docs zu ändern, bearbeite die
Dateien im Paket-Repository.

## Dokumentation suchen

1. Klicke in das Suchfeld der Sidebar.
2. Gib ein Wort aus Dokumenttitel, Pfad, Paketname oder Inhalt ein.
3. Öffne ein Ergebnis aus dem gefilterten Baum.
4. Leere das Suchfeld, um zum vollständigen Baum zurückzukehren.

dDocs überspringt Dateien größer als `max_file_size_kb`, damit die
Manager-Navigation responsiv bleibt.

## Sprach-Fallback verstehen

dDocs beginnt mit der aktuellen Manager-Sprache. Wenn diese Locale fehlt, fällt
es auf Englisch und danach auf neutrale Docs zurück.

Ukrainische Dokumentation verwendet `uk`. Wenn ein älterer Manager noch den
legacy Wert `ua` meldet, öffnet dDocs automatisch die `uk`-Docs.

## Dokumentationssprache wechseln

dDocs folgt derzeit der Manager-Sprache oder der konfigurierten
`default_language`. Ändere die Manager-Sprache oder setze `default_language`,
wenn ein Projekt eine feste Dokumentationssprache braucht.

## Projektdokument erstellen

1. Klicke den Button zum Erstellen eines Dokuments in der Sidebar-Toolbar.
2. Gib den Dokumentnamen ein.
3. Bestätige den Dialog.
4. dDocs erstellt eine Markdown-Datei in `ProjectDocs/` und öffnet sie.

Project Documentation ist der beschreibbare Bereich für lokales Projektwissen.

## Projektordner erstellen

1. Klicke den Button zum Erstellen eines Ordners in der Sidebar-Toolbar.
2. Gib den Ordnernamen ein.
3. Bestätige den Dialog.
4. Öffne den neuen Ordner aus dem Baum.

Ordner- und Dokumentnamen werden vor dem Schreiben auf die Festplatte in sichere
Dateinamen umgewandelt.

## Projektdokument bearbeiten

1. Öffne ein Dokument aus Project Documentation.
2. Klicke die Edit-Aktion im Dokumentkopf.
3. Aktualisiere das Markdown im Editor.
4. Klicke save.

dDocs aktualisiert den Dateiindex nach dem Speichern.

## Projektelement löschen

1. Öffne das Kontextmenü eines beschreibbaren Project Documentation Elements.
2. Wähle delete.
3. Bestätige den Dialog.

Löschen ist für Vendor-Paketdokumentation und Root-Quellen nicht verfügbar.

## Markdown oder Code kopieren

Nutze die copy-Aktion im Dokumentkopf, um die komplette Markdown-Quelle zu kopieren.
Nutze die copy-Aktion an einem Codeblock, um nur dieses Snippet zu kopieren.

## Index aktualisieren

1. Öffne das Settings-Panel.
2. Klicke refresh index.
3. Warte auf die aktualisierte Dokumentanzahl.

Aktualisiere den Index nach manuellen Änderungen an Paketdokumentation oder nach
Änderungen an konfigurierten Dokumentationsroots.

## Dokumentation als Markdown herunterladen

1. Öffne das Settings-Panel.
2. Klicke Download Markdown.
3. Speichere die generierte `.md`-Datei.

Der Export enthält lesbare Dokumentknoten aus dem aktuellen dDocs-Index. Lokale
relative Links und Bilder behalten ihre ursprünglichen Quellpfade.

## Fehlendes Dokument beheben

Wenn ein Dokument fehlt:

1. Aktualisiere den Index.
2. Prüfe, ob die Dateierweiterung erlaubt ist.
3. Prüfe, ob die Datei unter `max_file_size_kb` liegt.
4. Prüfe, ob das Paket eine unterstützte `docs/`-Struktur hat.
5. Bitte einen Entwickler, die safe roots zu prüfen, wenn die Quelle projektspezifisch ist.
