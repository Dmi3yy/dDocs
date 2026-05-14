# Benutzerhandbuch

Dieser Leitfaden zeigt, wie Benutzer Dokumentation in dDocs im Evolution CMS
Manager lesen und pflegen.

## Dokumentationsmodul öffnen

1. Melde dich im Evolution CMS Manager an.
2. Öffne das Modul Dokumentation.
3. Warte, bis der Baum links und der Viewer rechts geladen sind.

## Paketdokumentation lesen

1. Wähle eine Quelle auf der Startseite oder im Baum.
2. Öffne die benötigten Ordner.
3. Wähle ein Dokument.
4. Lies den gerenderten Markdown im rechten Panel.

Vendor docs sind nur lesbar. Änderungen gehören in das Repository des Pakets.

## Dokumentation suchen

1. Klicke in das Suchfeld im sidebar.
2. Gib ein Wort aus Titel, Pfad, Paketname oder Inhalt ein.
3. Öffne ein Ergebnis aus dem gefilterten Baum.
4. Leere das Suchfeld, um zum ganzen Baum zurückzukehren.

## Sprachfallback verstehen

dDocs startet mit der Sprache des Managers. Wenn diese Dokumentation fehlt,
fällt dDocs auf English und danach auf neutral docs zurück.

Ukrainische Dokumentation verwendet nur `uk`. Legacy manager input `ua` wird zu
`uk` normalisiert.

## Projektdokument erstellen

1. Klicke create document im toolbar sidebar.
2. Gib den Namen ein.
3. Bestätige den Dialog.
4. dDocs erstellt eine Markdown-Datei in `ProjectDocs/`.

## Projektdokument bearbeiten

1. Öffne ein Dokument aus Project Documentation.
2. Klicke edit im document header.
3. Bearbeite Markdown im editor.
4. Klicke save.
