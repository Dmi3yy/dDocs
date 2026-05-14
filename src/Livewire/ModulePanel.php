<?php namespace Dmi3yy\dDocs\Livewire;

use Dmi3yy\dDocs\Support\FileDocumentRepository;
use Dmi3yy\dDocs\Support\FileIndexCache;
use Dmi3yy\dDocs\Support\FileSearch;
use Dmi3yy\dDocs\Support\ManagerText;
use Dmi3yy\dDocs\Support\DocsSourceRegistry;
use Dmi3yy\dDocs\Support\LinkResolver;
use Livewire\Component;

class ModulePanel extends Component
{
    public array $context = [];
    public array $rawTabs = [];
    public array $expanded = [];
    public ?string $selectedDocumentId = null;
    public ?string $selectedNodeId = null;
    public string $search = '';
    public int $refreshToken = 0;
    public string $activeTab = 'docs';
    public ?string $editingDocumentId = null;
    public string $editingMarkdown = '';
    public ?string $cacheMessage = null;

    public function mount(array $tabs = [], string $activeTab = 'docs', array $context = []): void
    {
        $this->rawTabs = $tabs;
        $this->activeTab = $this->normalizeTab($activeTab);
        $this->context = $context;
        $this->expanded = [];
        $this->search = '';
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $this->normalizeTab($tab);
    }

    public function toggleFolder(string $id): void
    {
        $id = trim($id);
        if ($id === '') {
            return;
        }

        $this->selectedNodeId = $id;
        $this->selectedDocumentId = null;

        if (($this->expanded[$id] ?? false) === true) {
            unset($this->expanded[$id]);

            return;
        }

        $this->expanded[$id] = true;
    }

    public function selectFolder(string $id): void
    {
        $id = trim($id);
        if ($id === '') {
            return;
        }

        $nodes = app(FileIndexCache::class)->index();
        $node = null;
        foreach ($nodes as $candidate) {
            if (($candidate['id'] ?? '') === $id && ($candidate['type'] ?? '') === 'folder') {
                $node = $candidate;
                break;
            }
        }

        if ($node === null) {
            return;
        }

        $this->selectedNodeId = $id;
        $this->selectedDocumentId = null;
        $this->editingDocumentId = null;
        $this->editingMarkdown = '';
        $this->expanded[$id] = true;
        $this->expandAncestors($node, $nodes);
    }

    public function selectHome(): void
    {
        $this->selectedNodeId = null;
        $this->selectedDocumentId = null;
        $this->editingDocumentId = null;
        $this->editingMarkdown = '';
    }

    public function selectDocument(string $id): void
    {
        $this->selectedNodeId = $id;
        $this->selectedDocumentId = $id;
        $this->editingDocumentId = null;
        $this->editingMarkdown = '';
    }

    public function refreshIndex(): void
    {
        $nodes = app(FileIndexCache::class)->refresh();
        $this->refreshToken++;
        $this->cacheMessage = str_replace(
            ':count',
            (string) count(array_filter($nodes, fn (array $node): bool => ($node['type'] ?? '') === 'document')),
            ManagerText::get('cache_refreshed') ?: 'Index cache refreshed: :count documents.',
        );
    }

    public function collapseTree(): void
    {
        $this->expanded = [];
        $this->search = '';
    }

    public function createFolder(string $name): void
    {
        $target = $this->userDocsWritableRoot();
        if ($target === null) {
            return;
        }

        $this->createFolderUnder($target, $name);
    }

    public function createDocument(string $name): void
    {
        $target = $this->userDocsWritableRoot();
        if ($target === null) {
            return;
        }

        $this->createDocumentUnder($target, $name);
    }

    public function createFolderIn(string $folderId, string $name): void
    {
        $target = $this->writableFolderById($folderId);
        if ($target === null) {
            return;
        }

        $this->createFolderUnder($target, $name);
    }

    public function createDocumentIn(string $folderId, string $name): void
    {
        $target = $this->writableFolderById($folderId);
        if ($target === null) {
            return;
        }

        $this->createDocumentUnder($target, $name);
    }

