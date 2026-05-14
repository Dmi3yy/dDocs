# Informacje o ustawieniach systemu

[Wstecz](artisan-and-manager-actions.md) / [W górę](../README.md) / [Dalej](roles-and-permissions.md)

Evolution CMS przechowuje ustawienia środowiska wykonawczego i menedżera w warstwie ustawień systemowych.
Wartości domyślne dla nowej instalacji są zdefiniowane w fabryce ustawień podstawowych
i można je zmienić na ekranie ustawień systemowych menedżera, gdy bieżący
użytkownik menedżer ma uprawnienia do edycji ustawień.

## Karty Manager

| Zakładka | Obszar ustawień |
| --- | --- |
| Ogólne | Domyślne ustawienia witryny, publikowanie, domyślne ustawienia pamięci podręcznej, zachowanie drzewa, szablony, rejestrowanie, daty i śledzenie gości. |
| Przyjazne adresy URL | Tryb przyjaznego adresu URL, przyrostki, aliasy, ścisłe zachowanie adresu URL i zachowanie adresu URL folderu. |
| Interfejs | Manager język, motyw, układ menu, rozmiar drzewa, edytory, wygląd logowania i przyciski interfejsu użytkownika. |
| Bezpieczeństwo | Próby logowania, czas życia sesji, captcha, sprawdzanie poprawności strony odsyłającej, mieszanie hasła, zasady ewaluacji i dostępność witryny. |
| Plik Manager | Katalog główny menedżera plików, listy dozwolonych rozszerzeń przesyłania, rozmiar przesyłanych plików, uprawnienia do plików i uprawnienia do folderów. |
| Przeglądarka plików | Resource katalog główny przeglądarki, ustawienia zmiany rozmiaru obrazu, ukryte pliki, miniatury, czyszczenie nazw plików i tryb przeglądarki. |
| Szablony poczty | Nadawca, transport poczty, ustawienia SMTP, szablony rejestracji i przypomnienia hasła. |

Plugins może dodać HTML do kart ustawień poprzez renderowanie ustawień systemowych
zdarzenia wymienione w [Odnośnik zdarzeń](events.md).

## Krytyczne ustawienia domyślne

| Ustawienie | Domyślne | Znaczenie |
| --- | --- | --- |
| `site_name` | `My Evolution CMS Site` | Nazwa witryny publicznej używana przez domyślne szablony i etykiety menedżerów. |
| `site_start` | `1` | Resource używana jako strona startowa serwisu. |
| `error_page` | `1` | Resource używany w przypadku błędów, których nie znaleziono, chyba że zostanie zastąpiony. |
| `unauthorized_page` | `1` | Resource używany, gdy odwiedzający nie może uzyskać dostępu do chronionej strony. |
| `site_unavailable_page` | pusty | Opcjonalny zasób dotyczący stanu konserwacji/niedostępności. |
| `base_url` | `/` | Podstawowy adres URL używany podczas generowania adresu URL w czasie wykonywania. |
| `valid_hostnames` | pusty | Lista dozwolonych gospodarzy. Pusty oznacza brak jawnej listy nazw hostów. |
| `server_protocol` | `http` | Domyślny protokół używany w generowanych adresach URL. |
| `server_offset_time` | `0` | Przesunięcie czasu serwera w sekundach. |
| `datetime_format` | `dd-mm-YYYY` | Manager format wyświetlania daty/godziny. |

## Wartości domyślne Resource

| Ustawienie | Domyślne | Znaczenie |
| --- | --- | --- |
| `default_template` | `0` | Domyślny szablon dla nowych zasobów. |
| `publish_default` | `0` | Określa, czy nowe zasoby są domyślnie publikowane. |
| `cache_default` | `1` | Określa, czy nowe zasoby mają być domyślnie buforowane. |
| `search_default` | `1` | Określa, czy domyślnie można przeszukiwać nowe zasoby. |
| `auto_menuindex` | `1` | Automatycznie przypisuj wartości indeksów menu. |
| `resource_tree_node_name` | `pagetitle` | Pole Resource używane jako etykieta węzła drzewa. |
| `tree_page_click` | `27` | Akcja Manager otwierana po kliknięciu węzła drzewa zasobów. |
| `tree_show_protected` | `0` | Czy chronione zasoby są widoczne w drzewie. |
| `show_meta` | `0` | Określa, czy pola metadanych są domyślnie wyświetlane. |
| `show_newresource_btn` | `1` | Określa, czy wyświetlany jest przycisk nowego zasobu. |

