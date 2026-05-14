# Referenz zu den Systemeinstellungen

[Zurück](artisan-and-manager-actions.md) / [Nach oben](../README.md) / [Weiter](roles-and-permissions.md)

Evolution CMS speichert Laufzeit- und Managereinstellungen in der Systemeinstellungsschicht.
Die Standardwerte für eine Neuinstallation werden von der Kerneinstellungsfabrik definiert
und kann über den Bildschirm „Systemeinstellungen“ des Managers geändert werden, wenn die aktuelle Version angezeigt wird
Der Manager-Benutzer hat die Berechtigung, Einstellungen zu bearbeiten.

## Manager-Registerkarten

| Tab | Einstellungsbereich |
| --- | --- |
| Allgemein | Site-Standardeinstellungen, Veröffentlichung, Cache-Standardeinstellungen, Baumverhalten, Vorlagen, Protokollierung, Daten und Besucherverfolgung. |
| Freundliche URLs | Freundlicher URL-Modus, Suffixe, Aliase, striktes URL-Verhalten und Ordner-URL-Verhalten. |
| Schnittstelle | Manager Sprache, Design, Menülayout, Baumgröße, Editoren, Anmeldedarstellung und UI-Schaltflächen. |
| Sicherheit | Anmeldeversuche, Sitzungsdauer, Captcha, Referrer-Validierung, Passwort-Hashing, Eval-Richtlinie und Website-Verfügbarkeit. |
| Datei Manager | Stammverzeichnis des Dateimanagers, Zulassungslisten für Upload-Erweiterungen, Upload-Größe, Dateiberechtigungen und Ordnerberechtigungen. |
| Dateibrowser | Resource Browser-Root, Einstellungen zur Bildgrößenänderung, versteckte Dateien, Miniaturansichten, Dateinamenbereinigung und Browsermodus. |
| Mail-Vorlagen | Absender, E-Mail-Transport, SMTP-Einstellungen, Anmelde- und Passwort-Erinnerungsvorlagen. |

Plugins kann HTML über das Rendern der Systemeinstellungen zu Einstellungsregisterkarten hinzufügen
Ereignisse, die in [Ereignisreferenz](events.md) aufgeführt sind.

## Kritische Standardwerte

| Einstellung | Standard | Bedeutung |
| --- | --- | --- |
| `site_name` | `My Evolution CMS Site` | Öffentlicher Site-Name, der von Standardvorlagen und Managerbezeichnungen verwendet wird. |
| `site_start` | `1` | Resource wird als Startseite der Website verwendet. |
| `error_page` | `1` | Resource wird für nicht gefundene Fehler verwendet, sofern es nicht überschrieben wird. |
| `unauthorized_page` | `1` | Resource wird verwendet, wenn ein Besucher nicht auf eine geschützte Seite zugreifen kann. |
| `site_unavailable_page` | leer | Optionale Ressource für Wartungs-/Nichtverfügbarkeitsstatus. |
| `base_url` | `/` | Basis-URL, die von der Laufzeit-URL-Generierung verwendet wird. |
| `valid_hostnames` | leer | Host-Zulassungsliste. Leer bedeutet keine explizite Hostnamenliste. |
| `server_protocol` | `http` | Standardprotokoll, das in generierten URLs verwendet wird. |
| `server_offset_time` | `0` | Serverzeitversatz in Sekunden. |
| `datetime_format` | `dd-mm-YYYY` | Manager Datums-/Uhrzeitanzeigeformat. |

## Resource Standardeinstellungen

| Einstellung | Standard | Bedeutung |
| --- | --- | --- |
| `default_template` | `0` | Standardvorlage für neue Ressourcen. |
| `publish_default` | `0` | Ob neue Ressourcen standardmäßig veröffentlicht werden. |
| `cache_default` | `1` | Ob neue Ressourcen standardmäßig zwischenspeicherbar sind. |
| `search_default` | `1` | Ob neue Ressourcen standardmäßig durchsuchbar sind. |
| `auto_menuindex` | `1` | Menüindexwerte automatisch zuweisen. |
| `resource_tree_node_name` | `pagetitle` | Resource-Feld, das als Baumknotenbezeichnung verwendet wird. |
| `tree_page_click` | `27` | Manager-Aktion wurde geöffnet, wenn auf einen Ressourcenbaumknoten geklickt wurde. |
| `tree_show_protected` | `0` | Ob geschützte Ressourcen im Baum sichtbar sind. |
| `show_meta` | `0` | Ob Metadatenfelder standardmäßig angezeigt werden. |
| `show_newresource_btn` | `1` | Ob die Schaltfläche „Neue Ressource“ angezeigt wird. |

