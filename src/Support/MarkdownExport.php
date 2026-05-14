<?php namespace Dmi3yy\dDocs\Support;

final class MarkdownExport
{
    public function __construct(
        protected ?FileIndexCache $index = null,
        protected ?FileDocumentRepository $documents = null,
    ) {
        $this->index ??= new FileIndexCache();
        $this->documents ??= new FileDocumentRepository();
    }

    public function build(?string $language = null): array
    {
        $nodes = $this->index->index($language);
        $documents = array_values(array_filter(
            $nodes,
            static fn (array $node): bool => ($node['type'] ?? '') === 'document'
        ));

        $body = [];

        $currentSource = null;
        $exported = 0;

        foreach ($documents as $node) {
            $markdown = $this->documents->read($node);
            if ($markdown === null) {
                continue;
            }

            $sourceName = trim((string) ($node['source_name'] ?? $node['package_name'] ?? 'Documentation'));
            if ($sourceName !== $currentSource) {
                $currentSource = $sourceName;
                $body[] = '## ' . $this->heading($sourceName);
                $body[] = '';
            }

            $body[] = '---';
            $body[] = '';
            $body[] = '### ' . $this->heading((string) ($node['title'] ?? basename((string) ($node['relative_path'] ?? 'Document'))));
            $body[] = '';
            $body[] = '- Path: `' . (string) ($node['relative_path'] ?? '') . '`';
            $body[] = '- Language: `' . (string) ($node['language'] ?? 'neutral') . '`';
            $body[] = '- Read-only: `' . (($node['readonly'] ?? true) ? 'yes' : 'no') . '`';
            $body[] = '';
            $body[] = rtrim($markdown);
            $body[] = '';
            $exported++;
        }

        $header = [
            '# ' . (ManagerText::get('export_title') ?: 'Documentation export'),
            '',
            '- Generated: `' . date('c') . '`',
            '- Documents: `' . $exported . '`',
            '- Source: `dDocs`',
            '',
            '> ' . (ManagerText::get('export_note') ?: 'This file is generated from indexed dDocs Markdown sources.'),
            '',
        ];

        $content = implode("\n", array_merge($header, $body));
        $filename = 'ddocs-export-' . date('Ymd-His') . '.md';

        return [
            'content' => rtrim($content) . "\n",
            'filename' => $filename,
            'document_count' => $exported,
        ];
    }

    protected function heading(string $value): string
    {
        $value = trim(preg_replace('/\s+/', ' ', $value) ?? $value);

        return str_replace(["\r", "\n"], ' ', $value === '' ? 'Documentation' : $value);
    }
}