## Domyślne ustawienia przyjaznego adresu URL

| Ustawienie | Domyślne | Znaczenie |
| --- | --- | --- |
| `friendly_urls` | `0` | Przyjazne adresy URL są domyślnie wyłączone. |
| `friendly_url_prefix` | pusty | Prefiks dodany do przyjaznych adresów URL. |
| `friendly_url_suffix` | `/` | Sufiks dodany do przyjaznych adresów URL. |
| `friendly_alias_urls` | `1` | Adresy URL oparte na aliasach są włączone. |
| `use_alias_path` | `1` | Aliasy nadrzędne są uwzględniane w wygenerowanych ścieżkach. |
| `make_folders` | `0` | Zachowanie adresu URL przypominające folder jest domyślnie wyłączone. |
| `seostrict` | `0` | Ścisła obsługa adresów URL SEO jest domyślnie wyłączona. |
| `aliaslistingfolder` | `0` | Zachowanie folderu z listą aliasów jest domyślnie wyłączone. |
| `allow_duplicate_alias` | `0` | Zduplikowane aliasy są domyślnie blokowane. |
| `automatic_alias` | `1` | Automatyczne generowanie aliasów jest włączone. |
| `xhtml_urls` | `1` | Włączone są adresy URL w stylu XHTML. |

## Domyślne ustawienia parsera i pamięci podręcznej| Ustawienie | Domyślne | Znaczenie |
| --- | --- | --- |
| `enable_cache` | `1` | Pamięć podręczna środowiska wykonawczego jest domyślnie włączona. |
| `cache_type` | `1` | Domyślny tryb zaplecza pamięci podręcznej. |
| `chunk_processor` | `DLTemplate` | Domyślnie używany procesor Chunk. |
| `enable_bindings` | `1` | Składnia powiązania jest włączona. |
| `enable_at_syntax` | `0` | Składnia warunkowa `@` jest domyślnie wyłączona. |
| `allow_eval` | `with_scan` | Podczas skanowania dozwolone jest zachowanie Eval. |
| `safe_functions_at_eval` | `time,date,strtotime,strftime` | Bezpieczne funkcje do analizowania związanego z ewaluacją. |
| `minifyphp_incache` | `0` | Minifikacja PHP w pamięci podręcznej jest wyłączona. |
| `html_comment` | pusty | Opcjonalne komentarze debugowania analizatora składni. |

Zobacz [Odniesienie do tagów parsera](parser-tags.md) przed udokumentowaniem składni szablonu
lub zachowanie parsera.

## Domyślne ustawienia interfejsu Manager

| Ustawienie | Domyślne | Znaczenie |
| --- | --- | --- |
| `use_editor` | `1` | Edycja tekstu sformatowanego jest włączona. |
| `which_editor` | `TinyMCE4` | Domyślny klucz edytora tekstu sformatowanego. |
| `tinymce4_theme` | `custom` | Domyślne ustawienie motywu TinyMCE. |
| `tinymce4_skin` | `lightgray` | Domyślna skórka TinyMCE. |
| `manager_theme_mode` | `3` | Domyślny tryb motywu menedżera. |
| `manager_menu_position` | `top` | Pozycja menu Manager. |
| `manager_menu_height` | `2.2` | Wysokość menu Manager w `rem`. |
| `manager_tree_width` | `20` | Szerokość drzewa Manager w `rem`. |
| `login_form_position` | `left` | Pozycja układu formularza logowania. |
| `login_form_style` | `dark` | Styl formularza logowania. |
| `manager_login_startup` | `0` | Domyślne zachowanie menedżera podczas uruchamiania po zalogowaniu. |
| `use_breadcrumbs` | `0` | Bułka tarta domyślnie wyłączona. |
| `remember_last_tab` | `0` | Manager domyślnie nie zapamiętuje ostatniej karty. |
| `global_tabs` | `1` | Karty globalne włączone. |
| `group_tvs` | `0` | Template Variables nie są domyślnie grupowane. |
| `show_picker` | `0` | Interfejs selektora jest domyślnie wyłączony. |
| `show_fullscreen_btn` | `0` | Przycisk pełnoekranowy domyślnie ukryty. |

## Domyślne ustawienia pliku i przesyłania

