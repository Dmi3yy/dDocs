<section
    class="ddocs-workspace"
    data-ddocs-workspace
    x-data="{
        menu: { open: false, x: 0, y: 0, node: null },
        createDialog: { open: false, type: 'folder', nodeId: null, name: '' },
        deleteDialog: { open: false, node: null },
        init() {
            const doc = new URLSearchParams((window.location.hash || '').replace(/^#/, '')).get('doc');
            if (doc) {
                this.openDoc(doc, false);
            }
        },
        openDoc(id, updateHash = true) {
            id = String(id || '').trim();
            if (!id) {
                return;
            }

            if (updateHash) {
                history.replaceState(null, '', '#doc=' + encodeURIComponent(id));
            }

            this.$wire.selectDocument(id);
        },
        openFolder(id, updateHash = true) {
            id = String(id || '').trim();
            if (!id) {
                return;
            }

            if (updateHash) {
                history.replaceState(null, '', window.location.pathname + window.location.search);
            }

            this.$wire.selectFolder(id);
        },
        openHome(updateHash = true) {
            if (updateHash) {
                history.replaceState(null, '', window.location.pathname + window.location.search);
            }

            this.$wire.selectHome();
        },
        openTreeMenu(event) {
            const detail = event.detail || {};
            this.menu = {
                open: true,
                x: event.detail.originalEvent ? event.detail.originalEvent.clientX : 0,
                y: event.detail.originalEvent ? event.detail.originalEvent.clientY : 0,
                node: detail.node || null
            };
        },
        closeTreeMenu() {
            this.menu.open = false;
        },
        closeMenus() {
            this.closeTreeMenu();
            this.closeCreateDialog();
            this.closeDeleteDialog();
        },
        openCreateDialog(type = 'folder', nodeId = null) {
            this.createDialog = { open: true, type: type, nodeId: nodeId, name: '' };
            this.closeTreeMenu();
            this.$nextTick(() => this.$refs.createNameInput && this.$refs.createNameInput.focus());
        },
        closeCreateDialog() {
            this.createDialog.open = false;
        },
        submitCreateDialog() {
            const name = String(this.createDialog.name || '').trim();
            if (!name) {
                return;
            }

            if (this.createDialog.type === 'document') {
                if (this.createDialog.nodeId) {
                    this.$wire.createDocumentIn(this.createDialog.nodeId, name);
                } else {
                    this.$wire.createDocument(name);
                }
            } else if (this.createDialog.nodeId) {
                this.$wire.createFolderIn(this.createDialog.nodeId, name);
            } else {
                this.$wire.createFolder(name);
            }

            this.closeCreateDialog();
        },
        openDeleteDialog(node) {
            if (!node || !node.deletable) {
                return;
            }

            this.deleteDialog = { open: true, node: node };
            this.closeTreeMenu();
        },
        closeDeleteDialog() {
            this.deleteDialog.open = false;
        },
        submitDeleteDialog() {
            if (!this.deleteDialog.node || !this.deleteDialog.node.id) {
                return;
            }

            this.$wire.deleteNode(this.deleteDialog.node.id);
            this.closeDeleteDialog();
        },
        openMenuNode() {
            if (!this.menu.node) {
                return;
            }

            if (this.menu.node.type === 'document') {
                this.openDoc(this.menu.node.id);
            } else {
                this.$wire.toggleFolder(this.menu.node.id);
            }

            this.closeTreeMenu();
        },
        copyMenuPath() {
            if (!this.menu.node) {
                return;
            }

            const source = String(this.menu.node.packageName || this.menu.node.sourceName || '').replace(/^\/+|\/+$/g, '');
            const relative = String(this.menu.node.path || '').replace(/^\/+|\/+$/g, '');
            const root = source.toLowerCase().endsWith('/docs') ? source : [source, 'docs'].filter(Boolean).join('/');
            const value = [root, relative].filter(Boolean).join('/');

            navigator.clipboard?.writeText(value);
            this.closeTreeMenu();
        },
        saveEditor() {
            const textarea = this.$root.querySelector('textarea[data-ddocs-editor]');
            const editor = textarea && window.dTuiEditor && window.dTuiEditor.get ? window.dTuiEditor.get(textarea) : null;
            const markdown = editor && editor.getMarkdown ? editor.getMarkdown() : (textarea && window.dTuiEditor && window.dTuiEditor.getValue ? window.dTuiEditor.getValue(textarea) : null);
            if (markdown !== null) {
                this.$wire.set('editingMarkdown', markdown).then(() => this.$wire.saveDocument());
                return;
            }

            this.$wire.saveDocument();
        }
    }"
    x-on:click="const link = $event.target.closest('a[data-ddocs-document-id], a[data-ddocs-missing-link]'); if (link) { $event.preventDefault(); if (link.dataset.ddocsDocumentId) { openDoc(link.dataset.ddocsDocumentId); } }"
    x-on:click.window="closeTreeMenu()"
    x-on:keydown.escape.window="closeMenus()"
    x-on:ddocs-node-menu.window="openTreeMenu($event)"
>
    <div class="ddocs-workspace__body">
        <aside class="ddocs-workspace__sidebar">
            <div class="ddocs-toolbar">
                <div class="ddocs-add" aria-label="{{ $ui['authoring_actions'] ?? 'Document authoring actions' }}">
                    <button type="button" class="evo-ui-btn evo-ui-btn--icon ddocs-add__trigger" title="{{ $canCreateRootFolder ? ($ui['create_folder'] ?? 'Create folder') : ($ui['readonly_action_hint'] ?? 'Select a writable project docs folder first') }}" aria-label="{{ $ui['create_folder'] ?? 'Create folder' }}" x-on:click.stop="openCreateDialog('folder')" @disabled(!$canCreateRootFolder)>
                        <x-evo::icon name="folder-plus" />
                    </button>
                    <button type="button" class="evo-ui-btn evo-ui-btn--icon ddocs-add__trigger" title="{{ $canCreateRootFolder ? ($ui['create_document'] ?? 'Create document') : ($ui['readonly_action_hint'] ?? 'Select a writable project docs folder first') }}" aria-label="{{ $ui['create_document'] ?? 'Create document' }}" x-on:click.stop="openCreateDialog('document')" @disabled(!$canCreateRootFolder)>
                        <x-evo::icon name="file-plus" />
                    </button>
                </div>
                <label class="ddocs-search">
                    <x-evo::icon name="search" />
                    <input
                        type="search"
                        class="evo-ui-input"
                        placeholder="{{ $ui['search_placeholder'] ?? 'Search docs' }}"
                        autocomplete="off"
                        wire:model.live.debounce.300ms="search"
                    >
                </label>
                @if(trim($search) !== '')
                    <div class="ddocs-search__meta">
                        {{ \Dmi3yy\dDocs\Support\ManagerText::choice('search_results', $visibleDocumentCount) }}
                    </div>
                @endif
            </div>

            <div class="ddocs-tree-shell">
                @if($documentCount === 0 || (trim($search) !== '' && $visibleDocumentCount === 0))
                    <div class="ddocs-empty">
                        <x-evo::icon name="folders" />
                        <span>{{ trim($search) !== '' ? ($ui['no_search_results'] ?? 'No documents match this search.') : ($ui['tree_placeholder'] ?? 'Documentation tree will appear here.') }}</span>
                    </div>
                @else
                    <nav class="ddocs-tree" aria-label="{{ $ui['docs_tree'] ?? 'Documentation tree' }}">
                        @foreach($tree as $node)
                            @include('dDocs::partials.tree-node', ['node' => $node, 'level' => 0])
                        @endforeach
                    </nav>
                @endif
            </div>
        </aside>

        @php
            $viewerFrameKey = $document
                ? 'document-' . (string) ($document['id'] ?? '') . '-' . ($isEditing ? 'edit' : (($document['readable'] ?? false) ? 'view' : 'blocked'))
                : ($folder ? 'folder-' . (string) ($folder['id'] ?? '') : 'home');
        @endphp
        <main class="ddocs-workspace__viewer">
            <div class="ddocs-viewer-frame" wire:key="ddocs-viewer-frame-{{ $viewerFrameKey }}-{{ $refreshToken }}">
            @if($document)
                <article class="ddocs-document {{ $isEditing ? 'is-editing' : '' }}" wire:key="ddocs-document-{{ $document['id'] }}-{{ $isEditing ? 'edit' : (($document['readable'] ?? false) ? 'view' : 'blocked') }}-{{ $refreshToken }}">
                    <header class="ddocs-document__header">
                        <div>
                            <h2>{{ $document['title'] }}</h2>
                            @if(count($documentBreadcrumbs ?? []) > 0)
                                <nav class="ddocs-breadcrumbs" aria-label="{{ $ui['breadcrumbs'] ?? 'Breadcrumbs' }}">
                                    <button type="button" class="ddocs-breadcrumbs__item ddocs-breadcrumbs__home" title="{{ $ui['module_title'] ?? $ui['docs'] ?? 'Documentation' }}" aria-label="{{ $ui['module_title'] ?? $ui['docs'] ?? 'Documentation' }}" x-on:click.prevent.stop="$event.currentTarget.blur(); openHome()">
                                        <x-evo::icon :name="$homeBreadcrumbIcon" />
                                    </button>
                                    @foreach($documentBreadcrumbs as $crumb)
                                        @if($crumb['clickable'])
                                            <button type="button" class="ddocs-breadcrumbs__item" x-on:click.prevent.stop="$event.currentTarget.blur(); openFolder(@js($crumb['id']))">
                                                {{ $crumb['label'] }}
                                            </button>
                                        @else
                                            <span class="ddocs-breadcrumbs__item {{ $crumb['current'] ? 'is-current' : '' }}">
                                                {{ $crumb['label'] }}
                                            </span>
                                        @endif
                                    @endforeach
                                </nav>
                            @endif
                        </div>
                        <div class="ddocs-document__actions" aria-label="{{ $ui['document_actions'] ?? 'Document actions' }}">
                            <button type="button" class="evo-ui-btn evo-ui-btn--icon evo-ui-btn--info ddocs-header-action ddocs-header-action--copy" title="{{ $ui['copy_markdown'] ?? 'Copy Markdown' }}" aria-label="{{ $ui['copy_markdown'] ?? 'Copy Markdown' }}" x-on:click="navigator.clipboard?.writeText(@js($document['markdown'] ?? ''))">
                                <x-evo::icon name="copy" />
                            </button>
                            @if($isEditing)
                                <button type="button" class="evo-ui-btn evo-ui-btn--icon evo-ui-btn--primary ddocs-header-action" title="{{ $ui['save'] ?? 'Save' }}" aria-label="{{ $ui['save'] ?? 'Save' }}" x-on:click="saveEditor()">
                                    <x-evo::icon name="check" />
                                </button>
                            @elseif($canEditSelectedDocument)
                                <button type="button" class="evo-ui-btn evo-ui-btn--icon evo-ui-btn--primary ddocs-header-action" title="{{ $ui['edit_document'] ?? 'Edit document' }}" aria-label="{{ $ui['edit_document'] ?? 'Edit document' }}" wire:click="editDocument(@js($document['id']))">
                                    <x-evo::icon name="edit" />
                                </button>
                            @endif
                            <button type="button" class="evo-ui-btn evo-ui-btn--icon ddocs-header-action" title="{{ $ui['settings'] ?? 'Settings' }}" aria-label="{{ $ui['settings'] ?? 'Settings' }}" wire:click="switchTab('settings')">
                                <x-evo::icon name="adjustments-horizontal" />
                            </button>
                        </div>
                    </header>

                    @if($isEditing)
                        @php
                            $editorId = 'ddocs-editor-markdown-' . md5((string) $editingDocumentId);
                        @endphp
                        <div class="ddocs-editor" wire:key="ddocs-editor-shell-{{ md5((string) $editingDocumentId) }}">
                            <textarea
                                id="{{ $editorId }}"
                                name="ddocs-editor-markdown"
                                class="ddocs-editor__textarea"
                                wire:key="ddocs-editor-{{ md5((string) $editingDocumentId) }}"
                                wire:model.defer="editingMarkdown"
                                data-ddocs-editor
                            >{{ $editingMarkdown }}</textarea>
                        </div>
                    @elseif(!($document['readable'] ?? false))
                        <div class="ddocs-viewer-empty" wire:key="ddocs-document-blocked-{{ $document['id'] }}">
                            <x-evo::icon name="lock" />
                            <h2>{{ $ui['document_not_readable'] ?? 'Document cannot be read' }}</h2>
                            <p>{{ $ui['document_not_readable_help'] ?? 'The file is outside safe roots, too large, or uses an unsupported extension.' }}</p>
                        </div>
                    @else
                        @php
                            $viewerPayloadId = 'ddocs-viewer-payload-' . md5((string) ($document['id'] ?? '') . '|' . (string) ($document['mtime'] ?? '') . '|' . (string) ($document['checksum'] ?? ''));
                            $viewerPayload = [
                                'id' => (string) ($document['id'] ?? ''),
                                'markdown' => (string) ($document['markdown'] ?? ''),
                                'links' => $document['link_map'] ?? [],
                                'images' => $document['image_map'] ?? [],
                                'uml' => $document['uml_map'] ?? [],
                            ];
                        @endphp
                        <div class="ddocs-viewer-shell" wire:key="ddocs-viewer-shell-{{ $viewerPayloadId }}">
                            <script type="application/json" id="{{ $viewerPayloadId }}">{!! json_encode($viewerPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
                            <div
                                class="ddocs-markdown toastui-editor-contents"
                                wire:ignore
                                data-ddocs-viewer
                                data-ddocs-payload-id="{{ $viewerPayloadId }}"
                            >
                            </div>
                        </div>
                    @endif
                </article>
            @elseif($folder)
                <article class="ddocs-document ddocs-folder-view" wire:key="ddocs-folder-{{ $folder['id'] }}-{{ $refreshToken }}">
                    <header class="ddocs-document__header">
                        <div>
                            <h2>{{ $folder['title'] }}</h2>
                            @if(count($folderBreadcrumbs ?? []) > 0)
                                <nav class="ddocs-breadcrumbs" aria-label="{{ $ui['breadcrumbs'] ?? 'Breadcrumbs' }}">
                                    <button type="button" class="ddocs-breadcrumbs__item ddocs-breadcrumbs__home" title="{{ $ui['module_title'] ?? $ui['docs'] ?? 'Documentation' }}" aria-label="{{ $ui['module_title'] ?? $ui['docs'] ?? 'Documentation' }}" x-on:click.prevent.stop="$event.currentTarget.blur(); openHome()">
                                        <x-evo::icon :name="$homeBreadcrumbIcon" />
                                    </button>
                                    @foreach($folderBreadcrumbs as $crumb)
                                        @if($crumb['clickable'])
                                            <button type="button" class="ddocs-breadcrumbs__item" x-on:click.prevent.stop="$event.currentTarget.blur(); openFolder(@js($crumb['id']))">
                                                {{ $crumb['label'] }}
                                            </button>
                                        @else
                                            <span class="ddocs-breadcrumbs__item {{ $crumb['current'] ? 'is-current' : '' }}">
                                                {{ $crumb['label'] }}
                                            </span>
                                        @endif
                                    @endforeach
                                    <span class="ddocs-breadcrumbs__count">{{ \Dmi3yy\dDocs\Support\ManagerText::choice('search_results', (int) ($folder['document_count'] ?? 0)) }}</span>
                                </nav>
                            @endif
                        </div>
                        <div class="ddocs-document__actions" aria-label="{{ $ui['document_actions'] ?? 'Document actions' }}">
                            <button type="button" class="evo-ui-btn evo-ui-btn--icon ddocs-header-action" title="{{ $ui['settings'] ?? 'Settings' }}" aria-label="{{ $ui['settings'] ?? 'Settings' }}" wire:click="switchTab('settings')">
                                <x-evo::icon name="adjustments-horizontal" />
                            </button>
                        </div>
                    </header>

                    <div class="ddocs-folder-listing">
                        @if(count($folder['folders'] ?? []) === 0 && count($folder['documents'] ?? []) === 0)
                            <div class="ddocs-viewer-empty">
                                <x-evo::icon name="folder-open" />
                                <h2>{{ $ui['folder_empty_title'] ?? 'Folder is empty' }}</h2>
                                <p>{{ $ui['folder_empty_help'] ?? 'This folder has no visible documents for the current language.' }}</p>
                            </div>
                        @else
                            @if(count($folder['documents'] ?? []) > 0)
                                <section class="ddocs-folder-section" aria-label="{{ $ui['folder_documents'] ?? 'Documents' }}">
                                    <h3>{{ $ui['folder_documents'] ?? 'Documents' }}</h3>
                                    <div class="ddocs-document-list">
                                        @foreach($folder['documents'] as $childDocument)
                                            <button type="button" class="ddocs-document-card" x-on:click.stop="openDoc(@js($childDocument['id']))">
                                                <span class="ddocs-document-card__title">
                                                    <x-evo::icon name="file-text" />
                                                    {{ $childDocument['title'] }}
                                                </span>
                                                <span class="ddocs-document-card__path">{{ $childDocument['relative_path'] }}</span>
                                                @if(($childDocument['excerpt'] ?? '') !== '')
                                                    <span class="ddocs-document-card__excerpt">{{ $childDocument['excerpt'] }}</span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                </section>
                            @endif

                            @if(count($folder['folders'] ?? []) > 0)
                                <section class="ddocs-folder-section" aria-label="{{ $ui['folder_subfolders'] ?? 'Folders' }}">
                                    <h3>{{ $ui['folder_subfolders'] ?? 'Folders' }}</h3>
                                    <div class="ddocs-folder-grid">
                                        @foreach($folder['folders'] as $childFolder)
                                            <button type="button" class="ddocs-folder-card" x-on:click.stop="openFolder(@js($childFolder['id']))">
                                                <x-evo::icon name="folder" />
                                                <span>{{ $childFolder['title'] }}</span>
                                                <small>{{ \Dmi3yy\dDocs\Support\ManagerText::choice('search_results', (int) ($childFolder['document_count'] ?? 0)) }}</small>
                                            </button>
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                        @endif
                    </div>
                </article>
            @else
                <article class="ddocs-document ddocs-folder-view ddocs-home-view" wire:key="ddocs-home-{{ $refreshToken }}">
                    <header class="ddocs-document__header">
                        <div>
                            <h2>{{ $home['title'] ?? ($ui['module_title'] ?? 'Documentation') }}</h2>
                        </div>
                        <div class="ddocs-document__actions" aria-label="{{ $ui['document_actions'] ?? 'Document actions' }}">
                            <button type="button" class="evo-ui-btn evo-ui-btn--icon ddocs-header-action" title="{{ $ui['settings'] ?? 'Settings' }}" aria-label="{{ $ui['settings'] ?? 'Settings' }}" wire:click="switchTab('settings')">
                                <x-evo::icon name="adjustments-horizontal" />
                            </button>
                        </div>
                    </header>

                    <div class="ddocs-folder-listing">
                        @if(count($home['sources'] ?? []) === 0)
                            <div class="ddocs-viewer-empty">
                                <x-evo::icon name="folders" />
                                <h2>{{ $ui['tree_placeholder'] ?? 'Documentation tree will appear here.' }}</h2>
                            </div>
                        @else
                            <section class="ddocs-folder-section" aria-label="{{ $ui['docs_tree'] ?? 'Documentation tree' }}">
                                <div class="ddocs-source-grid">
                                    @foreach($home['sources'] as $sourceNode)
                                        @php
                                            $sourceIcon = preg_replace('/^tabler-/', '', (string) ($sourceNode['source_icon'] ?? $sourceNode['icon'] ?? 'package'));
                                        @endphp
                                        <button type="button" class="ddocs-folder-card ddocs-source-card" x-on:click.prevent.stop="openFolder(@js($sourceNode['id']))">
                                            <x-evo::icon :name="$sourceIcon" />
                                            <span class="ddocs-source-card__title">{{ $sourceNode['title'] }}</span>
                                            @if(trim((string) ($sourceNode['description'] ?? $sourceNode['source_description'] ?? '')) !== '')
                                                <span class="ddocs-source-card__description">{{ $sourceNode['description'] ?? $sourceNode['source_description'] }}</span>
                                            @endif
                                            <small class="ddocs-source-card__count" aria-label="{{ (int) ($sourceNode['document_count'] ?? 0) }}">
                                                <x-evo::icon name="file-text" />
                                                <span>{{ (int) ($sourceNode['document_count'] ?? 0) }}</span>
                                            </small>
                                        </button>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    </div>
                </article>
            @endif
            </div>
        </main>
    </div>

    @if($activeTab === 'settings')
        <div class="ddocs-modal ddocs-settings-modal" x-cloak x-show="true" x-transition.opacity x-on:keydown.escape.window="$wire.switchTab('docs')">
            <div class="ddocs-modal__backdrop" wire:click="switchTab('docs')"></div>
            <section class="ddocs-modal__panel ddocs-settings-modal__panel" x-on:click.stop>
                <header class="ddocs-settings-modal__header">
                    <div class="ddocs-settings-modal__title">
                        <x-evo::icon name="adjustments-horizontal" />
                        <span>{{ $ui['settings'] ?? 'Settings' }}</span>
                    </div>
                    <div class="ddocs-settings-modal__actions">
                        <button
                            type="button"
                            class="evo-ui-btn evo-ui-btn--success ddocs-settings-modal__button"
                            wire:click="refreshIndex"
                            wire:loading.attr="disabled"
                            wire:target="refreshIndex"
                        >
                            <x-evo::icon name="refresh-ccw" />
                            <span wire:loading.remove wire:target="refreshIndex">{{ $ui['refresh_index'] ?? 'Refresh index' }}</span>
                            <span wire:loading wire:target="refreshIndex">{{ $ui['refreshing_index'] ?? 'Refreshing index' }}</span>
                        </button>
                        <a
                            href="{{ route('dDocs.exportMarkdown') }}"
                            class="evo-ui-btn ddocs-settings-modal__button"
                            title="{{ $ui['download_markdown'] ?? 'Download Markdown' }}"
                            aria-label="{{ $ui['download_markdown'] ?? 'Download Markdown' }}"
                        >
                            <x-evo::icon name="download" />
                            <span>{{ $ui['download_markdown'] ?? 'Download Markdown' }}</span>
                        </a>
                        <button type="submit" form="evo-ui-form-ddocs-settings" class="evo-ui-btn evo-ui-btn--primary ddocs-settings-modal__button">
                            <x-evo::icon name="check" />
                            <span>{{ $ui['save'] ?? 'Save' }}</span>
                        </button>
                        <button type="button" class="evo-ui-btn evo-ui-btn--icon ddocs-header-action" title="{{ $ui['cancel'] ?? 'Close' }}" aria-label="{{ $ui['cancel'] ?? 'Close' }}" wire:click="switchTab('docs')">
                            <x-evo::icon name="x" />
                        </button>
                    </div>
                </header>
                <section class="ddocs-settings evo-ui-surface">
                    @if($cacheMessage)
                        <div class="ddocs-settings__status">{{ $cacheMessage }}</div>
                    @endif
                    <livewire:evo-ui.form preset="ddocs.settings" wire:key="ddocs-settings-form" />
                </section>
            </section>
        </div>
    @endif
    <div
        class="ddocs-context-menu"
        x-show="menu.open"
        x-cloak
        x-on:click.stop
        x-bind:style="'left: ' + menu.x + 'px; top: ' + menu.y + 'px'"
        role="menu"
        aria-label="{{ $ui['context_menu'] ?? 'Context menu' }}"
    >
        <button type="button" role="menuitem" x-on:click="openMenuNode()">
            <x-evo::icon name="corner-down-right" />
            <span>{{ $ui['open_node'] ?? 'Open' }}</span>
        </button>
        <button type="button" role="menuitem" x-on:click="copyMenuPath()">
            <x-evo::icon name="copy" />
            <span>{{ $ui['copy_relative_path'] ?? 'Copy path' }}</span>
        </button>
        <template x-if="menu.node && !menu.node.readonly && menu.node.type === 'folder'">
            <div>
                <hr>
                <button type="button" role="menuitem" x-on:click="openCreateDialog('folder', menu.node && menu.node.id)">
                    <x-evo::icon name="folder-plus" />
                    <span>{{ $ui['create_folder'] ?? 'Create folder' }}</span>
                </button>
                <button type="button" role="menuitem" x-on:click="openCreateDialog('document', menu.node && menu.node.id)">
                    <x-evo::icon name="file-plus" />
                    <span>{{ $ui['create_document'] ?? 'Create document' }}</span>
                </button>
            </div>
        </template>
        <template x-if="menu.node && menu.node.deletable">
            <div>
                <hr>
                <button type="button" role="menuitem" class="is-danger" x-on:click="openDeleteDialog(menu.node)">
                    <x-evo::icon name="trash" />
                    <span>{{ $ui['delete_document'] ?? 'Delete' }}</span>
                </button>
            </div>
        </template>
    </div>

    <div class="ddocs-modal" x-cloak x-show="createDialog.open" x-transition.opacity>
        <div class="ddocs-modal__backdrop" x-on:click="closeCreateDialog()"></div>
        <form class="ddocs-modal__panel" x-on:submit.prevent="submitCreateDialog()" x-on:click.stop>
            <header class="ddocs-modal__header">
                <h2 x-text="createDialog.type === 'document' ? @js($ui['create_document'] ?? 'Create document') : @js($ui['create_folder'] ?? 'Create folder')"></h2>
            </header>
            <label class="ddocs-modal__field">
                <span x-text="createDialog.type === 'document' ? @js($ui['create_document_prompt'] ?? 'Document name') : @js($ui['create_folder_prompt'] ?? 'Folder name')"></span>
                <input
                    type="text"
                    class="evo-ui-input ddocs-modal__input"
                    x-ref="createNameInput"
                    x-model="createDialog.name"
                    autocomplete="off"
                >
            </label>
            <footer class="ddocs-modal__footer">
                <button type="button" class="evo-ui-btn" x-on:click="closeCreateDialog()">{{ $ui['cancel'] ?? 'Cancel' }}</button>
                <button type="submit" class="evo-ui-btn evo-ui-btn--primary">{{ $ui['create'] ?? $ui['add'] ?? 'Create' }}</button>
            </footer>
        </form>
    </div>

    <div class="ddocs-modal" x-cloak x-show="deleteDialog.open" x-transition.opacity>
        <div class="ddocs-modal__backdrop" x-on:click="closeDeleteDialog()"></div>
        <form class="ddocs-modal__panel" x-on:submit.prevent="submitDeleteDialog()" x-on:click.stop>
            <header class="ddocs-modal__header">
                <h2>{{ $ui['delete_document'] ?? 'Delete' }}</h2>
            </header>
            <div class="ddocs-modal__field">
                <span>{{ $ui['delete_confirm_help'] ?? 'This item will be removed from Project Docs.' }}</span>
                <strong x-text="deleteDialog.node ? deleteDialog.node.title : ''"></strong>
            </div>
            <footer class="ddocs-modal__footer">
                <button type="button" class="evo-ui-btn" x-on:click="closeDeleteDialog()">{{ $ui['cancel'] ?? 'Cancel' }}</button>
                <button type="submit" class="evo-ui-btn evo-ui-btn--danger">{{ $ui['delete_document'] ?? 'Delete' }}</button>
            </footer>
        </form>
    </div>
</section>

<style>
    html,
    body {
        height: 100%;
        overflow: hidden;
    }

    .ddocs-workspace {
        --ddocs-workspace-bg: var(--evo-ui-bg, #161a20);
        box-sizing: border-box;
        width: 100%;
        max-width: 100vw;
        min-width: 0;
        height: 100vh;
        min-height: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: var(--ddocs-workspace-bg);
        color: var(--evo-ui-text);
    }

    [x-cloak] {
        display: none !important;
    }

    .ddocs-workspace__body {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        min-height: 0;
        flex: 1;
        display: grid;
        grid-template-columns: minmax(18rem, 22rem) minmax(0, 1fr);
        overflow: hidden;
    }

    .ddocs-settings {
        flex: 1;
        min-height: 0;
        overflow: auto;
        padding: 1rem;
        border: 0;
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-settings__status {
        margin: 0 0 .75rem;
        padding: .55rem .7rem;
        border: 1px solid var(--evo-ui-border);
        border-radius: var(--evo-ui-radius);
        background: var(--evo-ui-surface);
        color: var(--evo-ui-muted);
        font-size: .875rem;
    }

    .ddocs-settings .evo-ui-form-heading,
    .ddocs-settings .evo-ui-form-tabs {
        display: none !important;
    }

    .ddocs-settings .evo-ui-form-surface {
        border: 0;
        background: transparent;
        box-shadow: none;
        padding: 0;
    }

    .ddocs-settings .evo-ui-form {
        max-width: none;
    }

    .ddocs-settings .evo-ui-form-tab-panel {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 1rem;
        align-items: start;
    }

    .ddocs-settings .evo-ui-form-tab-panel > .evo-ui-form-section:nth-of-type(1) {
        grid-column: 1;
        grid-row: 1;
    }

    .ddocs-settings .evo-ui-form-tab-panel > .evo-ui-form-section:nth-of-type(2) {
        grid-column: 1;
        grid-row: 2;
    }

    .ddocs-settings .evo-ui-form-tab-panel > .evo-ui-form-section:nth-of-type(3) {
        grid-column: 2;
        grid-row: 1 / span 2;
    }

    .ddocs-settings .evo-ui-form-section {
        margin: 0 !important;
        width: auto !important;
        max-width: none !important;
    }

    .ddocs-settings .evo-ui-form-actions {
        display: none !important;
    }

    .ddocs-workspace__sidebar {
        min-width: 0;
        min-height: 0;
        display: flex;
        flex-direction: column;
        border-right: 1px solid var(--evo-ui-border);
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-toolbar {
        min-height: 3.75rem;
        padding: .65rem .75rem;
        display: flex;
        gap: .5rem;
        align-items: center;
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-search {
        position: relative;
        display: flex;
        align-items: center;
        flex: 1 1 auto;
        min-width: 0;
        width: 100%;
    }

    .ddocs-search > svg {
        position: absolute;
        left: .75rem;
        top: 50%;
        width: 1rem;
        height: 1rem;
        transform: translateY(-50%);
        color: var(--evo-ui-muted);
        pointer-events: none;
    }

    .ddocs-search__meta {
        display: none;
        color: var(--evo-ui-muted);
        font-size: .75rem;
        line-height: 1;
    }

    .ddocs-search .evo-ui-input {
        width: 100%;
        height: 2.5rem;
        padding-left: 2.25rem;
    }

    .ddocs-add {
        position: relative;
        flex: 0 0 auto;
        width: auto;
        height: 2.5rem;
        display: flex;
        gap: .4rem;
    }

    .ddocs-add__trigger {
        width: 2.5rem;
        height: 2.5rem;
        flex: 0 0 2.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .ddocs-add__trigger svg {
        width: 1.25rem;
        height: 1.25rem;
        flex: 0 0 1.25rem;
        display: block;
    }

    .ddocs-add__trigger:disabled {
        opacity: .42;
        cursor: not-allowed;
    }

    .ddocs-add__menu {
        position: absolute;
        top: calc(100% + .35rem);
        right: 0;
        z-index: 30;
        width: 13rem;
        padding: .35rem;
        border: 1px solid var(--evo-ui-border);
        border-radius: var(--evo-ui-radius);
        background: var(--evo-ui-surface);
        box-shadow: 0 .75rem 1.5rem rgba(0, 0, 0, .18);
    }

    .ddocs-add__menu button {
        width: 100%;
        min-height: 2rem;
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .35rem .5rem;
        border: 0;
        border-radius: calc(var(--evo-ui-radius) - 2px);
        background: transparent;
        color: var(--evo-ui-text);
        text-align: left;
        cursor: pointer;
    }

    .ddocs-add__menu button:hover,
    .ddocs-add__menu button:focus-visible {
        background: var(--evo-ui-surface-muted);
        outline: 0;
    }

    .ddocs-context-menu {
        position: fixed;
        z-index: 50;
        width: min(16rem, calc(100vw - 1rem));
        padding: .35rem;
        border: 1px solid var(--evo-ui-border);
        border-radius: var(--evo-ui-radius);
        background: var(--evo-ui-surface);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, .22);
    }

    .ddocs-context-menu button {
        width: 100%;
        min-height: 2rem;
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .35rem .5rem;
        border: 0;
        border-radius: calc(var(--evo-ui-radius) - 2px);
        background: transparent;
        color: var(--evo-ui-text);
        text-align: left;
        cursor: pointer;
    }

    .ddocs-context-menu button:hover,
    .ddocs-context-menu button:focus-visible {
        background: color-mix(in srgb, var(--evo-ui-primary) 14%, var(--evo-ui-surface));
        color: var(--evo-ui-text);
        outline: 0;
    }

    .ddocs-context-menu button:hover svg,
    .ddocs-context-menu button:focus-visible svg {
        color: var(--evo-ui-primary);
    }

    .ddocs-context-menu button:active {
        background: color-mix(in srgb, var(--evo-ui-primary) 20%, var(--evo-ui-surface));
    }

    .ddocs-context-menu button.is-danger {
        color: var(--evo-ui-danger, #ef4444);
    }

    .ddocs-context-menu button:disabled {
        color: var(--evo-ui-muted);
        cursor: not-allowed;
        opacity: .52;
    }

    .ddocs-context-menu hr {
        margin: .35rem 0;
        border: 0;
        border-top: 1px solid var(--evo-ui-border);
    }

    .ddocs-tree-shell,
    .ddocs-workspace__viewer {
        min-width: 0;
        min-height: 0;
        overflow: auto;
        overflow-x: hidden;
        scrollbar-gutter: stable;
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-tree-shell {
        overflow-y: scroll;
        contain: layout paint;
    }

    .ddocs-workspace__viewer {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .ddocs-tree {
        padding: .5rem;
    }

    .ddocs-tree__item {
        margin: .125rem 0;
    }

    .ddocs-tree__row {
        width: 100%;
        min-height: 2rem;
        display: grid;
        grid-template-columns: 1.25rem 1.25rem minmax(0, 1fr) 2rem;
        align-items: center;
        gap: .45rem;
        padding: .35rem .5rem;
        border: 0;
        border-radius: var(--evo-ui-radius);
        background: transparent;
        color: var(--evo-ui-text);
        text-align: left;
        cursor: pointer;
    }

    .ddocs-tree__row:hover,
    .ddocs-tree__row:focus-visible,
    .ddocs-tree__row.is-active {
        background: var(--evo-ui-surface-muted);
        outline: 0;
    }

    .ddocs-tree__row.is-active {
        color: var(--evo-ui-primary);
        font-weight: 700;
    }

    .ddocs-tree__row.is-source {
        font-weight: 700;
    }

    .ddocs-tree__row.is-document {
        grid-template-columns: 1.25rem 1.25rem minmax(0, 1fr) 2rem;
    }

    .ddocs-tree__twisty {
        display: inline-flex;
        width: 1.25rem;
        height: 1.25rem;
        align-items: center;
        justify-content: center;
        color: var(--evo-ui-muted);
    }

    .ddocs-tree__twisty svg,
    .ddocs-tree__row > svg {
        width: 1.25rem;
        height: 1.25rem;
        flex: 0 0 1.25rem;
        display: block;
    }

    .ddocs-tree__title {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: .875rem;
    }

    .ddocs-tree__badge {
        box-sizing: border-box;
        width: 2rem;
        min-width: 2rem;
        padding: .1rem .4rem;
        border-radius: 999px;
        background: var(--evo-ui-surface-muted);
        color: var(--evo-ui-muted);
        font-size: .7rem;
        line-height: 1.2;
        text-align: center;
    }

    .ddocs-tree__children {
        margin-left: .7rem;
        padding-left: .45rem;
        border-left: 1px solid var(--evo-ui-border);
    }

    .ddocs-empty,
    .ddocs-viewer-empty {
        min-height: 12rem;
        display: grid;
        place-items: center;
        align-content: center;
        gap: .75rem;
        padding: 1.5rem;
        color: var(--evo-ui-muted);
        text-align: center;
    }

    .ddocs-viewer-empty {
        min-height: 100%;
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-viewer-empty h2 {
        margin: 0;
        color: var(--evo-ui-text);
        font-size: 1.125rem;
    }

    .ddocs-viewer-empty p {
        margin: 0;
        max-width: 24rem;
    }

    .ddocs-document {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        flex: 1 0 auto;
        min-height: 100%;
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-viewer-frame {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        min-height: 0;
        height: 100%;
        flex: 1 1 0;
        display: flex;
        flex-direction: column;
        overflow: auto;
        overflow-x: hidden;
    }

    .ddocs-document.is-editing {
        flex: 1 1 0;
        height: auto;
        min-height: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .ddocs-document__header {
        position: sticky;
        top: 0;
        z-index: 1;
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--evo-ui-border);
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-document__header h2 {
        margin: 0 0 .35rem;
        font-size: 1.25rem;
    }

    .ddocs-document__meta {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        color: var(--evo-ui-muted);
        font-size: .75rem;
    }

    .ddocs-document__actions {
        display: flex;
        align-items: center;
        gap: .35rem;
    }

    .ddocs-header-action {
        width: 2.25rem;
        height: 2.25rem;
        min-height: 2.25rem;
        padding: 0;
    }

    .ddocs-header-action--copy {
        border-color: color-mix(in srgb, #0ea5e9 58%, var(--evo-ui-border)) !important;
        background: color-mix(in srgb, #0ea5e9 14%, transparent) !important;
        color: #0ea5e9 !important;
    }

    .ddocs-header-action--copy:hover,
    .ddocs-header-action--copy:focus-visible {
        border-color: color-mix(in srgb, #0ea5e9 78%, var(--evo-ui-border)) !important;
        background: color-mix(in srgb, #0ea5e9 22%, transparent) !important;
        color: #38bdf8 !important;
    }

    .ddocs-breadcrumbs {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: .25rem;
        min-height: 1.45rem;
        color: var(--evo-ui-muted);
        font-size: .78rem;
        line-height: 1.45;
    }

    .ddocs-breadcrumbs__item,
    .ddocs-breadcrumbs__count {
        display: inline-flex;
        min-width: 0;
        min-height: 1.35rem;
        align-items: center;
        gap: .25rem;
        border: 0;
        padding: 0;
        background: transparent;
        color: inherit;
        font: inherit;
    }

    button.ddocs-breadcrumbs__item {
        appearance: none;
        border-radius: calc(var(--evo-ui-radius) - 3px);
        cursor: pointer;
        text-decoration: none !important;
    }

    button.ddocs-breadcrumbs__item:hover,
    button.ddocs-breadcrumbs__item:focus-visible {
        background: color-mix(in srgb, var(--evo-ui-surface-muted) 78%, transparent);
        color: var(--evo-ui-text);
        outline: 0;
        text-decoration: none !important;
    }

    .ddocs-breadcrumbs__item:not(:first-child)::before,
    .ddocs-breadcrumbs__count::before {
        content: "/";
        color: color-mix(in srgb, var(--evo-ui-muted) 68%, transparent);
    }

    .ddocs-breadcrumbs__item.is-current {
        max-width: 34rem;
        overflow: hidden;
        color: var(--evo-ui-text);
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .ddocs-breadcrumbs__home {
        flex: 0 0 auto;
        color: var(--evo-ui-muted);
        font-weight: 600;
    }

    .ddocs-breadcrumbs__home svg {
        width: 1rem;
        height: 1rem;
        flex: 0 0 1rem;
    }

    .ddocs-folder-listing {
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        max-inline-size: 100%;
        max-width: 72rem;
        overflow-x: hidden;
        padding: 1.25rem;
    }

    .ddocs-folder-section + .ddocs-folder-section {
        margin-top: 1.5rem;
    }

    .ddocs-folder-section h3 {
        margin: 0 0 .75rem;
        color: var(--evo-ui-muted);
        font-size: .8rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .ddocs-folder-grid,
    .ddocs-source-grid,
    .ddocs-document-list {
        display: grid;
        gap: .5rem;
    }

    .ddocs-folder-grid {
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 12rem), 1fr));
    }

    .ddocs-source-grid {
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 16rem), 1fr));
    }

    .ddocs-folder-card,
    .ddocs-document-card {
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        max-width: 100%;
        border: 1px solid var(--evo-ui-border);
        border-radius: var(--evo-ui-radius);
        background: var(--evo-ui-surface);
        color: var(--evo-ui-text);
        text-align: left;
        cursor: pointer;
    }

    .ddocs-folder-card {
        min-height: 3.75rem;
        display: grid;
        grid-template-columns: 1.25rem minmax(0, 1fr);
        gap: .35rem .5rem;
        align-items: center;
        padding: .6rem .7rem;
        user-select: none;
        transition: border-color .15s ease, background .15s ease, color .15s ease, transform .15s ease;
    }

    .ddocs-folder-card svg {
        width: 1.15rem;
        height: 1.15rem;
    }

    .ddocs-folder-card small {
        grid-column: 2;
        color: var(--evo-ui-muted);
        font-size: .75rem;
        line-height: 1.2;
    }

    .ddocs-document-card {
        position: relative;
        display: grid;
        gap: .3rem;
        padding: .8rem 4rem .8rem .9rem;
    }

    .ddocs-folder-card:hover,
    .ddocs-folder-card:focus-visible,
    .ddocs-document-card:hover,
    .ddocs-document-card:focus-visible {
        border-color: var(--evo-ui-primary);
        background: color-mix(in srgb, var(--evo-ui-primary) 7%, var(--evo-ui-surface));
        outline: 0;
    }

    .ddocs-folder-card:active,
    .ddocs-document-card:active {
        border-color: var(--evo-ui-primary);
        background: color-mix(in srgb, var(--evo-ui-primary) 11%, var(--evo-ui-surface));
        transform: none;
    }

    .ddocs-folder-card svg,
    .ddocs-document-card svg {
        transform: none !important;
        transition: color .15s ease, opacity .15s ease;
    }

    .ddocs-home-view .ddocs-folder-section > h3 {
        display: none;
    }

    .ddocs-source-card {
        min-height: 5.25rem;
        grid-template-rows: auto auto auto;
        align-items: start;
    }

    .ddocs-source-card__title {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-weight: 700;
    }

    .ddocs-source-card__description {
        grid-column: 1 / -1;
        min-width: 0;
        display: -webkit-box;
        overflow: hidden;
        color: var(--evo-ui-muted);
        font-size: .74rem;
        line-height: 1.25;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .ddocs-source-card__count {
        grid-column: 1 / -1 !important;
        justify-self: start;
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        width: auto;
        margin-top: .15rem;
        padding: .18rem .45rem;
        border: 1px solid var(--evo-ui-border);
        border-radius: 999px;
        background: var(--evo-ui-surface-muted);
        color: var(--evo-ui-muted);
        font-size: .68rem;
        font-weight: 700;
        line-height: 1;
    }

    .ddocs-source-card__count svg {
        width: .72rem;
        height: .72rem;
        flex: 0 0 auto;
    }

    .ddocs-document-card__title {
        display: inline-flex;
        min-width: 0;
        align-items: center;
        gap: .4rem;
        font-weight: 700;
    }

    .ddocs-document-card__path,
    .ddocs-document-card__excerpt {
        color: var(--evo-ui-muted);
        font-size: .78rem;
    }

    .ddocs-document-card__excerpt {
        line-height: 1.45;
    }

    .ddocs-document-card__badge {
        position: absolute;
        top: .75rem;
        right: .75rem;
        padding: .1rem .4rem;
        border-radius: 999px;
        background: var(--evo-ui-surface-muted);
        color: var(--evo-ui-muted);
        font-size: .7rem;
    }

    .ddocs-markdown {
        --ddocs-md-text: var(--evo-ui-text);
        --ddocs-md-muted: var(--evo-ui-muted);
        --ddocs-md-border: color-mix(in srgb, var(--evo-ui-border) 82%, transparent);
        --ddocs-md-surface: color-mix(in srgb, var(--evo-ui-surface) 92%, var(--evo-ui-bg));
        --ddocs-md-table-head-bg: color-mix(in srgb, var(--evo-ui-surface-muted) 34%, var(--evo-ui-surface));
        --ddocs-md-table-row-alt: color-mix(in srgb, var(--evo-ui-surface-muted) 18%, transparent);
        --ddocs-md-code-bg: color-mix(in srgb, var(--evo-ui-surface-muted) 72%, var(--evo-ui-bg));
        max-width: 72rem;
        min-width: 0;
        max-inline-size: 100%;
        overflow-x: hidden;
        padding: 1.5rem;
        color: var(--ddocs-md-text);
        font-size: .95rem;
        line-height: 1.62;
    }

    .ddocs-markdown > :first-child {
        margin-top: 0;
    }

    .ddocs-markdown > :last-child {
        margin-bottom: 0;
    }

    .ddocs-markdown h1,
    .ddocs-markdown h2,
    .ddocs-markdown h3,
    .ddocs-markdown h4,
    .ddocs-markdown h5,
    .ddocs-markdown h6 {
        margin: 1.5rem 0 .85rem;
        color: var(--ddocs-md-text) !important;
        font-weight: 700;
        line-height: 1.25;
    }

    .ddocs-markdown h1,
    .ddocs-markdown h2 {
        padding-bottom: .45rem;
        border-bottom: 1px solid var(--ddocs-md-border);
    }

    .ddocs-markdown h1 {
        font-size: 1.85rem;
    }

    .ddocs-markdown h2 {
        font-size: 1.45rem;
    }

    .ddocs-markdown h3 {
        font-size: 1.2rem;
    }

    .ddocs-markdown p,
    .ddocs-markdown li,
    .ddocs-markdown td,
    .ddocs-markdown th {
        color: var(--ddocs-md-text) !important;
    }

    .ddocs-markdown p,
    .ddocs-markdown ul,
    .ddocs-markdown ol,
    .ddocs-markdown blockquote,
    .ddocs-markdown table {
        margin-top: 0;
        margin-bottom: 1rem;
    }

    .ddocs-markdown a {
        color: var(--evo-ui-primary);
        text-decoration: underline;
        text-underline-offset: .16rem;
    }

    .ddocs-markdown a:hover,
    .ddocs-markdown a:focus-visible {
        color: color-mix(in srgb, var(--evo-ui-primary) 76%, var(--ddocs-md-text));
    }

    .ddocs-markdown hr {
        height: 1px;
        margin: 1.5rem 0;
        border: 0;
        background: var(--ddocs-md-border);
    }

    .ddocs-markdown blockquote {
        padding: 0 1rem;
        border-left: .25rem solid var(--ddocs-md-border);
        color: var(--ddocs-md-muted);
    }

    .ddocs-markdown blockquote > :last-child {
        margin-bottom: 0;
    }

    .ddocs-markdown pre,
    .ddocs-markdown code {
        border-radius: var(--evo-ui-radius);
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
    }

    .ddocs-markdown :not(pre) > code {
        padding: .12rem .32rem;
        border: 1px solid var(--ddocs-md-border);
        background: var(--ddocs-md-code-bg);
        color: var(--evo-ui-text);
        font-size: .92em;
    }

    .ddocs-markdown pre {
        position: relative;
        overflow: auto;
        margin: 1.15rem 0;
        padding: 2.65rem 1rem 1rem;
        border: 1px solid var(--ddocs-md-border);
        background: #1f2329;
        color: #e5e7eb;
        line-height: 1.55;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .04);
    }

    .ddocs-markdown pre[class*="language-"],
    .ddocs-markdown code[class*="language-"] {
        background: #1f2329;
        color: #e5e7eb;
        text-shadow: none;
    }

    .ddocs-markdown pre code {
        display: block;
        min-width: max-content;
        padding: 0;
        background: transparent;
        color: inherit;
        font-size: .9rem;
        white-space: pre;
    }

    .ddocs-markdown pre code[class*="language-"] {
        background: transparent;
        text-shadow: none;
    }

    .ddocs-markdown pre.ddocs-code-block::after,
    .ddocs-markdown pre[class*="language-"]::after,
    .ddocs-markdown .code-toolbar > .toolbar,
    .ddocs-markdown .toastui-editor-code-block-language,
    .ddocs-markdown code[class*="language-"]::after {
        content: none !important;
        display: none !important;
    }

    .ddocs-markdown pre.ddocs-code-block::before {
        content: none;
    }

    .ddocs-markdown pre.ddocs-code-block.has-language::before {
        content: attr(data-language);
        position: absolute;
        top: .5rem;
        left: .7rem;
        display: inline-flex;
        align-items: center;
        max-width: 12rem;
        overflow: hidden;
        box-sizing: border-box;
        min-height: 1.45rem;
        padding: .24rem .55rem .22rem;
        border: 1px solid #393b42;
        border-radius: 4px;
        background: #232428;
        color: #e5e7eb;
        font-family: inherit;
        font-size: .7rem;
        font-weight: 700;
        line-height: 1;
        text-transform: uppercase;
        white-space: nowrap;
        pointer-events: none;
    }

    .ddocs-markdown pre code[class*="language-"]::before {
        content: none;
    }

    .ddocs-markdown pre > button.ddocs-code-copy,
    .ddocs-markdown pre.ddocs-code-block > button.ddocs-code-copy,
    .ddocs-code-copy {
        position: absolute;
        top: .5rem !important;
        right: .7rem !important;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.45rem !important;
        height: 1.45rem !important;
        min-width: 1.45rem !important;
        min-height: 1.45rem !important;
        max-width: 1.45rem !important;
        max-height: 1.45rem !important;
        padding: 0 !important;
        box-sizing: border-box;
        border: 1px solid #393b42;
        border-radius: 4px;
        background: #232428;
        color: #e5e7eb;
        font-size: .7rem !important;
        line-height: 1 !important;
        cursor: pointer;
        transition: background .15s ease, border-color .15s ease, color .15s ease, transform .15s ease;
    }

    .ddocs-markdown pre > button.ddocs-code-copy:hover,
    .ddocs-markdown pre > button.ddocs-code-copy:focus-visible,
    .ddocs-code-copy:hover,
    .ddocs-code-copy:focus-visible {
        border-color: #4b96e6;
        background: #2b3340;
        color: #ffffff;
        outline: none;
    }

    .ddocs-code-copy:active {
        transform: translateY(1px);
    }

    .ddocs-code-copy.is-copied {
        border-color: color-mix(in srgb, var(--evo-ui-success, #22c55e) 65%, #393b42);
        color: var(--evo-ui-success, #22c55e);
    }

    .ddocs-markdown pre > button.ddocs-code-copy svg,
    .ddocs-code-copy svg {
        width: .78rem !important;
        height: .78rem !important;
        min-width: .78rem !important;
        min-height: .78rem !important;
        display: block;
    }

    .ddocs-editor {
        flex: 1 1 0;
        min-height: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        padding: 0;
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-editor > .dtui-editor {
        flex: 1 1 0;
        min-height: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-editor__textarea {
        width: 100%;
        min-height: 100%;
        padding: 1rem;
        border: 0;
        border-radius: 0;
        background: var(--ddocs-workspace-bg);
        color: var(--evo-ui-text);
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
        line-height: 1.55;
        resize: vertical;
    }

    .ddocs-editor .toastui-editor-defaultUI {
        flex: 1 1 0;
        min-height: 0;
        height: 100% !important;
        display: flex;
        flex-direction: column;
        border: 0 !important;
        border-radius: 0 !important;
        background: var(--ddocs-workspace-bg) !important;
    }

    .ddocs-editor .toastui-editor-defaultUI-toolbar {
        flex: 0 0 auto;
        border-color: var(--evo-ui-border) !important;
        background: var(--evo-ui-surface) !important;
    }

    .ddocs-editor .toastui-editor-defaultUI::after {
        height: 2.25rem !important;
        border-top: 1px solid var(--evo-ui-border) !important;
        border-radius: 0 !important;
        background: var(--evo-ui-surface) !important;
    }

    .ddocs-editor .dtui-editor-mode-switcher {
        right: .75rem !important;
        bottom: .25rem !important;
        height: 1.75rem !important;
        align-items: center !important;
    }

    .ddocs-editor .dtui-editor-mode-switcher button {
        height: 1.65rem !important;
        min-width: 5.75rem !important;
        width: 5.75rem !important;
        margin: 0 -1px 0 0 !important;
        border-color: var(--evo-ui-border) !important;
        border-radius: var(--evo-ui-radius-sm, .25rem) !important;
        background: var(--evo-ui-surface-muted) !important;
        color: var(--evo-ui-muted) !important;
        line-height: 1.55rem !important;
    }

    .ddocs-editor .dtui-editor-mode-switcher button:hover,
    .ddocs-editor .dtui-editor-mode-switcher button:focus {
        color: var(--evo-ui-text) !important;
    }

    .ddocs-editor .dtui-editor-mode-switcher button.active {
        background: var(--ddocs-workspace-bg) !important;
        color: var(--evo-ui-text) !important;
        border-color: var(--evo-ui-border) !important;
    }

    .ddocs-editor .toastui-editor-main {
        flex: 1 1 0;
        min-height: 0;
        height: 100% !important;
        margin-bottom: 2.25rem !important;
        background: var(--ddocs-workspace-bg) !important;
    }

    .ddocs-editor .toastui-editor-md-container,
    .ddocs-editor .toastui-editor-ww-container,
    .ddocs-editor .toastui-editor-md-preview,
    .ddocs-editor .toastui-editor-ww-code-block {
        min-height: 0;
        height: 100% !important;
        background: var(--ddocs-workspace-bg) !important;
    }

    .ddocs-editor .toastui-editor-md-code,
    .ddocs-editor .toastui-editor-md-preview,
    .ddocs-editor .toastui-editor-contents,
    .ddocs-editor .ProseMirror {
        background: var(--ddocs-workspace-bg) !important;
        color: var(--evo-ui-text) !important;
    }

    .ddocs-editor .toastui-editor-md-container .toastui-editor,
    .ddocs-editor .toastui-editor-main-container,
    .ddocs-editor .toastui-editor-md-code,
    .ddocs-editor .toastui-editor-md-preview,
    .ddocs-editor .toastui-editor-ww-container,
    .ddocs-editor .toastui-editor-contents,
    .ddocs-editor .ProseMirror {
        min-height: 0 !important;
        height: 100% !important;
    }

    .ddocs-editor .toastui-editor-md-splitter {
        width: 1px !important;
        background: var(--evo-ui-border) !important;
    }

    .ddocs-editor .dtui-editor[data-dtui-editor-mode="split"] .toastui-editor-md-splitter {
        background: var(--evo-ui-primary) !important;
        opacity: .7;
    }

    .ddocs-editor .toastui-editor-code-block-language,
    .ddocs-editor pre::before,
    .ddocs-editor pre::after,
    .ddocs-editor code::before,
    .ddocs-editor code::after {
        content: none !important;
        display: none !important;
    }

    .ddocs-modal {
        position: fixed;
        inset: 0;
        z-index: 80;
        display: grid;
        place-items: center;
        padding: 1rem;
    }

    .ddocs-modal__backdrop {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, .62);
    }

    .ddocs-modal__panel {
        position: relative;
        width: min(28rem, calc(100vw - 2rem));
        overflow: hidden;
        border: 1px solid var(--evo-ui-border);
        border-radius: var(--evo-ui-radius);
        background: var(--evo-ui-surface);
        color: var(--evo-ui-text);
        box-shadow: 0 1.5rem 4rem rgba(0, 0, 0, .38);
    }

    .ddocs-modal__header,
    .ddocs-modal__field,
    .ddocs-modal__footer {
        padding: 1rem;
    }

    .ddocs-modal__header {
        border-bottom: 1px solid var(--evo-ui-border);
    }

    .ddocs-modal__header h2 {
        margin: 0;
        font-size: 1rem;
    }

    .ddocs-modal__field {
        display: grid;
        gap: .5rem;
    }

    .ddocs-modal__field span {
        color: var(--evo-ui-muted);
        font-size: .8rem;
    }

    .ddocs-modal__input {
        width: 100%;
    }

    .ddocs-modal__footer {
        display: flex;
        justify-content: flex-end;
        gap: .5rem;
        border-top: 1px solid var(--evo-ui-border);
    }

    .ddocs-modal .evo-ui-btn--danger {
        border-color: color-mix(in srgb, var(--evo-ui-danger, #ef4444) 65%, var(--evo-ui-border));
        background: color-mix(in srgb, var(--evo-ui-danger, #ef4444) 18%, var(--evo-ui-surface));
        color: var(--evo-ui-danger, #ef4444);
    }

    .ddocs-settings-modal {
        z-index: 90;
        align-items: start;
        padding: 3.5rem 1.25rem 1.25rem;
    }

    .ddocs-settings-modal__panel {
        width: min(76rem, calc(100vw - 2.5rem));
        max-height: calc(100vh - 5rem);
        display: flex;
        flex-direction: column;
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-settings-modal__header {
        flex: 0 0 auto;
        min-height: 3.25rem;
        padding: .75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        border-bottom: 1px solid var(--evo-ui-border);
        background: var(--ddocs-workspace-bg);
    }

    .ddocs-settings-modal__title,
    .ddocs-settings-modal__actions,
    .ddocs-settings-modal__button {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
    }

    .ddocs-settings-modal__title {
        min-width: 0;
        color: var(--evo-ui-text);
        font-size: 1rem;
        font-weight: 700;
    }

    .ddocs-settings-modal__title svg {
        width: 1rem;
        height: 1rem;
        color: var(--evo-ui-muted);
    }

    .ddocs-settings-modal__actions {
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .ddocs-settings-modal__button {
        min-height: 2.25rem;
        padding: .45rem .75rem;
        line-height: 1;
    }

    .ddocs-settings-modal .ddocs-settings {
        flex: 1 1 auto;
        overflow: auto;
    }

    .ddocs-markdown pre code .token,
    .ddocs-markdown pre code span,
    .ddocs-markdown pre code[class*="language-"] .token,
    .ddocs-markdown pre code[class*="language-"] span,
    .ddocs-markdown .token {
        background: transparent !important;
        background-color: transparent !important;
        background-image: none !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }

    .ddocs-markdown .token.comment,
    .ddocs-markdown .token.prolog,
    .ddocs-markdown .token.doctype,
    .ddocs-markdown .token.cdata {
        color: #94a3b8;
    }

    .ddocs-markdown .token.punctuation {
        color: #cbd5e1;
    }

    .ddocs-markdown .token.property,
    .ddocs-markdown .token.tag,
    .ddocs-markdown .token.boolean,
    .ddocs-markdown .token.number,
    .ddocs-markdown .token.constant,
    .ddocs-markdown .token.symbol,
    .ddocs-markdown .token.deleted {
        color: #fca5a5;
    }

    .ddocs-markdown .token.selector,
    .ddocs-markdown .token.attr-name,
    .ddocs-markdown .token.string,
    .ddocs-markdown .token.char,
    .ddocs-markdown .token.builtin,
    .ddocs-markdown .token.inserted {
        color: #86efac;
    }

    .ddocs-markdown .token.operator,
    .ddocs-markdown .token.entity,
    .ddocs-markdown .token.url,
    .ddocs-markdown .language-css .token.string,
    .ddocs-markdown .style .token.string {
        color: #93c5fd;
    }

    .ddocs-markdown .token.atrule,
    .ddocs-markdown .token.attr-value,
    .ddocs-markdown .token.keyword {
        color: #c4b5fd;
    }

    .ddocs-markdown .token.function,
    .ddocs-markdown .token.class-name {
        color: #fde68a;
    }

    .ddocs-markdown .token.regex,
    .ddocs-markdown .token.important,
    .ddocs-markdown .token.variable {
        color: #fdba74;
    }

    .ddocs-markdown table {
        display: block;
        width: max-content;
        max-width: 100%;
        overflow-x: auto;
        border-collapse: collapse;
        margin: 1rem 0;
        border: 1px solid var(--ddocs-md-border);
        border-radius: var(--evo-ui-radius);
        background: var(--ddocs-md-surface);
    }

    .ddocs-markdown th,
    .ddocs-markdown td {
        padding: .65rem .85rem;
        border: 1px solid var(--ddocs-md-border);
        text-align: left;
    }

    .ddocs-markdown th {
        border-bottom-color: color-mix(in srgb, var(--evo-ui-border) 92%, var(--evo-ui-text));
        background: var(--ddocs-md-table-head-bg);
        color: var(--ddocs-md-text) !important;
        font-weight: 650;
    }

    .ddocs-markdown tr:nth-child(2n) td {
        background: var(--ddocs-md-table-row-alt);
    }

    .ddocs-markdown th[align="right"],
    .ddocs-markdown td[align="right"],
    .ddocs-markdown th[style*="right"],
    .ddocs-markdown td[style*="right"] {
        text-align: right;
    }

    .ddocs-markdown details {
        margin: 1rem 0;
        padding: 0;
        border: 1px solid var(--ddocs-md-border);
        border-radius: var(--evo-ui-radius);
        background: color-mix(in srgb, var(--evo-ui-surface-muted) 34%, transparent);
        overflow: hidden;
    }

    .ddocs-markdown details > summary {
        min-height: 2.75rem;
        display: flex;
        align-items: center;
        gap: .45rem;
        padding: .75rem 1rem;
        cursor: pointer;
        color: var(--ddocs-md-text);
        font-weight: 700;
    }

    .ddocs-markdown details[open] > summary {
        margin-bottom: 0;
        border-bottom: 1px solid var(--ddocs-md-border);
    }

    .ddocs-markdown details > .ddocs-details-body {
        padding: .85rem 1rem 1rem;
    }

    .ddocs-markdown details > .ddocs-details-body > :first-child {
        margin-top: 0;
    }

    .ddocs-markdown details > .ddocs-details-body > :last-child {
        margin-bottom: 0;
    }

    .ddocs-markdown details > :not(summary):not(.ddocs-details-body) {
        margin: .85rem 1rem;
    }

    .ddocs-markdown details > :last-child {
        margin-bottom: 0;
    }

    .ddocs-markdown mark {
        padding: .08rem .18rem;
        border-radius: .2rem;
        background: #facc15;
        color: #111827;
    }

    .ddocs-markdown ins {
        text-decoration: underline;
        text-decoration-thickness: .08em;
        text-underline-offset: .14em;
    }

    .ddocs-markdown abbr[title] {
        cursor: help;
        text-decoration: underline dotted;
        text-underline-offset: .16rem;
    }

    .ddocs-markdown sub,
    .ddocs-markdown sup {
        line-height: 0;
    }

    .ddocs-markdown .ddocs-definition-list {
        margin: 1rem 0;
    }

    .ddocs-markdown .ddocs-definition-list dt {
        margin-top: .7rem;
        color: var(--ddocs-md-text);
        font-weight: 700;
    }

    .ddocs-markdown .ddocs-definition-list dd {
        margin: .25rem 0 .55rem 1.25rem;
        color: var(--ddocs-md-text);
    }

    .ddocs-markdown .ddocs-container {
        margin: 1rem 0;
        padding: .85rem 1rem;
        border: 1px solid var(--ddocs-md-border);
        border-radius: var(--evo-ui-radius);
        background: color-mix(in srgb, var(--evo-ui-surface-muted) 36%, transparent);
        color: var(--ddocs-md-text);
    }

    .ddocs-markdown .ddocs-container--warning {
        border-color: color-mix(in srgb, #f59e0b 58%, var(--ddocs-md-border));
        background: color-mix(in srgb, #f59e0b 16%, var(--evo-ui-surface));
    }

    .ddocs-markdown .ddocs-footnotes {
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid var(--ddocs-md-border);
        color: var(--ddocs-md-muted);
        font-size: .88rem;
    }

    .ddocs-markdown .ddocs-footnotes ol {
        margin-bottom: 0;
    }

    .ddocs-markdown .ddocs-footnotes li {
        color: var(--ddocs-md-muted) !important;
    }

    .ddocs-markdown .ddocs-footnote-ref {
        margin-left: .08rem;
        font-size: .72em;
    }

    .ddocs-markdown .ddocs-link-internal {
        cursor: pointer;
    }

    .ddocs-markdown .ddocs-link-missing {
        color: var(--evo-ui-danger);
        text-decoration-style: dashed;
    }

    .ddocs-markdown .ddocs-heading {
        scroll-margin-top: 6rem;
    }

    .ddocs-markdown .ddocs-heading-anchor {
        margin-left: .4rem;
        color: var(--evo-ui-muted);
        font-size: .75em;
        text-decoration: none;
        opacity: 0;
    }

    .ddocs-markdown .ddocs-heading:hover .ddocs-heading-anchor {
        opacity: 1;
    }

    .ddocs-markdown figure {
        margin: 1rem 0;
    }

    .ddocs-markdown figcaption {
        margin-top: .45rem;
        color: var(--evo-ui-muted);
        font-size: .875rem;
    }

    .ddocs-markdown .ddocs-uml {
        box-sizing: border-box;
        display: inline-flex;
        align-items: flex-start;
        justify-content: flex-start;
        width: auto;
        max-width: 100%;
        min-width: 0;
        min-height: 0;
        margin: 1.25rem 0;
        padding: 1rem;
        border: 1px solid color-mix(in srgb, var(--evo-ui-border) 78%, transparent);
        border-radius: var(--evo-ui-radius);
        background: #ffffff;
        color: #111827;
        overflow: auto;
        vertical-align: top;
    }

    .ddocs-markdown .ddocs-uml__image {
        display: block;
        flex: 0 1 auto;
        width: auto;
        max-width: 100%;
        height: auto;
        margin: 0;
        border-radius: var(--evo-ui-radius);
        background: #ffffff;
        color: #111827;
        filter: none !important;
    }

    .ddocs-markdown .ddocs-uml-fallback {
        border: 1px solid color-mix(in srgb, var(--evo-ui-warning) 45%, var(--evo-ui-border));
    }

    .ddocs-editor .toastui-editor-contents img[src*="plantuml"],
    .ddocs-editor .toastui-editor-contents img[src*="uml"] {
        box-sizing: border-box;
        max-width: 100%;
        height: auto;
        padding: 1rem;
        border-radius: var(--evo-ui-radius);
        background: #ffffff;
    }

    .ddocs-markdown img.ddocs-image-local,
    .ddocs-markdown img.ddocs-image-external {
        max-width: 100%;
        height: auto;
        border-radius: var(--evo-ui-radius);
    }

    .ddocs-markdown .ddocs-image-blocked {
        display: inline-block;
        margin: .25rem 0;
        padding: .15rem .45rem;
        border-radius: var(--evo-ui-radius);
        color: var(--evo-ui-muted);
        background: var(--evo-ui-surface-muted);
        font-size: .875rem;
    }

    @media (max-width: 760px) {
        .ddocs-workspace {
            height: 100dvh;
        }

        .ddocs-workspace__body {
            grid-template-columns: 1fr;
        }

        .ddocs-workspace__sidebar {
            display: none;
        }

        .ddocs-toolbar {
            padding: .625rem;
        }

        .ddocs-search__meta {
            grid-column: 1 / -1;
        }

        .ddocs-tree {
            padding: .375rem;
        }

        .ddocs-tree__children {
            margin-left: .35rem;
            padding-left: .35rem;
        }

        .ddocs-tree__row {
            min-height: 2.25rem;
            gap: .35rem;
        }

        .ddocs-workspace__viewer {
            min-width: 0;
            overflow-x: hidden;
        }

        .ddocs-settings {
            padding: .75rem;
        }

        .ddocs-settings-modal {
            padding: .75rem;
        }

        .ddocs-settings-modal__panel {
            width: calc(100vw - 1.5rem);
            max-height: calc(100vh - 1.5rem);
        }

        .ddocs-settings-modal__header {
            align-items: flex-start;
            flex-direction: column;
            padding: .75rem;
        }

        .ddocs-settings-modal__actions {
            width: 100%;
            justify-content: flex-end;
        }

        .ddocs-settings-modal__button span {
            display: none;
        }

        .ddocs-settings .evo-ui-form-tab-panel {
            grid-template-columns: 1fr;
        }

        .ddocs-settings .evo-ui-form-tab-panel > .evo-ui-form-section:nth-of-type(n) {
            grid-column: 1;
            grid-row: auto;
        }

        .ddocs-document__header {
            align-items: stretch;
            padding: .85rem .9rem;
        }

        .ddocs-document__header h2 {
            font-size: 1.05rem;
        }

        .ddocs-markdown,
        .ddocs-folder-listing {
            width: 100%;
            max-inline-size: 100%;
            max-width: none;
            padding: .85rem;
        }

        .ddocs-markdown pre {
            margin-right: -1rem;
            margin-left: -1rem;
            border-right: 0;
            border-left: 0;
            border-radius: 0;
        }

        .ddocs-folder-grid {
            grid-template-columns: 1fr;
        }

        .ddocs-source-grid {
            grid-template-columns: 1fr;
        }

        .ddocs-source-card,
        .ddocs-folder-card {
            min-height: auto;
            padding: .75rem;
        }
    }

    @media (max-width: 480px) {
        .ddocs-document__header {
            position: relative;
            flex-direction: column;
            gap: .75rem;
            padding: .75rem;
        }

        .ddocs-document__actions {
            justify-content: flex-end;
        }

        .ddocs-document-card {
            padding-right: .9rem;
        }

        .ddocs-folder-listing {
            padding: .625rem;
        }

        .ddocs-folder-card {
            padding: .65rem;
        }

        .ddocs-document-card__badge {
            position: static;
            width: max-content;
        }
    }
</style>
