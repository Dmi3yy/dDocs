<?php
/**
 * Documentation browser module.
 */

use Dmi3yy\dDocs\Support\ManagerText;

if (!defined('IN_MANAGER_MODE') || IN_MANAGER_MODE != 'true') {
    die('No access');
}

$moduleUrl = (string) ($_SERVER['REQUEST_URI'] ?? '');
$activeTab = request()->get('get', 'docs');
$labels = ManagerText::all();

$tabs = [
    [
        'key' => 'docs',
        'icon' => 'book-2',
        'label' => e($labels['module_title'] ?? $labels['docs'] ?? 'Documentation'),
    ],
];

if (evo()->hasPermission('settings')) {
    $tabs[] = [
        'key' => 'settings',
        'icon' => 'adjustments-horizontal',
        'label' => e(__('global.settings_config') !== 'global.settings_config' ? __('global.settings_config') : ($labels['settings'] ?? 'Settings')),
    ];
}

$_SESSION['itemaction'] = 'Viewing documentation';
$_SESSION['itemname'] = $labels['module_title'] ?? $labels['docs'] ?? 'Documentation';

echo view('dDocs::docs.shell', [
    'tabs' => $tabs,
    'moduleUrl' => $moduleUrl,
    'activeTab' => $activeTab,
    'ui' => $labels,
])->render();