| Ustawienie | Domyślne | Znaczenie |
| --- | --- | --- |
| `filemanager_path` | `[(base_path)]` | Podstawowa ścieżka menedżera plików. |
| `rb_base_dir` | `[(base_path)]assets/` | Katalog podstawowy przeglądarki Resource. |
| `rb_base_url` | `assets/` | Podstawowy adres URL przeglądarki Resource. |
| `use_browser` | `1` | Przeglądarka Resource włączona. |
| `which_browser` | `mcpuk` | Domyślna implementacja przeglądarki zasobów. |
| `rb_webuser` | `0` | Tryb przeglądarki internetowej użytkownika wyłączony. |
| `upload_maxsize` | `5000000` | Limit rozmiaru przesyłania w bajtach. |
| `new_file_permissions` | `0644` | Uprawnienia do nowo utworzonych plików. |
| `new_folder_permissions` | `0755` | Uprawnienia do nowo utworzonych folderów. |
| `clean_uploaded_filename` | `1` | Przesłane nazwy plików są czyszczone. |
| `strip_image_paths` | `1` | Ścieżki obrazu są usuwane w wybranych wyjściach. |
| `denyZipDownload` | `0` | Pobieranie ZIP jest domyślnie dozwolone. |
| `denyExtensionRename` | `0` | Blokowanie zmiany nazwy rozszerzenia jest domyślnie wyłączone. |
| `showHiddenFiles` | `0` | Ukryte pliki nie są domyślnie wyświetlane. |
| `snapshot_path` | `[(base_path)]assets/backup/` | Domyślna ścieżka migawki/kopii zapasowej. |

Domyślne listy dozwolonych przesyłania są celowo szerokie, aby zapewnić zgodność ze starszymi wersjami.
Projekty powinny je zaostrzyć pod kątem polityki produkcyjnej.

## Domyślne ustawienia zabezpieczeń i dostępu

| Ustawienie | Domyślne | Znaczenie |
| --- | --- | --- |
| `use_udperms` | `1` | Uprawnienia użytkownika/dokumentu są włączone. |
| `udperms_allowroot` | `0` | Dostęp root poprzez uprawnienia do dokumentu jest wyłączony. |
| `failed_login_attempts` | `3` | Nieudane próby logowania, zanim zostanie zastosowane zachowanie blokujące. |
| `blocked_minutes` | `10` | Czas trwania blokady logowania w minutach. |
| `session_timeout` | `15` | Manager Przekroczono limit czasu sesji w minutach. |
| `validate_referer` | `1` | Weryfikacja strony odsyłającej włączona. |
| `use_captcha` | `0` | Captcha domyślnie wyłączona. |
| `pwd_hash_algo` | `0` | Domyślne ustawienie algorytmu skrótu hasła. |
| `check_files_onlogin` | lista plików podstawowych | Pliki sprawdzone po zalogowaniu się menedżera. |
| `warning_visibility` | `1` | Widoczne ostrzeżenia Manager. |
| `send_errormail` | `0` | Błąd wysyłania wiadomości e-mail wyłączony. |
| `error_reporting` | `1` | Domyślne ustawienie raportowania błędów. |

## Domyślne ustawienia poczty| Ustawienie | Domyślne | Znaczenie |
| --- | --- | --- |
| `emailsender` | `you@example.com` | Domyślny adres nadawcy. |
| `email_sender_method` | `1` | Ustawienie metody nadawcy. |
| `email_method` | `mail` | Domyślny transport poczty. |
| `smtp_host` | `smtp.example.com` | Domyślny symbol zastępczy hosta SMTP. |
| `smtp_port` | `25` | Domyślny port SMTP. |
| `smtp_auth` | `0` | Uwierzytelnianie SMTP wyłączone. |
| `smtp_username` | `emailsender` | Domyślny symbol zastępczy nazwy użytkownika SMTP. |
| `smtp_secure` | pusty | Domyślnie brak trybu szyfrowania SMTP. |

## Zasada dokumentacji

Dokumentując ustawienie, dołącz bieżące ustawienie domyślne dopiero po sprawdzeniu
ustawienia fabryczne lub zainstaluj ścieżkę nasion. Jeśli projekt zastępuje ustawienie poprzez
bazy danych lub środowiska, nie dokumentuj zastąpienia w dokumentacji projektu
w tym numerze produktu.