    public function editDocument(string $id): void
    {
        $node = $this->nodeById($id);
        if (!$this->isWritableNode($node) || ($node['type'] ?? '') !== 'document') {
            return;
        }

        $markdown = app(FileDocumentRepository::class)->read($node);
        if ($markdown === null) {
            return;
        }

        $this->selectedNodeId = $id;
        $this->selectedDocumentId = $id;
        $this->editingDocumentId = $id;
        $this->editingMarkdown = $markdown;
    }

    public function cancelEdit(): void
    {
        $this->editingDocumentId = null;
        $this->editingMarkdown = '';
    }

    public function saveDocument(): void
    {
        if ($this->editingDocumentId === null) {
            return;
        }

        $node = $this->nodeById($this->editingDocumentId);
        if (!$this->isWritableNode($node) || ($node['type'] ?? '') !== 'document') {
            return;
        }

        $path = (string) ($node['absolute_path'] ?? '');
        if (!$this->pathIsInside($path, (string) ($node['docs_path'] ?? ''))) {
            return;
        }

        file_put_contents($path, $this->editingMarkdown);
        app(FileIndexCache::class)->refresh();
        $this->refreshToken++;
        $this->editingDocumentId = null;
        $this->editingMarkdown = '';
    }

    public function deleteNode(string $id): void
    {
        $node = $this->nodeById($id);
        if (!$this->isDeletableNode($node)) {
            return;
        }

        $path = (string) ($node['absolute_path'] ?? '');
        if (!$this->pathIsInside($path, (string) ($node['docs_path'] ?? ''))) {
            return;
        }

        if (($node['type'] ?? '') === 'document' && is_file($path)) {
            @unlink($path);
        } elseif (($node['type'] ?? '') === 'folder' && is_dir($path)) {
            $this->removeDirectory($path, (string) ($node['docs_path'] ?? ''));
        }

        $parentId = (string) ($node['parent_id'] ?? '');
        $nodes = app(FileIndexCache::class)->refresh();
        $this->refreshToken++;
        $this->selectedNodeId = $this->shouldSelectParentAfterDelete($parentId, $nodes) ? $parentId : null;
        $this->selectedDocumentId = null;
        $this->editingDocumentId = null;
        $this->editingMarkdown = '';
        unset($this->expanded[$id]);
    }

    protected function createFolderUnder(array $target, string $name): void
    {
        $slug = $this->safeBasename($name, 'new-folder');
        $folderPath = $this->uniquePath((string) $target['absolute_path'], $slug, null);
        if ($folderPath === null || !$this->isSafeNewPath($folderPath, (string) $target['docs_path'])) {
            return;
        }

        if (!is_dir($folderPath) && !mkdir($folderPath, 0775, true) && !is_dir($folderPath)) {
            return;
        }

        $this->refreshToken++;
        $this->selectPath($folderPath, 'folder');
    }

    protected function createDocumentUnder(array $target, string $name): void
    {
        $title = $this->titleFromInput($name, ManagerText::get('new_document_title') ?: 'New document');
        $slug = $this->safeBasename($name, 'new-document');
        $extension = preg_match('/\.mdx?$/i', $slug) ? '' : '.md';
        $documentPath = $this->uniquePath((string) $target['absolute_path'], $slug, $extension);
        if ($documentPath === null || !$this->isSafeNewPath($documentPath, (string) $target['docs_path'])) {
            return;
        }

        if (file_put_contents($documentPath, "# {$title}\n\n") === false) {
            return;
        }

        $this->refreshToken++;
        $this->selectPath($documentPath, 'document');
    }

