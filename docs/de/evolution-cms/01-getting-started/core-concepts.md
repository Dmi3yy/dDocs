# Kernkonzepte

[Zurück](installation.md) / [Nach oben](README.md) / [Weiter](../07-security-updates-operations/troubleshooting.md)

Diese Seite definiert das vom aktuellen Evolution CMS-Produkt verwendete Vokabular
Dokumentation. Es handelt sich um eine kurze Konzeptkarte, nicht um eine API-Referenz.

## Hauptbegriffe

| Begriff | Bedeutung | Aktuelle Codeoberfläche |
| --- | --- | --- |
| Manager | Die authentifizierte Verwaltungsoberfläche zum Bearbeiten von Inhalten, Elementen, Einstellungen, Benutzern, Paketen und Managermodulen. | Manager-Controller und -Ansichten unter der Manager-Laufzeit. |
| Resource | Ein in der Site-Struktur gespeichertes Inhaltselement. Eine Ressource kann abhängig von ihren Feldern eine Seite, einen ordnerähnlichen Knoten, einen Link oder einen anderen Inhaltstyp darstellen. | `EvolutionCMS\Models\SiteContent` und die Tabelle `site_content`. |
| Dokumentenbaum | Die hierarchische Sicht auf Ressourcen. Übergeordnetes, untergeordnetes Element, Reihenfolge, veröffentlicht, gelöscht und der Sichtbarkeitsstatus wirken sich alle darauf aus, wie eine Ressource angezeigt wird. | `SiteContent` Eltern-/Kind-Beziehungen und die Abschlusstabelle. |
| Vorlage | Eine den Ressourcen zugewiesene Layout-/Inhaltsstruktur. Vorlagen können mit Template Variables verbunden werden. | `EvolutionCMS\Models\SiteTemplate`. |
| Template Variable | Eine benutzerdefinierte Felddefinition, die an Vorlagen angehängt und pro Ressource gespeichert werden kann. | `SiteTmplvar`, `SiteTmplvarTemplate` und `SiteTmplvarContentvalue`. |
| Chunk | Ein wiederverwendbares Text- oder Markup-Element. Chunks werden normalerweise für wiederholte Layoutfragmente oder kleine wiederverwendbare Ausgabeblöcke verwendet. | `EvolutionCMS\Models\SiteHtmlsnippet`. |
| Snippet | Ein von PHP unterstütztes Element, das Logik ausführen und Ausgaben von Vorlagen, Chunks oder Ressourceninhalten zurückgeben kann. | `EvolutionCMS\Models\SiteSnippet`. |
| Plugin | Ereignisgesteuerter PHP-Code, der mit einem oder mehreren Systemereignissen verbunden ist. Plugins reagiert auf Manager-, Parser-, Cache-, Dokument- und Erweiterungslebenszyklusereignisse. | `EvolutionCMS\Models\SitePlugin` und `SitePluginEvent`. |
| Veranstaltung | Ein benannter Hook, der von der Laufzeit aufgerufen wird. Ereignisse werden als Namen gespeichert und vorrangig mit Plugins verknüpft. | `EvolutionCMS\Models\SystemEventname` und `evo()->invokeEvent(...)`. |
| Module | Ein managerseitiges Tool oder eine Anwendungsoberfläche. Modules kann vom Manager aus ausgeführt werden und zu Paketen gehören. | `EvolutionCMS\Models\SiteModule`. |
| Paket | Ein von Composer verteiltes Codepaket, das Dienste, Ansichten, Routen, Konfigurationen, Assets, Module und Dokumentation bereitstellen kann. | Composer-Pakete plus Befehle/Dienste des Evolution-Pakets. |
| Extra | Ein optionales Paket oder eine Erweiterung, die in einem Projekt installiert wird. Extras besitzt eine eigene Paketdokumentation in dDocs. | Installierte Paketquellen, indiziert durch dDocs. |
| Cache | Generierte Laufzeitdaten, die vom Parser, Manager, Ansichten, Paketmetadaten und Einstellungen verwendet werden. Der Cache kann über den Manager oder die Konsole gelöscht werden. | `evo()->clearCache('full')`, `cache:clear-full` und Site-Aktualisierung. |

## Wie sie zusammenpassen

Eine typische Seite beginnt als Ressource im Dokumentbaum. Die Ressource wählt a
Vorlage. Die Vorlage kann Template Variables für strukturierte Felder verfügbar machen.
Die Vorlagen Chunks und Snippets können Ausgaben erstellen. Plugins Ereignisse anhören
Laufzeitverhalten verlängern. Modules bietet managerseitige Tools für größere Arbeitsabläufe.

```text
Resource -> Template -> TV values
         -> Chunks and Snippets
         -> Plugins through Events
         -> Cache and rendered output
```

## Produktdokumente und Paketdokumente

Evolution CMS-Produktdokumentation erklärt Kernproduktkonzepte, Manager
Verhalten, Laufzeitarchitektur, APIs, Vorgänge und Upgrade-Grenzen.

Installierte Extras werden durch eigene Pakete dokumentiert. dDocs liest dieses Paket
Dokumente aus dem Dateisystem und zeigt sie neben der Produktdokumentation an. Tun Sie es
Kopieren Sie keine vollständigen Extra-Handbücher in diesen Produktbaum, es sei denn, die Seite enthält Erläuterungen
ein zentraler Integrationsvertrag, der von allen Paketen gemeinsam genutzt wird.

## Legacy-Grenzen

Evolution CMS enthält weiterhin Kompatibilitätsoberflächen für älteren Code und alte
Installationsabläufe. In der aktuellen Dokumentation sollten diese Oberflächen nur dann benannt werden, wenn a
Der Leser muss das Kompatibilitäts- oder Migrationsverhalten verstehen. Neue Tutorials
und Anleitungen sollten mit dem aktuellen Installationsprogramm, Paket, Manager usw. beginnen
Composer-basierte Workflows.
