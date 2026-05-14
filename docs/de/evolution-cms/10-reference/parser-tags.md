# Parser-Tags-Referenz

[Zurück](blade-and-template-rendering.md) / [Nach oben](../README.md) / [Weiter](models.md)

Evolution CMS klassische Vorlagen verwenden Parser-Tags für Ressourcen, Einstellungen,
Chunks, Snippets, Platzhalter, URLs und bedingte Inhalte. Diese Seite zeichnet auf
die aktuelle Kern-Tag-Oberfläche, damit die Beispiele konsistent bleiben.

## Standard-Tags

| Tag | Bedeutung | Beispiel |
| --- | --- | --- |
| `[*field*]` | Current resource field or Template Variable. | `[*pagetitle*]` |
| `[(setting)]` | System setting or runtime config value. | `[(site_name)]` |
| `{{chunk}}` | Chunk Inhalt. | `{{site_header}}` |
| `{{chunk?&name=`value`}}` | Chunk with local parameters. | `{{card?&title=`Hello`}}` |
| `[[snippet]]` | Zwischengespeicherter Snippet-Aufruf. | `[[DocLister]]` |
| `[!snippet!]` | Nicht zwischengespeicherter Snippet-Aufruf. | `[!contactForm!]` |
| `[+placeholder+]` | Placeholder value from parser scope. | `[+title+]` |
| `[~id~]` | Resource-URL. | `[~1~]` |
| `[^key^]` | Laufzeit-/Meta-Platzhalterstil, der von Bereinigungs- und Escape-Pfaden verwendet wird. | `[^q^]` |

Verwenden Sie bei der Dokumentation abgegrenzte Beispiele mit den Sprachbezeichnungen `html` oder `blade`
template code in Markdown.

## Resource Fields And TVs

Resource-Tags lesen zuerst das aktuelle Dokumentobjekt. Sie können auch lesen
Template Variables, wenn TV-Werte für die Ressource geladen werden.

```html
<h1>[*pagetitle*]</h1>
<p>[*introtext*]</p>
<img src="[*hero_image*]" alt="">
```

Der Parser unterstützt auch die Kontextsuche mit `@` in Ressourcen-Tags. Aktuell
Die Kontextverarbeitung umfasst übergeordnetes Element, ultimatives übergeordnetes Element, Alias-Suche und Vorheriges/Nächstes
Geschwistersuche und direkte Ressourcen-ID-Suche.

```html
[*pagetitle@parent*]
[*pagetitle@uparent(0)*]
[*pagetitle@alias(home)*]
```

## Systemeinstellungen

Einstellungs-Tags lesen die Laufzeitkonfiguration und bekannte Pfad-/URL-Werte.

```html
<title>[(site_name)]</title>
<base href="[(site_url)]">
```

Zu den häufig generierten Werten gehören `base_url`, `base_path`, `site_url`,
`valid_hostnames`, `site_manager_url` und `site_manager_path`.

## Chunks

Chunks sind wiederverwendbare Vorlagen. An einen Chunk übergebene Parameter sind verfügbar als
lokale Platzhalter während der Chunk-Analyse.

```html
{{button?&label=`Read more`&url=`[~12~]`}}
```

Die Chunk-Ausgabe kann Platzhalter, Ressourcen-Tags, Einstellungen und andere Blöcke enthalten.
und bedingte Tags. Der Parser löst verschachtelte Inhalte rekursiv auf, bis der
Die konfigurierten Parser-Durchlaufgrenzen sind erreicht.

## Snippets

Zwischengespeicherte Snippets verwenden `[[...]]`. Nicht zwischengespeicherte Snippets verwenden `[!...!]` und werden konvertiert
um Tags während der Post-Parse-Ausgabe auszuschneiden.

```html
[[menuBuilder?&startId=`0`]]
[!contactForm?&redirectTo=`15`!]
```

Snippet-Parameter werden vor der Ausführung analysiert. Halten Sie Parameterwerte explizit
und vermeiden Sie es, sich auf einen undokumentierten globalen Staat zu verlassen.

## Platzhalter

Platzhalter werden aus dem aktuellen Parser-Platzhalterbereich oder lokal aufgelöst
Daten, die an einen Chunk-/Parser-Aufruf übergeben werden.

```html
<article>
  <h2>[+title+]</h2>
  <p>[+summary+]</p>
</article>
```

Placeholders can use modifiers. Modifiers are part of the classic parser
Oberfläche und sollten mit der davon abhängigen Funktion dokumentiert werden.

## URL Tags

URL tags are rewritten during output processing.

```html
<a href="[~1~]">Home</a>
```

URL output depends on resource publication state, friendly URL settings,
aliases, suffixes, base URL, and the URL processor.

## Bedingte Tags

Conditional tags are enabled through the `enable_at_syntax` setting. Aktuell
Die Kernsyntax verwendet Tags in Großbuchstaben:

```html
<@IF:[*published*]>
  Published
<@ELSE>
  Draft
<@ENDIF>
```

Der Parser normalisiert auch alte HTML-Kommentarformen wie `<!--@IF ...-->`,
`<!--@ELSE-->` und `<!--@ENDIF-->`.

## Bindungen und Inline-Vorlagenmodi

Parser-Vorlagenhelfer erkennen spezielle Modi:

| Modus | Bedeutung |
| --- | --- |
| `@CODE` / `@INLINE` / `@TPL` | Verwenden Sie Inline-Vorlagencode. |
| `@FILE` | Laden Sie den Vorlagencode aus einer Datei unter dem konfigurierten Vorlagenpfad. |
| `@DOCUMENT` / `@DOC` | Laden Sie Inhalte von der aktuellen oder ausgewählten Ressource. |
| `@B_FILE` | Rendern Sie eine Blade-Datei. |
| `@B_CODE` | Rendern Sie Inline-Blade-Code über den generierten Cache. |
| `@T_CODE` / `@T_FILE` | Reservierte Vorlagenmodi im Parser-Handling. |

Siehe [Blade und Referenz zum Rendern von Vorlagen](blade-and-template-rendering.md)
für Blade-spezifisches Verhalten.

## Aufräumen und Entkommen

Der Ausgabefluss kann:

- Nicht zwischengespeicherte Snippets während der Nachanalyse ausführen;
- Registrierte Startskripte vor `</head>` einfügen;
- Registrierte Skripte vor `</body>` einfügen;
- Bereinigen Sie nicht verwendete Evolution-Tags.
- URL-Tags in endgültige URLs umschreiben.

`getTagsForEscape()` umfasst Standard-Tag-Paare wie `{{ }}`, `[[ ]]`,
`[! !]`, `[* *]`, `[( )]`, `[+ +]`, `[~ ~]` und `[^ ^]`.

## Dokumentationsregel

Verwenden Sie beim Schreiben von Beispielen die kleinste Tag-Fläche, die die Aufgabe erklärt. Für
Neue Projekte, die Blade-Vorlagen verwenden, bevorzugen Blade-Beispiele und verlinken nur hier
wenn klassische Parser-Tags erforderlich sind.
