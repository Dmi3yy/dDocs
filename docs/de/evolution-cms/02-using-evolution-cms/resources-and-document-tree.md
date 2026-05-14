# Resources und Dokumentenbaum

[Zurück](README.md) / [Nach oben](README.md) / [Weiter](elements.md)

Resources sind die Inhaltsknoten, die im Manager-Dokumentbaum angezeigt werden. Das sind sie
Wird vom Modell `SiteContent` gespeichert und kann Seiten, Ordner, Links usw. darstellen
andere Inhaltstypen abhängig von ihren Fachgebieten.

## Erstellen Sie ein Resource

1. Öffnen Sie den Manager-Dokumentenbaum.
2. Wählen Sie den übergeordneten Standort.
3. Erstellen Sie eine neue Ressource oder einen neuen Link über die Baum- oder Manager-Aktionssteuerelemente.
4. Geben Sie den Seitentitel, den Alias, die Vorlage, den Inhalt und die Menüeinstellungen ein und veröffentlichen Sie sie
   Staat.
5. Speichern Sie die Ressource.
6. Aktualisieren Sie den Site-Cache, wenn die Änderung nicht sofort sichtbar ist.

## Inhalt bearbeiten

Öffnen Sie die Ressource in der Baumstruktur und aktualisieren Sie die Inhaltsfelder. Das Ressourcenformular
kann Template Variable-Felder enthalten, wenn der ausgewählten Vorlage TVs zugewiesen ist.

Wichtige Ressourcenfelder sind:

| Feldfläche | Warum es wichtig ist |
| --- | --- |
| Titel und Menütitel | Wird in der Managerstruktur, in Menüs und in Ausgabehilfen verwendet. |
| Alias ​​| Wird bei Aktivierung von benutzerfreundlichen URLs verwendet. |
| Übergeordneter und Menüindex | Kontrollieren Sie die Baumposition und die Menüreihenfolge. |
| Vorlage | Steuert das verfügbare Layout und Template Variables. |
| Status „Veröffentlicht/Gelöscht“ | Steuert, ob die Ressource für Website-Besucher sichtbar ist. |
| Durchsuchbare/cachebare Flags | Beeinflusst das Such- und Cache-Verhalten. |
| Private Web-/Manager-Flags | Zugriffsregeln beeinflussen. |

## Organisieren Sie den Baum

Verwenden Sie Baumaktionen zum Verschieben, Duplizieren, Löschen, Wiederherstellen, Veröffentlichen und Zurücknehmen der Veröffentlichung
Ressourcen. Verschiebevorgänge rufen den Verschiebeablauf des aktuellen Managers auf und lösen den Verschiebevorgang aus
Ereignisse. Durch Löschen wird eine Ressource normalerweise als gelöscht markiert. leeren Papierkorb entfernt gelöschte
Ressourcen.

Wenn Baumänderungen nicht sichtbar sind, aktualisieren Sie den Baum und leeren Sie den Cache.

## Suche Resources

Die Manager-Suchoberfläche kann nach Ressourcenfeldern, genauen IDs, genauen URLs usw. suchen.
Vorlagenfilter und Template Variable-Werte. Die genaue URL-Suche verwendet aktuelle
benutzerfreundliche URL-Einstellungen und Alias-Auflösung.

Verwenden Sie die Suche, wenn:

- eine Ressource ist tief im Baum verborgen;
- Der Alias ​​oder die URL ist bekannt, die Ressourcen-ID jedoch nicht.
- Es muss ein Template Variable-Wert gefunden werden;
- Der Status „Gelöscht/Unveröffentlicht“ muss überprüft werden.

## Freundliche URL-Notizen

Freundliche URLs hängen sowohl von den Evolution CMS-Einstellungen als auch von der Umschreibung des Webservers ab
Regeln. Wenn ein gespeicherter Alias nicht funktioniert:

1. Überprüfen Sie die Einstellung `friendly_urls`.
2. Überprüfen Sie die Suffix-, Präfix-, Ordner- und strengen URL-Einstellungen.
3. Überprüfen Sie die Rewrite-Regeln im Webserver.
4. Aktualisieren Sie den Site-Cache.
5. Bestätigen Sie, dass die Zielressource veröffentlicht und nicht gelöscht wurde.

Ausführlichere Betriebsprüfungen finden Sie unter
[Fehlerbehebung](../07-security-updates-operations/troubleshooting.md).
