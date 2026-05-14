# Einstellungen, Berechtigungen und Dateien

[Zurück](elements.md) / [Nach oben](README.md) / [Weiter](../04-development/project-structure.md)

Dieses Handbuch behandelt die Konfigurationsoberflächen des Kernmanagers: Systemeinstellungen, benutzerfreundlich
URLs, Dateizugriff, Uploads, Suche, Rollen, Berechtigungen und Webzugriffsgruppen.

## Systemeinstellungen

Die Managerseite „Systemeinstellungen“ ist berechtigungsgeschützt und kann währenddessen gesperrt werden
Ein anderer Manager-Benutzer bearbeitet es. Zu den aktuellen Einstellungsregisterkarten gehören:

| Tab | Allgemeine Verwendung |
| --- | --- |
| Allgemein | Site-Standards, Veröffentlichungs-Standards, Cache-Standards, Such-Standards, Menüindexverhalten, Vorlagen und Zeiteinstellungen. |
| Freundliche URLs | URL-Modus, Suffix/Präfix, Ordnerverhalten, strikte URLs und Alias-Verhalten. |
| Schnittstelle | Manager Sprache, Thema, Editorauswahl und Schnittstellenoptionen. |
| Sicherheit | Passwort- und Manager-Sicherheitseinstellungen. |
| Dateibrowser | Resource Browser-Basispfad und Bereinigung des hochgeladenen Dateinamens. |
| Datei Manager | Dateimanagerpfad, Upload-Zulassungslisten, Bild-/Medien-Zulassungslisten und Upload-Größe. |
| Mail-Vorlagen | Manager Mail-Vorlageneinstellungen. |

Nach dem Ändern von Einstellungen, die sich auf Ausgabe, Pfade, URLs, Uploads, Cache usw. auswirken
Managerverhalten, aktualisieren Sie den Cache und testen Sie den betroffenen Workflow.

## Freundliche URLs

Freundliche URLs erfordern:

1. Evolution CMS-freundliche URL-Einstellungen aktiviert.
2. Gültige Aliase für Ressourcen.
3. Regeln zum Umschreiben des Webservers für das Projekt.
4. Cache-Aktualisierung nach Änderungen.

Wenn sich die genauen URLs nicht auflösen lassen, verwenden Sie die Manager-Suche nach URL und überprüfen Sie die Ressource
veröffentlicht, nicht gelöscht und nicht durch Zugriffsregeln blockiert.

## Dateien und Uploads

Das Dateibrowser- und Upload-Verhalten hängt sowohl von den Evolution CMS-Einstellungen als auch ab
Dateisystemberechtigungen.

Überprüfen Sie:

- Dateimanagerpfad;
- Basisverzeichnis des Ressourcenbrowsers;
- erlaubte Datei-/Bild-/Medienerweiterungen;
- Einstellung der Upload-Größe;
- PHP- und Webserver-Upload-Limits;
- Lese-/Schreibberechtigungen für Verzeichnisse.

## Rollen und Manager Berechtigungen

Manager-Rollen und -Berechtigungen steuern, worauf Managerbenutzer zugreifen können. Wenn ein Benutzer
Ein Bildschirm kann nicht geöffnet werden. Überprüfen Sie Folgendes:

1. Die Rolle des Benutzers.
2. Die für die Managerseite erforderliche Berechtigung.
3. Ob die Ressource oder das Element gesperrt ist.
4. Ob die Aktion durch Manager-Zugriffsregeln ausgeblendet wird.

## Webzugriffsberechtigungen

Webzugriffsberechtigungen verwenden Benutzergruppen und Dokumentgruppen. Die Managerseite kann
Sie können diese Gruppen erstellen, umbenennen, löschen und verbinden.

Verwenden Sie Webzugriffsberechtigungen, wenn Website-Besucher nur bestimmte geschützte Inhalte sehen sollen
Ressourcen. Wenn die Funktion deaktiviert ist, wird auf der Managerseite zuvor eine Warnung angezeigt
Gruppenmanagement.

## Suchen

Manager-Suche kann Ressourcen nach ID, Textfeldern, genauer URL, Vorlage usw. finden
Template Variable-Werte. Verwenden Sie es für Supportfälle, bei denen sich der Baumstandort befindet
unbekannt oder eine Ressource ist ausgeblendet, gelöscht, unveröffentlicht oder geschützt.

## Paketdokumentationsgrenze

In den Core-Manager-Dokumenten wird das integrierte Evolution CMS-Verhalten beschrieben. Extras installiert
erscheinen als separate Dokumentationsquellen in dDocs. Wenn ein Managerbildschirm dazugehört
Wenn Sie auf ein Paket zugreifen möchten, öffnen Sie die Dokumente dieses Pakets, anstatt dies auf die Produktdokumente zu erwarten
Duplizieren Sie das Handbuch.