## Freundliche URL-Standardwerte

| Einstellung | Standard | Bedeutung |
| --- | --- | --- |
| `friendly_urls` | `0` | Freundliche URLs sind standardmäßig deaktiviert. |
| `friendly_url_prefix` | leer | Präfix zu benutzerfreundlichen URLs hinzugefügt. |
| `friendly_url_suffix` | `/` | Suffix zu benutzerfreundlichen URLs hinzugefügt. |
| `friendly_alias_urls` | `1` | Aliasbasierte URLs sind aktiviert. |
| `use_alias_path` | `1` | Übergeordnete Aliase sind in den generierten Pfaden enthalten. |
| `make_folders` | `0` | Das ordnerähnliche URL-Verhalten ist standardmäßig deaktiviert. |
| `seostrict` | `0` | Die strikte SEO-URL-Behandlung ist standardmäßig deaktiviert. |
| `aliaslistingfolder` | `0` | Das Verhalten des Alias-Auflistungsordners ist standardmäßig deaktiviert. |
| `allow_duplicate_alias` | `0` | Doppelte Aliase werden standardmäßig blockiert. |
| `automatic_alias` | `1` | Die automatische Alias-Generierung ist aktiviert. |
| `xhtml_urls` | `1` | Escape-URLs im XHTML-Stil sind aktiviert. |

## Parser- und Cache-Standardwerte| Einstellung | Standard | Bedeutung |
| --- | --- | --- |
| `enable_cache` | `1` | Der Laufzeitcache ist standardmäßig aktiviert. |
| `cache_type` | `1` | Standard-Cache-Backend-Modus. |
| `chunk_processor` | `DLTemplate` | Standardmäßig verwendeter Chunk-Prozessor. |
| `enable_bindings` | `1` | Die Bindungssyntax ist aktiviert. |
| `enable_at_syntax` | `0` | Die bedingte `@`-Syntax ist standardmäßig deaktiviert. |
| `allow_eval` | `with_scan` | Evaluierungsverhalten ist beim Scannen zulässig. |
| `safe_functions_at_eval` | `time,date,strtotime,strftime` | Sichere Funktionen für evaluierungsbezogenes Parsen. |
| `minifyphp_incache` | `0` | PHP-Minifizierung im Cache ist deaktiviert. |
| `html_comment` | leer | Optionale Parser-Debug-Kommentare. |

Lesen Sie die [Parser-Tags-Referenz](parser-tags.md), bevor Sie die Vorlagensyntax dokumentieren
oder Parserverhalten.

## Manager Schnittstellenstandards

| Einstellung | Standard | Bedeutung |
| --- | --- | --- |
| `use_editor` | `1` | Die Rich-Text-Bearbeitung ist aktiviert. |
| `which_editor` | `TinyMCE4` | Standardschlüssel für den Rich-Text-Editor. |
| `tinymce4_theme` | `custom` | Standardeinstellung für das TinyMCE-Design. |
| `tinymce4_skin` | `lightgray` | Standard-TinyMCE-Skin. |
| `manager_theme_mode` | `3` | Standard-Manager-Designmodus. |
| `manager_menu_position` | `top` | Manager Menüposition. |
| `manager_menu_height` | `2.2` | Manager Menühöhe in `rem`. |
| `manager_tree_width` | `20` | Manager Baumbreite in `rem`. |
| `login_form_position` | `left` | Position des Anmeldeformular-Layouts. |
| `login_form_style` | `dark` | Stil des Anmeldeformulars. |
| `manager_login_startup` | `0` | Standardmäßiges Startverhalten des Managers nach der Anmeldung. |
| `use_breadcrumbs` | `0` | Breadcrumbs sind standardmäßig deaktiviert. |
| `remember_last_tab` | `0` | Manager merkt sich standardmäßig nicht die letzte Registerkarte. |
| `global_tabs` | `1` | Globale Registerkarten aktiviert. |
| `group_tvs` | `0` | Template Variables werden standardmäßig nicht gruppiert. |
| `show_picker` | `0` | Die Auswahl-Benutzeroberfläche ist standardmäßig deaktiviert. |
| `show_fullscreen_btn` | `0` | Vollbild-Schaltfläche standardmäßig ausgeblendet. |

