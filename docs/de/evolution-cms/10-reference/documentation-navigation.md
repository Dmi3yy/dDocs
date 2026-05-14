# Dokumentationsnavigation

[Zurück](source-inventory.md) / [Nach oben](../README.md) / [Weiter](documentation-source-policy.md)

Die Evolution CMS-Dokumentation verwendet eine kleine Navigationsgrammatik, damit sich die Leser bewegen können
durch einen Abschnitt, ohne sich nur auf den linken Baum zu verlassen.

## Navigationstypen

| Linktyp | Zweck | Beispiel |
| --- | --- |
| Strukturell | Durchlaufen Sie den Dokumentationsbaum. | `Back`, `Up`, `Next` |
| Abschnitt Kinder | Seiten anzeigen, die zu einem Abschnitt gehören. | Eine Tabelle in `README.md` |
| Semantisch | Verbinden Sie verwandte Konzepte oder Quellbereiche. | `Related`, `See Also` |

## Strukturelle Links

Verwenden Sie diese Form oben in mehrseitigen Abschnitten:

```text
# Page Title

[Back](previous.md) / [Up](README.md) / [Next](next.md)

Short reader-focused opening paragraph.

## Task Or Reference Section

...

## Related

- [Relevant page](other-page.md)
```

Wenn kein struktureller Nachbar existiert, lassen Sie diesen Link weg, anstatt einen zu erfinden
Ziel.

## Abschnitt Landing Pages

Abschnitt `README.md` Seiten sollten kleine Portale sein. Sie sollten Folgendes umfassen:

- ein kurzer Absatz über den Abschnitt;
- eine Tabelle mit untergeordneten Seiten;
- der aktuelle Umfang des Abschnitts;
- Links zu verwandten Abschnitten nur bei Bedarf.

## Quellenreferenzseiten

Quellreferenzseiten können Quelltabellen, Befehlslisten, Modelllisten usw. enthalten.
Konfigurationstabellen und Validierungsstatus. Sie dürfen keine privaten Daten enthalten
Dateisystempfade, interne Planungsbegriffe oder generierte Analysemetadaten.

## Extras Links

Duplizieren Sie die installierte Extras-Dokumentation nicht im Evolution CMS-Produkt
Dokumente. Link zu Dokumenten auf Paketebene, wenn ein verwaltetes Paket Eigentümer der Details ist.
