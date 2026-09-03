@php
    $isFolder = ($node['type'] ?? '') === 'folder';
    $children = $node['children'] ?? [];
    $expanded = (bool) ($node['expanded'] ?? false);
    $source = ($node['parent_id'] ?? null) === null;
    $padding = max(0, (int) $level) * 0.35;
    $sourceIcon = preg_replace('/^tabler-/', '', (string) ($node['icon'] ?? $node['source_icon'] ?? 'package'));
@endphp

<div class="ddocs-tree__item" wire:key="ddocs-tree-node-{{ $node['id'] }}-{{ $expanded ? 'open' : 'closed' }}">
    <button
        type="button"
        class="ddocs-tree__row {{ $source ? 'is-source' : '' }} {{ $isFolder ? 'is-folder' : 'is-document' }} {{ !empty($node['active']) ? 'is-active' : '' }}"
        style="padding-left: {{ .5 + $padding }}rem"
        x-on:contextmenu.prevent.stop="$dispatch('ddocs-node-menu', { originalEvent: $event, node: { id: @js($node['id']), type: @js($node['type'] ?? ''), title: @js($node['title'] ?? ''), path: @js($node['relative_path'] ?? ''), sourceName: @js($node['source_name'] ?? ''), packageName: @js($node['package_name'] ?? ''), readonly: @js((bool) ($node['readonly'] ?? true)), deletable: @js(!($node['readonly'] ?? true) && ($node['parent_id'] ?? null) !== null) } })"
        @if($isFolder)
            wire:click.stop="toggleFolder(@js($node['id']))"
            aria-expanded="{{ $expanded ? 'true' : 'false' }}"
        @else
            x-on:click.stop="openDoc(@js($node['id']))"
        @endif
    >
        <span class="ddocs-tree__twisty" aria-hidden="true">
            @if($isFolder && count($children) > 0)
                <x-evo::icon :name="$expanded ? 'chevron-down' : 'chevron-right'" />
            @endif
        </span>
        @include('dDocs::partials.source-icon', ['sourceIcon' => $isFolder ? ($source ? $sourceIcon : 'folder') : 'file-text'])
        <span class="ddocs-tree__title" title="{{ $node['title'] }}">{{ $node['title'] }}</span>
        @if($isFolder && ($node['document_count'] ?? 0) > 0)
            <span class="ddocs-tree__badge">{{ $node['document_count'] }}</span>
        @endif
    </button>

    @if($isFolder && $expanded && count($children) > 0)
        <div class="ddocs-tree__children">
            @foreach($children as $child)
                @include('dDocs::partials.tree-node', ['node' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