## Datei- und Upload-Standardeinstellungen

| Einstellung | Standard | Bedeutung |
| --- | --- | --- |
| `filemanager_path` | `[(base_path)]` | Basispfad des Dateimanagers. |
| `rb_base_dir` | `[(base_path)]assets/` | Resource Browser-Basisverzeichnis. |
| `rb_base_url` | `assets/` | Resource Browser-Basis-URL. |
| `use_browser` | `1` | Resource-Browser aktiviert. |
| `which_browser` | `mcpuk` | Standardimplementierung des Ressourcenbrowsers. |
| `rb_webuser` | `0` | Webbenutzer-Browsermodus deaktiviert. |
| `upload_maxsize` | `5000000` | Upload-Größenbeschränkung in Bytes. |
| `new_file_permissions` | `0644` | Berechtigungen für neu erstellte Dateien. |
| `new_folder_permissions` | `0755` | Berechtigungen für neu erstellte Ordner. |
| `clean_uploaded_filename` | `1` | Hochgeladene Dateinamen werden bereinigt. |
| `strip_image_paths` | `1` | Bildpfade werden in ausgewählten Ausgaben entfernt. |
| `denyZipDownload` | `0` | Der ZIP-Download ist standardmäßig erlaubt. |
| `denyExtensionRename` | `0` | Das Blockieren der Erweiterungsumbenennung ist standardmäßig deaktiviert. |
| `showHiddenFiles` | `0` | Versteckte Dateien werden standardmäßig nicht angezeigt. |
| `snapshot_path` | `[(base_path)]assets/backup/` | Standard-Snapshot-/Backup-Pfad. |

Die Standard-Upload-Zulassungslisten sind aus Gründen der Legacy-Kompatibilität bewusst breit gefasst.
Projekte sollten sie produktionspolitisch verschärfen.

## Sicherheits- und Zugriffsstandards

| Einstellung | Standard | Bedeutung |
| --- | --- | --- |
| `use_udperms` | `1` | Benutzer-/Dokumentberechtigungen sind aktiviert. |
| `udperms_allowroot` | `0` | Der Root-Zugriff über Dokumentberechtigungen ist deaktiviert. |
| `failed_login_attempts` | `3` | Fehlgeschlagene Anmeldeversuche, bevor das Blockierungsverhalten greift. |
| `blocked_minutes` | `10` | Dauer der Anmeldesperre in Minuten. |
| `session_timeout` | `15` | Manager Sitzungszeitlimit in Minuten. |
| `validate_referer` | `1` | Referrer-Validierung aktiviert. |
| `use_captcha` | `0` | Captcha ist standardmäßig deaktiviert. |
| `pwd_hash_algo` | `0` | Standardeinstellung für den Passwort-Hash-Algorithmus. |
| `check_files_onlogin` | Kerndateiliste | Dateien werden bei der Manager-Anmeldung überprüft. |
| `warning_visibility` | `1` | Manager-Warnungen sichtbar. |
| `send_errormail` | `0` | Fehler-E-Mail-Versand deaktiviert. |
| `error_reporting` | `1` | Standardeinstellung für die Fehlerberichterstattung. |

## E-Mail-Standardeinstellungen| Einstellung | Standard | Bedeutung |
| --- | --- | --- |
| `emailsender` | `you@example.com` | Standard-Absenderadresse. |
| `email_sender_method` | `1` | Einstellung der Absendermethode. |
| `email_method` | `mail` | Standard-Mailtransport. |
| `smtp_host` | `smtp.example.com` | Standardplatzhalter für den SMTP-Host. |
| `smtp_port` | `25` | Standard-SMTP-Port. |
| `smtp_auth` | `0` | SMTP-Authentifizierung deaktiviert. |
| `smtp_username` | `emailsender` | Standardplatzhalter für den SMTP-Benutzernamen. |
| `smtp_secure` | leer | Standardmäßig kein SMTP-Verschlüsselungsmodus. |

## Dokumentationsregel

Wenn Sie eine Einstellung dokumentieren, beziehen Sie die aktuelle Standardeinstellung erst ein, nachdem Sie sie überprüft haben
Werkseinstellungen oder Seed-Pfad installieren. Wenn ein Projekt eine Einstellung überschreibt
Dokumentieren Sie die Außerkraftsetzung nicht in der Datenbank oder Umgebung, sondern in der Projektdokumentation
in dieser Produktreferenz.
