<?php

$boolean = ['boolean'];
$text = ['nullable', 'string', 'max:255'];
$label = static fn (string $key): string => \Dmi3yy\dDocs\Support\ManagerText::get($key);

return [
    'key' => 'ddocs-settings',
    'title' => $label('settings'),
    'icon' => 'adjustments-horizontal',
    'variant' => 'config',
    'section_headers' => true,
    'source' => [
        'type' => 'config',
        'file' => 'custom/config/dmi3yy/settings/dDocs.php',
        'root' => 'dmi3yy.settings.dDocs',
    ],
    'actions' => [],
    'tabs' => [],
    'sections' => [
        [
            'key' => 'general',
            'label' => $label('settings_general'),
            'icon' => 'sliders',
            'span' => 6,
            'fields' => [
                ['name' => 'enabled', 'label' => $label('enabled'), 'type' => 'checkbox', 'default' => 1, 'rules' => $boolean],
                ['name' => 'language_fallback', 'label' => $label('language_fallback'), 'type' => 'text', 'default' => 'en', 'rules' => $text],
                ['name' => 'default_language', 'label' => $label('default_language'), 'type' => 'text', 'default' => '', 'rules' => $text],
                ['name' => 'allowed_extensions', 'label' => $label('allowed_extensions'), 'type' => 'text', 'default' => 'md,mdx', 'rules' => $text],
                ['name' => 'allowed_image_extensions', 'label' => $label('allowed_image_extensions'), 'type' => 'text', 'default' => 'png,jpg,jpeg,gif,webp', 'rules' => $text],
                ['name' => 'max_file_size_kb', 'label' => $label('max_file_size_kb'), 'type' => 'number', 'default' => 512, 'min' => 1, 'rules' => ['integer', 'min:1']],
            ],
        ],
        [
            'key' => 'cache',
            'label' => $label('settings_cache'),
            'icon' => 'database-off',
            'span' => 6,
            'fields' => [
                ['name' => 'cache_index', 'label' => $label('cache_index'), 'type' => 'checkbox', 'default' => 0, 'rules' => $boolean],
                ['name' => 'index_cache_path', 'label' => $label('index_cache_path'), 'type' => 'text', 'default' => '', 'rules' => $text],
            ],
        ],
        [
            'key' => 'sources',
            'label' => $label('settings_sources'),
            'icon' => 'folders',
            'span' => 6,
            'fields' => [
                ['name' => 'scan_vendor_packages', 'label' => $label('scan_vendor_packages'), 'type' => 'checkbox', 'default' => 1, 'rules' => $boolean],
                ['name' => 'scan_project_docs', 'label' => $label('scan_project_docs'), 'type' => 'checkbox', 'default' => 1, 'rules' => $boolean],
                ['name' => 'safe_roots', 'label' => $label('safe_roots'), 'type' => 'textarea', 'default' => '', 'rules' => ['nullable', 'string', 'ddocs_path_list'], 'hint' => $label('path_list_hint')],
                ['name' => 'extra_docs_roots', 'label' => $label('extra_docs_roots'), 'type' => 'textarea', 'default' => '', 'rules' => ['nullable', 'string', 'ddocs_path_list'], 'hint' => $label('path_list_hint')],
                ['name' => 'show_internal_task_docs', 'label' => $label('show_internal_task_docs'), 'type' => 'checkbox', 'default' => 0, 'rules' => $boolean],
                ['name' => 'show_evolution_docs', 'label' => $label('show_evolution_docs'), 'type' => 'checkbox', 'default' => 0, 'rules' => $boolean],
            ],
        ],
    ],
];