    public function render()
    {
        $allNodes = app(FileIndexCache::class)->index();
        $nodes = app(FileSearch::class)->filter($allNodes, $this->search);
        $document = $this->selectedDocument($nodes, $allNodes);
        $document ??= $this->selectedDocument($allNodes, $allNodes);
        $selectedNode = $this->selectedNode($nodes) ?? $this->selectedNode($allNodes);
        $listingNodes = trim($this->search) !== '' ? $nodes : $allNodes;
        $folder = (($selectedNode['type'] ?? '') === 'folder') ? $this->folderListing($selectedNode, $listingNodes) : null;
        $writableTarget = $this->writableFolderFor($selectedNode, $allNodes);
        $selectedWritable = $this->isWritableNode($selectedNode);
        $isEditing = $document !== null && $this->editingDocumentId !== null && $this->editingDocumentId === ($document['id'] ?? null);

        return view('dDocs::livewire.module-panel', [
            'context' => $this->context,
            'tabs' => $this->navigationTabs(),
            'activeTab' => $this->activeTab,
            'tree' => $this->tree($nodes),
            'documentCount' => count(array_filter($allNodes, fn (array $node): bool => ($node['type'] ?? '') === 'document')),
            'visibleDocumentCount' => count(array_filter($nodes, fn (array $node): bool => ($node['type'] ?? '') === 'document')),
            'document' => $document,
            'folder' => $folder,
            'home' => $this->homeListing($listingNodes),
            'documentBreadcrumbs' => $document !== null ? $this->breadcrumbsForNode($document, $allNodes) : [],
            'folderBreadcrumbs' => $folder !== null ? $this->breadcrumbsForNode($folder, $allNodes) : [],
            'homeBreadcrumbIcon' => preg_replace('/^tabler-/', '', (string) (ManagerText::get('docs_icon') ?: ManagerText::get('module_icon') ?: 'book-2')),
            'canCreateRootFolder' => true,
            'canCreateInSelectedFolder' => $writableTarget !== null && ($selectedNode['type'] ?? '') === 'folder',
            'canEditSelectedDocument' => $selectedWritable && (($selectedNode['type'] ?? '') === 'document'),
            'canDeleteSelectedNode' => $selectedWritable && $selectedNode !== null,
            'isEditing' => $isEditing,
            'ui' => ManagerText::all(),
        ]);
    }

    protected function tree(array $nodes): array
    {
        $byParent = [];
        foreach ($nodes as $node) {
            $parent = $node['parent_id'] ?? 'root';
            $byParent[$parent][] = $node;
        }

        $searching = trim($this->search) !== '';

        $build = function (?string $parentId) use (&$build, &$byParent, $searching): array {
            $items = $byParent[$parentId ?? 'root'] ?? [];

            $mapped = array_map(function (array $node) use (&$build, $searching): array {
                $children = $build($node['id']);
                $isFolder = ($node['type'] ?? '') === 'folder';

                $node['children'] = $children;
                $node['expanded'] = $isFolder && ($searching || (($this->expanded[$node['id']] ?? false) === true));
                $node['document_count'] = $this->documentCount($node);
                $node['child_count'] = count($children);
                $node['active'] = ($node['id'] ?? null) === $this->selectedNodeId || ($node['id'] ?? null) === $this->selectedDocumentId;

                return $node;
            }, $items);

            return array_values(array_filter($mapped, fn (array $node): bool => !$this->isEmptyProjectDocsSource($node)));
        };

        return $build(null);
    }

    protected function navigationTabs(): array
    {
        return collect($this->rawTabs)
            ->map(function (array $tab) {
                $key = (string) ($tab['key'] ?? '');
                $tab['active'] = $key === $this->activeTab;
                $tab['type'] = 'wire';
                $tab['method'] = 'switchTab';
                $tab['argument'] = $key;

                return $tab;
            })
            ->values()
            ->all();
    }

    protected function normalizeTab(string $tab): string
    {
        $allowed = collect($this->rawTabs)->pluck('key')->map(fn ($key) => (string) $key)->all();

        return in_array($tab, $allowed, true) ? $tab : ($allowed[0] ?? 'docs');
    }

    protected function documentCount(array $node): int
    {
        $count = ($node['type'] ?? '') === 'document' ? 1 : 0;

        foreach (($node['children'] ?? []) as $child) {
            $count += $this->documentCount($child);
        }

        return $count;
    }

    protected function selectedDocument(array $nodes, ?array $linkNodes = null): ?array
    {
        if ($this->selectedDocumentId === null) {
            return null;
        }

        $repository = app(FileDocumentRepository::class);
        $node = $repository->find($nodes, $this->selectedDocumentId);
        if ($node === null) {
            return null;
        }

        $markdown = $repository->read($node);
        if ($markdown === null) {
            return $node + ['markdown' => '', 'readable' => false];
        }

        $markdown = $this->prepareMarkdownForClient($markdown);

        return $node + [
            'markdown' => $markdown,
            'link_map' => $this->documentLinkMap($markdown, $node, $linkNodes ?? $nodes),
            'image_map' => $this->documentImageMap($markdown, $node),
            'uml_map' => $this->documentUmlMap($markdown),
            'readable' => true,
        ];
    }

