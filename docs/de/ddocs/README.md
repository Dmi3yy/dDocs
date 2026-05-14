# dDocs

dDocs ist ein dateibasierter Dokumentationsbrowser für den Evolution CMS
Manager. Das Modul findet Markdown-Dokumentation in installierten Paketen,
zeigt sie als Baum an, rendert das ausgewählte Dokument und speichert
projektspezifische Notizen als Dateien.

Die Quelle der Wahrheit ist das filesystem. dDocs benötigt keine Datenbanktabellen
für Paketdokumentation.

## Leitfäden

- [Benutzerhandbuch](user-guide.md)
- [Entwicklerhandbuch](developer-guide.md)
- [Frontend Guide](frontend-guide.md)
- [Konfiguration](configuration.md)
- [Reference](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Dokumentationsstandards](documentation-standards.md)

## Regeln

- Paketdokumentation lebt in `docs/`.
- Die ukrainische Dokumentationslocale ist nur `uk`.
- Vendor docs sind read-only.
- Project Documentation wird in `ProjectDocs/` gespeichert.
- Interne Links müssen relativ sein.
- Code fences müssen einen language identifier haben.
