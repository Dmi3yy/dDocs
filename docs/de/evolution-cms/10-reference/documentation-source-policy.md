# Dokumentationsquellenrichtlinie

[Zurück](documentation-navigation.md) / [Nach oben](../README.md)

Die Evolution CMS-Dokumentation muss das aktuelle Produktverhalten beschreiben. Historisch
Material kann hilfreich sein, aber es ist nicht kanonisch, bis es mit dem Strom verglichen wird
Code.

## Zulässige Quellen

| Quelle | Verwenden Sie |
| --- | --- |
| Aktueller Evolution CMS-Code | Laufzeit, Manager, API, Modelle, Konfiguration, Ereignisse, CLI, Installationsprogrammkompatibilität und Legacy-Grenzen. |
| Eigenständiger Installationscode und README | Aktueller Installer-First-Setup-Ablauf und `evo`-Befehlsverhalten. |
| Altes Evolution CMS-Dokumentenarchiv | Klassisches API, DB API, Terminologie und historisches Verhalten nach der Validierung. |
| Validierte Best-Practice-Notizen | Zukünftige Rezepte nach Überprüfung der aktuellen Routing-, Modell- und Manager-APIs. |
| Paketdokumentation | Verknüpft, wenn ein gepflegter Extra Eigentümer der paketspezifischen Details ist. |

## Material nicht migriert

Alte Komponentenhandbücher werden nicht in diesen Produktdokumentbaum kopiert. Sie bleiben drin
das Legacy-Archiv. Aktuell installierte Extras erscheinen in dDocs durch ihre eigenen
Dokumentation auf Paketebene.

## Überprüfungsregel

Wenn historisches oder Best-Practice-Material verwendet wird:

1. Überprüfen Sie den aktuellen Codepfad.
2. Überprüfen Sie, ob die Funktion aktuell, veraltet oder veraltet ist.
3. Schreiben Sie die Seite für die aktuelle Leseraufgabe neu.
4. Verlinken Sie auf Paketdokumente, anstatt Pakethandbücher zu kopieren.
5. Bewahren Sie alte Komponentenseiten als Archivmaterial auf.

## Zukünftige Best-Practice-Themen

Die ersten Kandidaten sind:

- Routen, Ajax-Anfragen, Anforderungsvalidierung, JSON-Antworten und Blade partiell
  Rendering;
- `SiteContent`-Modellnutzung, TV-Abfrage, Schließungsbaumdurchquerung und Ressource
  Auswahlmuster.

Diese gehören dazu, wenn die Kerndokumentation genau genug ist, um sie zu unterstützen
nachdem Beispiele anhand des aktuellen Codes überprüft wurden.