    protected function prepareMarkdownForClient(string $markdown): string
    {
        $markdown = preg_replace('/^\xEF\xBB\xBF/', '', $markdown) ?? $markdown;
        $markdown = preg_replace('/\A---[ \t]*\R.*?\R---[ \t]*(?:\R|$)/s', '', $markdown) ?? $markdown;
        $markdown = str_replace(['{% raw %}', '{% endraw %}'], '', $markdown);
        $markdown = preg_replace('/\{:\s*[^}]+\}/', '', $markdown) ?? $markdown;

        return ltrim($markdown);
    }

    protected function documentLinkMap(string $markdown, array $document, array $nodes): array
    {
        $resolver = app(LinkResolver::class);
        $items = [];
        foreach ($this->markdownUrls($markdown, false) as $href) {
            $target = $resolver->resolve($href, $document, $nodes);
            if ($target === null) {
                continue;
            }

            $items[] = [
                'href' => $href,
                'target_id' => (string) ($target['id'] ?? ''),
            ];
        }

        return $items;
    }

    protected function documentImageMap(string $markdown, array $document): array
    {
        $resolver = app(LinkResolver::class);
        $items = [];
        foreach ($this->markdownUrls($markdown, true) as $src) {
            $dataUri = $resolver->imageDataUriFor($src, $document);
            if ($dataUri === null) {
                continue;
            }

            $items[] = [
                'src' => $src,
                'data_uri' => $dataUri,
            ];
        }

        return $items;
    }

    protected function documentUmlMap(string $markdown): array
    {
        preg_match_all('/(^|\R)\$\$uml[ \t]*\R([\s\S]*?)\R\$\$[ \t]*(?=\R|$)/i', $markdown, $matches);

        $resolver = app(LinkResolver::class);
        $items = [];
        foreach ($matches[2] ?? [] as $source) {
            $normalized = $resolver->normalizeUmlSource($source);
            if ($normalized === '') {
                continue;
            }

            $src = $resolver->umlImageSrc($normalized);
            if ($src === null) {
                continue;
            }

            $items[] = [
                'source' => $normalized,
                'src' => $src,
            ];
        }

        return $items;
    }

    protected function markdownUrls(string $markdown, bool $images): array
    {
        $pattern = $images
            ? '/!\[[^\]]*]\(\s*([^)\s]+)(?:\s+["\'][^"\']*["\'])?\s*\)/'
            : '/(?<!!)\[[^\]]+]\(\s*([^)\s]+)(?:\s+["\'][^"\']*["\'])?\s*\)/';

        preg_match_all($pattern, $markdown, $matches);

        return array_values(array_unique(array_map(
            static fn (string $value): string => trim($value),
            $matches[1] ?? []
        )));
    }

    protected function selectedNode(array $nodes): ?array
    {
        if ($this->selectedNodeId === null) {
            return null;
        }

        foreach ($nodes as $node) {
            if (($node['id'] ?? '') === $this->selectedNodeId) {
                return $node;
            }
        }

        return null;
    }

    protected function folderListing(array $folder, array $nodes): array
    {
        $folderId = (string) ($folder['id'] ?? '');
        $children = array_values(array_filter($nodes, fn (array $node): bool => ($node['parent_id'] ?? null) === $folderId));

        $folders = [];
        $documents = [];
        foreach ($children as $child) {
            if (($child['type'] ?? '') === 'folder') {
                $folders[] = $child + ['document_count' => $this->countDocumentsUnder((string) ($child['id'] ?? ''), $nodes)];
                continue;
            }

            if (($child['type'] ?? '') === 'document') {
                $documents[] = $child + ['excerpt' => $this->documentExcerpt($child)];
            }
        }

        return $folder + [
            'folders' => $folders,
            'documents' => $documents,
            'document_count' => $this->countDocumentsUnder($folderId, $nodes),
            'readable' => true,
        ];
    }

    protected function homeListing(array $nodes): array
    {
        $sources = [];
        foreach ($nodes as $node) {
            if (($node['type'] ?? '') !== 'folder' || ($node['parent_id'] ?? null) !== null) {
                continue;
            }

            $source = $node + [
                'document_count' => $this->countDocumentsUnder((string) ($node['id'] ?? ''), $nodes),
                'child_count' => $this->countChildrenUnder((string) ($node['id'] ?? ''), $nodes),
            ];
            if ($this->isEmptyProjectDocsSource($source)) {
                continue;
            }

            $sources[] = $source;
        }

        return [
            'title' => ManagerText::get('module_title') ?: ManagerText::get('docs') ?: 'Documentation',
            'sources' => $sources,
            'document_count' => count(array_filter($nodes, fn (array $node): bool => ($node['type'] ?? '') === 'document')),
        ];
    }

    protected function breadcrumbsForNode(array $node, array $nodes): array
    {
        $byId = [];
        foreach ($nodes as $candidate) {
            $id = (string) ($candidate['id'] ?? '');
            if ($id !== '') {
                $byId[$id] = $candidate;
            }
        }

        $trail = [];
        $current = $node;
        while ($current !== null) {
            $trail[] = $current;
            $parentId = (string) ($current['parent_id'] ?? '');
            $current = $parentId !== '' ? ($byId[$parentId] ?? null) : null;
        }

        $trail = array_reverse($trail);
        $last = count($trail) - 1;

        return array_map(function (array $item, int $index) use ($last): array {
            $type = (string) ($item['type'] ?? '');
            $relativePath = trim((string) ($item['relative_path'] ?? ''));
            $label = (string) ($item['title'] ?? '');

            if ($type === 'document' && $relativePath !== '') {
                $label = basename($relativePath);
            } elseif ($label === '' && $relativePath !== '') {
                $label = basename($relativePath);
            }

            if ($label === '') {
                $label = (string) ($item['source_name'] ?? $item['source_key'] ?? 'Docs');
            }

            return [
                'id' => (string) ($item['id'] ?? ''),
                'label' => $label,
                'type' => $type,
                'current' => $index === $last,
                'clickable' => $index !== $last && $type === 'folder',
            ];
        }, $trail, array_keys($trail));
    }

    protected function countDocumentsUnder(string $folderId, array $nodes): int
    {
        $count = 0;
        foreach ($nodes as $node) {
            if (($node['parent_id'] ?? null) !== $folderId) {
                continue;
            }

            if (($node['type'] ?? '') === 'document') {
                $count++;
                continue;
            }

            if (($node['type'] ?? '') === 'folder') {
                $count += $this->countDocumentsUnder((string) ($node['id'] ?? ''), $nodes);
            }
        }

        return $count;
    }

    protected function countChildrenUnder(string $folderId, array $nodes): int
    {
        $count = 0;
        foreach ($nodes as $node) {
            if (($node['parent_id'] ?? null) === $folderId) {
                $count++;
            }
        }

        return $count;
    }

    protected function documentExcerpt(array $node): string
    {
        $markdown = app(FileDocumentRepository::class)->read($node);
        if ($markdown === null) {
            return '';
        }

        $markdown = preg_replace('/```.*?```/s', ' ', $markdown) ?? $markdown;
        $markdown = preg_replace('/^---\R.*?\R---\R/s', ' ', $markdown) ?? $markdown;
        $blocks = preg_split('/\R{2,}/', $markdown) ?: [];

        foreach ($blocks as $block) {
            $text = trim($block);
            if ($text === '' || str_starts_with($text, '#') || str_starts_with($text, '|')) {
                continue;
            }

            $text = preg_replace('/!\[[^\]]*]\([^)]+\)/', '', $text) ?? $text;
            $text = preg_replace('/\[([^\]]+)]\([^)]+\)/', '$1', $text) ?? $text;
            $text = preg_replace('/[`*_>#-]+/', ' ', $text) ?? $text;
            $text = trim(preg_replace('/\s+/', ' ', $text) ?? $text);

            if ($text !== '') {
                return mb_strlen($text) > 220 ? mb_substr($text, 0, 217) . '...' : $text;
            }
        }

        return '';
    }

    protected function currentWritableRootFolder(): ?array
    {
        $nodes = app(FileIndexCache::class)->index();
        foreach ($nodes as $node) {
            if (($node['type'] ?? '') === 'folder' && ($node['parent_id'] ?? null) === null && $this->isWritableNode($node)) {
                return $node;
            }
        }

        return null;
    }

    protected function userDocsWritableRoot(): ?array
    {
        $path = app(DocsSourceRegistry::class)->userDocsPath();
        if (!is_dir($path) && !mkdir($path, 0775, true) && !is_dir($path)) {
            return null;
        }

        $real = realpath($path);
        if ($real === false) {
            return null;
        }

        foreach (app(FileIndexCache::class)->refresh() as $node) {
            if (
                ($node['type'] ?? '') === 'folder'
                && ($node['parent_id'] ?? null) === null
                && ($node['source_key'] ?? '') === 'ddocs-projectdocs'
                && $this->isWritableNode($node)
            ) {
                return $node;
            }
        }

        return [
            'id' => 'ddocs-projectdocs',
            'source_key' => 'ddocs-projectdocs',
            'source_name' => ManagerText::get('project_docs') ?: 'Project Docs',
            'package_name' => 'project/docs',
            'absolute_path' => $real,
            'docs_path' => $real,
            'type' => 'folder',
            'readonly' => false,
            'is_vendor' => false,
        ];
    }

    protected function writableFolderById(string $folderId): ?array
    {
        $nodes = app(FileIndexCache::class)->index();
        foreach ($nodes as $node) {
            if (($node['id'] ?? '') === $folderId && ($node['type'] ?? '') === 'folder' && $this->isWritableNode($node)) {
                return $node;
            }
        }

        return null;
    }

    protected function nodeById(string $id): ?array
    {
        $nodes = app(FileIndexCache::class)->index();
        foreach ($nodes as $node) {
            if (($node['id'] ?? '') === $id) {
                return $node;
            }
        }

        return null;
    }

    protected function writableFolderFor(?array $node, array $nodes): ?array
    {
        if ($node !== null && ($node['type'] ?? '') === 'folder' && $this->isWritableNode($node)) {
            return $node;
        }

        if ($node !== null && ($node['type'] ?? '') === 'document' && $this->isWritableNode($node)) {
            $parentId = (string) ($node['parent_id'] ?? '');
            foreach ($nodes as $candidate) {
                if (($candidate['id'] ?? '') === $parentId && ($candidate['type'] ?? '') === 'folder' && $this->isWritableNode($candidate)) {
                    return $candidate;
                }
            }
        }

        if ($node === null) {
            foreach ($nodes as $candidate) {
                if (($candidate['type'] ?? '') === 'folder' && $this->isWritableNode($candidate)) {
                    return $candidate;
                }
            }
        }

        return null;
    }

    protected function isEmptyProjectDocsSource(array $node): bool
    {
        return ($node['source_key'] ?? '') === 'ddocs-projectdocs'
            && ($node['parent_id'] ?? null) === null
            && (int) ($node['document_count'] ?? 0) === 0
            && (int) ($node['child_count'] ?? count($node['children'] ?? [])) === 0;
    }

    protected function shouldSelectParentAfterDelete(string $parentId, array $nodes): bool
    {
        if ($parentId === '') {
            return false;
        }

        foreach ($nodes as $node) {
            if (($node['id'] ?? '') !== $parentId || ($node['type'] ?? '') !== 'folder') {
                continue;
            }

            $node['document_count'] = $this->countDocumentsUnder($parentId, $nodes);
            $node['child_count'] = $this->countChildrenUnder($parentId, $nodes);

            return !$this->isEmptyProjectDocsSource($node);
        }

        return false;
    }

    protected function safeBasename(string $name, string $fallback): string
    {
        $name = trim(str_replace(["\0", '/', '\\'], ' ', $name));
        $name = strtr($name, [
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'H', 'Д' => 'D', 'Е' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'Y', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch', 'Ь' => '', 'Ю' => 'Yu', 'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'h', 'д' => 'd', 'е' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'y', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ь' => '', 'ю' => 'yu', 'я' => 'ya',
        ]);
        $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name);
        $base = strtolower(trim($ascii !== false && trim($ascii) !== '' ? $ascii : $name));
        $base = preg_replace('/[^a-z0-9._-]+/i', '-', $base) ?: '';
        $base = trim($base, '.-_');

        return $base !== '' ? $base : $fallback;
    }

    protected function titleFromInput(string $name, string $fallback): string
    {
        $title = trim(preg_replace('/\s+/', ' ', str_replace(["\0", '/', '\\'], ' ', $name)) ?? '');
        $title = preg_replace('/\.mdx?$/i', '', $title) ?? $title;

        return $title !== '' ? $title : $fallback;
    }

    protected function uniquePath(string $directory, string $base, ?string $extension): ?string
    {
        $directory = realpath($directory);
        if ($directory === false || !is_dir($directory)) {
            return null;
        }

        $extension ??= '';
        $stem = $base;
        if ($extension === '' && preg_match('/^(.*?)(\.mdx?)$/i', $base, $matches)) {
            $stem = $matches[1];
            $extension = $matches[2];
        }

        $candidate = $directory . DIRECTORY_SEPARATOR . $stem . $extension;
        $counter = 2;
        while (file_exists($candidate)) {
            $candidate = $directory . DIRECTORY_SEPARATOR . $stem . '-' . $counter . $extension;
            $counter++;
        }

        return $candidate;
    }

    protected function isSafeNewPath(string $path, string $docsPath): bool
    {
        $parent = dirname($path);
        if (!is_dir($parent)) {
            return false;
        }

        return $this->pathIsInside($parent, $docsPath);
    }

    protected function selectPath(string $path, string $type): void
    {
        $real = realpath($path);
        if ($real === false) {
            return;
        }

        $nodes = app(FileIndexCache::class)->refresh();
        foreach ($nodes as $node) {
            if (($node['type'] ?? '') !== $type) {
                continue;
            }

            $nodePath = realpath((string) ($node['absolute_path'] ?? ''));
            if ($nodePath !== false && $nodePath === $real) {
                $this->selectedNodeId = (string) $node['id'];
                $this->selectedDocumentId = $type === 'document' ? (string) $node['id'] : null;
                $this->expandAncestors($node, $nodes);

                if ($type === 'folder') {
                    $this->expanded[(string) $node['id']] = true;
                }

                return;
            }
        }
    }

    protected function expandAncestors(array $node, array $nodes): void
    {
        $parentId = (string) ($node['parent_id'] ?? '');
        while ($parentId !== '') {
            $this->expanded[$parentId] = true;
            $parent = null;
            foreach ($nodes as $candidate) {
                if (($candidate['id'] ?? '') === $parentId) {
                    $parent = $candidate;
                    break;
                }
            }

            if ($parent === null) {
                return;
            }

            $parentId = (string) ($parent['parent_id'] ?? '');
        }
    }

    protected function isWritableNode(?array $node): bool
    {
        if ($node === null) {
            return false;
        }

        if (($node['readonly'] ?? false) || ($node['is_vendor'] ?? true)) {
            return false;
        }

        return $this->pathIsInside((string) ($node['absolute_path'] ?? ''), (string) ($node['docs_path'] ?? ''));
    }

    protected function isDeletableNode(?array $node): bool
    {
        return $this->isWritableNode($node) && ($node['parent_id'] ?? null) !== null;
    }

    protected function removeDirectory(string $path, string $docsPath): void
    {
        $root = realpath($path);
        if ($root === false || !$this->pathIsInside($root, $docsPath)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST,
        );

        foreach ($iterator as $item) {
            $itemPath = $item->getPathname();
            if (!$this->pathIsInside($itemPath, $docsPath)) {
                return;
            }

            $item->isDir() ? @rmdir($itemPath) : @unlink($itemPath);
        }

        @rmdir($root);
    }

    protected function pathIsInside(string $path, string $root): bool
    {
        $path = realpath($path);
        $root = realpath($root);

        if ($path === false || $root === false) {
            return false;
        }

        return $path === $root || str_starts_with($path, $root . DIRECTORY_SEPARATOR);
    }
}
