<?php namespace Dmi3yy\dDocs\Support;

use DOMDocument;
use DOMElement;

final class LinkResolver
{
    public function __construct(
        protected ?DocumentPath $paths = null,
    ) {
        $this->paths ??= new DocumentPath();
    }

    public function rewriteHtml(string $html, array $document, array $nodes): string
    {
        if ($html === '' || !class_exists(DOMDocument::class)) {
            return $html;
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8"><body>' . $html . '</body>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $this->sanitize($dom);

        foreach ($dom->getElementsByTagName('a') as $link) {
            if (!$link instanceof DOMElement) {
                continue;
            }

            $href = trim($link->getAttribute('href'));
            $target = $this->resolve($href, $document, $nodes);

            if ($target !== null) {
                $link->setAttribute('href', '#');
                $link->setAttribute('data-ddocs-document-id', (string) $target['id']);
                $this->appendClass($link, 'ddocs-link-internal');
                continue;
            }

            if ($this->isExternalUrl($href)) {
                $link->setAttribute('target', '_blank');
                $link->setAttribute('rel', 'noopener noreferrer');
            }

            if ($this->isRelativeDocumentLink($href)) {
                $this->appendClass($link, 'ddocs-link-missing');
                $link->setAttribute('href', '#');
                $link->setAttribute('data-ddocs-missing-link', $href);
                $link->setAttribute('title', ManagerText::get('missing_link'));
            }
        }

        foreach ($dom->getElementsByTagName('img') as $image) {
            if (!$image instanceof DOMElement) {
                continue;
            }

            $src = trim($image->getAttribute('src'));
            $dataUri = $this->imageDataUri($src, $document);

            if ($dataUri !== null) {
                $image->setAttribute('src', $dataUri);
                $this->appendClass($image, 'ddocs-image-local');
                $image->setAttribute('loading', 'lazy');
                $image->setAttribute('decoding', 'async');
                continue;
            }

            if ($this->isExternalUrl($src)) {
                $this->appendClass($image, 'ddocs-image-external');
                $image->setAttribute('loading', 'lazy');
                $image->setAttribute('decoding', 'async');
                continue;
            }

            $replacement = $dom->createElement('span', trim($image->getAttribute('alt')) ?: ManagerText::get('blocked_image'));
            $replacement->setAttribute('class', 'ddocs-image-blocked');
            $replacement->setAttribute('title', ManagerText::get('blocked_image'));
            $image->parentNode?->replaceChild($replacement, $image);
        }

        $codeBlocks = [];
        foreach ($dom->getElementsByTagName('pre') as $pre) {
            if ($pre instanceof DOMElement) {
                $codeBlocks[] = $pre;
            }
        }

        foreach ($codeBlocks as $pre) {
            if (!$pre instanceof DOMElement) {
                continue;
            }

            $code = $pre->getElementsByTagName('code')->item(0);
            if (!$code instanceof DOMElement) {
                continue;
            }

            $language = $this->codeLanguage($code);
            if ($language === '') {
                $language = $this->inferCodeLanguage($code->textContent);
            }

            if ($language === '') {
                continue;
            }

            if (in_array($language, ['plantuml', 'uml'], true)) {
                $figure = $this->umlFigure($dom, $code->textContent);
                if ($figure !== null) {
                    $pre->parentNode?->replaceChild($figure, $pre);
                }

                continue;
            }

            $this->appendClass($code, 'language-' . $language);
            $pre->setAttribute('data-ddocs-code-language', $language);
        }

        foreach (['h1', 'h2', 'h3', 'h4', 'h5', 'h6'] as $tag) {
            foreach ($dom->getElementsByTagName($tag) as $heading) {
                if (!$heading instanceof DOMElement) {
                    continue;
                }

                $id = $heading->getAttribute('id') ?: $this->slug($heading->textContent);
                if ($id === '') {
                    continue;
                }

                $heading->setAttribute('id', $id);
                $this->appendClass($heading, 'ddocs-heading');

                if ($heading->getElementsByTagName('a')->length === 0) {
                    $anchor = $dom->createElement('a', '#');
                    $anchor->setAttribute('href', '#' . $id);
                    $anchor->setAttribute('class', 'ddocs-heading-anchor');
                    $anchor->setAttribute('aria-label', ManagerText::get('copy_heading_link'));
                    $heading->appendChild($anchor);
                }
            }
        }

        $body = $dom->getElementsByTagName('body')->item(0);
        if ($body === null) {
            return $html;
        }

        $output = '';
        foreach ($body->childNodes as $child) {
            $output .= $dom->saveHTML($child);
        }

        return $output;
    }

    protected function codeLanguage(DOMElement $code): string
    {
        foreach (preg_split('/\s+/', trim($code->getAttribute('class'))) ?: [] as $class) {
            if (str_starts_with($class, 'language-')) {
                return $this->normalizeCodeLanguage(substr($class, 9));
            }
        }

        return '';
    }

    protected function umlFigure(DOMDocument $dom, string $source): ?DOMElement
    {
        $source = $this->normalizeUmlSource($source);
        if ($source === '') {
            return null;
        }

        $src = $this->umlImageSrc($source);
        if ($src === null) {
            return null;
        }

        $figure = $dom->createElement('figure');
        $image = $dom->createElement('img');

        $figure->setAttribute('class', 'ddocs-uml dtui-uml');
        $figure->setAttribute('data-uml', $this->base64UrlEncode($source));
        $figure->setAttribute('data-uml-encoding', 'base64url');
        $image->setAttribute('src', $src);
        $image->setAttribute('alt', 'uml');
        $image->setAttribute('class', 'ddocs-uml__image');
        $image->setAttribute('loading', 'eager');
        $image->setAttribute('decoding', 'async');
        $image->setAttribute('data-dtui-uml', $this->base64UrlEncode($source));
        $figure->appendChild($image);

        return $figure;
    }

    public function normalizeUmlSource(string $source): string
    {
        $source = str_replace(["\r\n", "\r"], "\n", $source);
        $source = preg_replace('/^\s*!theme\b[^\n]*(?:\n|$)/im', '', $source) ?? $source;
        $source = preg_replace("/\n{3,}/", "\n\n", $source) ?? $source;

        return trim($source);
    }

    public function umlImageSrc(string $source, string $theme = 'light'): ?string
    {
        $source = $this->normalizeUmlSource($source);
        if ($source === '') {
            return null;
        }

        $encoded = $this->plantUmlEncode($source);
        if ($encoded === '') {
            return null;
        }

        return '/ddocs/plantuml?uml=' . rawurlencode($encoded) . '&theme=' . rawurlencode($theme) . '&format=svg';
    }

    protected function plantUmlEncode(string $source): string
    {
        $data = gzdeflate($source, 9);
        if ($data === false) {
            return '';
        }

        $output = '';
        $length = strlen($data);
        for ($i = 0; $i < $length; $i += 3) {
            $b1 = ord($data[$i]);
            $b2 = $i + 1 < $length ? ord($data[$i + 1]) : 0;
            $b3 = $i + 2 < $length ? ord($data[$i + 2]) : 0;
            $c1 = $b1 >> 2;
            $c2 = (($b1 & 0x3) << 4) | ($b2 >> 4);
            $c3 = (($b2 & 0xf) << 2) | ($b3 >> 6);
            $c4 = $b3 & 0x3f;
            $output .= $this->plantUmlEncode6bit($c1)
                . $this->plantUmlEncode6bit($c2)
                . $this->plantUmlEncode6bit($c3)
                . $this->plantUmlEncode6bit($c4);
        }

        return $output;
    }

    protected function plantUmlEncode6bit(int $value): string
    {
        if ($value < 10) {
            return chr(48 + $value);
        }

        $value -= 10;
        if ($value < 26) {
            return chr(65 + $value);
        }

        $value -= 26;
        if ($value < 26) {
            return chr(97 + $value);
        }

        $value -= 26;

        return $value === 0 ? '-' : '_';
    }

    protected function base64UrlEncode(string $source): string
    {
        return rtrim(strtr(base64_encode($source), '+/', '-_'), '=');
    }

    protected function normalizeCodeLanguage(string $language): string
    {
        $language = strtolower(trim($language));

        return match ($language) {
            'console', 'shell', 'sh', 'zsh', 'terminal' => 'bash',
            'html', 'xml', 'svg' => 'markup',
            'laravel-blade', 'bladephp' => 'blade',
            'puml' => 'plantuml',
            'js' => 'javascript',
            'ts' => 'typescript',
            'yml' => 'yaml',
            default => $language,
        };
    }

    protected function inferCodeLanguage(string $code): string
    {
        $sample = trim($code);
        if ($sample === '') {
            return '';
        }

        if (str_starts_with($sample, '<?php') || preg_match('/\b(namespace|use|class|function|public|protected|private)\s+[A-Za-z_\\\\]/', $sample) === 1) {
            return 'php';
        }

        if ($this->looksLikeBlade($sample)) {
            return 'blade';
        }

        if (preg_match('/^\s*[{[]/s', $sample) === 1 && json_decode($sample) !== null) {
            return 'json';
        }

        if (preg_match('/^\s*<\/?[a-z][\s>]/i', $sample) === 1) {
            return 'markup';
        }

        if (preg_match('/(^|\n)\s*(php artisan|composer|git|npm|yarn|pnpm|vendor\/bin\/|docker|cp |mv |rm |mkdir |cd )\b/', $sample) === 1) {
            return 'bash';
        }

        if (preg_match('/^\s*(SELECT|INSERT|UPDATE|DELETE|CREATE|ALTER|DROP)\b/i', $sample) === 1) {
            return 'sql';
        }

        return '';
    }

    protected function looksLikeBlade(string $sample): bool
    {
        if (preg_match('/{{--[\s\S]*?--}}|\{!![\s\S]*?!!\}|\{\{[\s\S]*?\}\}/', $sample) === 1) {
            return true;
        }

        if (preg_match('/(^|\s)@[A-Za-z_][\w]*(?:\s*\(|\b)/', $sample) === 1) {
            return true;
        }

        return preg_match('/<\/?(?:x[-:\w.]*|livewire:[-:\w.]+)\b/i', $sample) === 1;
    }

    public function resolve(string $href, array $document, array $nodes): ?array
    {
        if (!$this->isRelativeDocumentLink($href)) {
            return null;
        }

        $href = urldecode(explode('#', $href, 2)[0]);
        $current = (string) ($document['relative_path'] ?? '');
        $base = trim(dirname($current), '.');
        $target = $this->normalizeRelative(trim($base . '/' . $href, '/'));

        $candidates = $this->candidates($target);
        $sourceKey = (string) ($document['source_key'] ?? '');
        foreach ($nodes as $node) {
            if (($node['type'] ?? '') !== 'document') {
                continue;
            }

            if ($sourceKey !== '' && (string) ($node['source_key'] ?? '') !== $sourceKey) {
                continue;
            }

            $relative = strtolower((string) ($node['relative_path'] ?? ''));
            foreach ($candidates as $candidate) {
                if ($relative === strtolower($candidate)) {
                    return $node;
                }
            }
        }

        return null;
    }

    protected function isRelativeDocumentLink(string $href): bool
    {
        if ($href === '' || str_starts_with($href, '#')) {
            return false;
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:/i', $href) === 1 || str_starts_with($href, '//')) {
            return false;
        }

        $path = strtolower(explode('#', $href, 2)[0]);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return $extension === '' || in_array($extension, ['md', 'mdx'], true);
    }

    protected function candidates(string $target): array
    {
        $target = trim($target, '/');
        if ($target === '') {
            return [];
        }

        $extension = strtolower(pathinfo($target, PATHINFO_EXTENSION));
        if (in_array($extension, ['md', 'mdx'], true)) {
            return [$target];
        }

        return [
            $target,
            $target . '.md',
            $target . '.mdx',
            $target . '/index.md',
            $target . '/index.mdx',
            $target . '/README.md',
            $target . '/README.mdx',
        ];
    }

    protected function normalizeRelative(string $path): string
    {
        $segments = [];
        foreach (explode('/', str_replace('\\', '/', $path)) as $segment) {
            if ($segment === '' || $segment === '.') {
                continue;
            }

            if ($segment === '..') {
                array_pop($segments);
                continue;
            }

            $segments[] = $segment;
        }

        return implode('/', $segments);
    }

    protected function appendClass(DOMElement $element, string $class): void
    {
        $classes = trim($element->getAttribute('class') . ' ' . $class);
        $element->setAttribute('class', $classes);
    }

    protected function slug(string $value): string
    {
        $value = mb_strtolower(trim($value));
        $value = preg_replace('/[^\pL\pN]+/u', '-', $value) ?? '';

        return trim($value, '-');
    }

    protected function sanitize(DOMDocument $dom): void
    {
        $allowedTags = [
            'a', 'abbr', 'b', 'blockquote', 'br', 'caption', 'code', 'dd', 'del', 'details', 'div', 'dl', 'dt',
            'em', 'figcaption', 'figure', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'img', 'kbd', 'li',
            'ol', 'p', 'pre', 's', 'span', 'strong', 'sub', 'summary', 'sup', 'table', 'tbody', 'td', 'tfoot',
            'th', 'thead', 'tr', 'ul',
        ];
        $removeWithChildren = ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'button', 'textarea', 'select'];

        $elements = [];
        foreach ($dom->getElementsByTagName('*') as $element) {
            if ($element instanceof DOMElement && strtolower($element->tagName) !== 'body') {
                $elements[] = $element;
            }
        }

        foreach ($elements as $element) {
            $tag = strtolower($element->tagName);
            if (in_array($tag, $removeWithChildren, true)) {
                $element->parentNode?->removeChild($element);
                continue;
            }

            if (!in_array($tag, $allowedTags, true)) {
                $this->unwrap($element);
                continue;
            }

            $attributes = [];
            foreach ($element->attributes ?? [] as $attribute) {
                $attributes[] = $attribute->name;
            }

            foreach ($attributes as $attribute) {
                $name = strtolower($attribute);
                $value = trim($element->getAttribute($attribute));

                if (str_starts_with($name, 'on') || in_array($name, ['style', 'srcset'], true)) {
                    $element->removeAttribute($attribute);
                    continue;
                }

                if (in_array($name, ['href', 'src'], true) && !$this->isSafeUrlAttribute($value)) {
                    $element->removeAttribute($attribute);
                    continue;
                }

                if (!in_array($name, ['alt', 'aria-label', 'class', 'colspan', 'decoding', 'href', 'id', 'loading', 'open', 'rel', 'rowspan', 'src', 'target', 'title'], true) && !str_starts_with($name, 'data-')) {
                    $element->removeAttribute($attribute);
                }
            }
        }
    }

    protected function unwrap(DOMElement $element): void
    {
        $parent = $element->parentNode;
        if ($parent === null) {
            return;
        }

        while ($element->firstChild !== null) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }

    protected function imageDataUri(string $src, array $document): ?string
    {
        if ($src === '' || preg_match('/^[a-z][a-z0-9+.-]*:/i', $src) === 1 || str_starts_with($src, '//')) {
            return null;
        }

        $src = urldecode(explode('#', $src, 2)[0]);
        $path = $this->localImagePath($src, $document);

        if ($path === null || !is_file($path)) {
            return null;
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $allowed = array_map('strtolower', Settings::list('allowed_image_extensions', ['png', 'jpg', 'jpeg', 'gif', 'webp']));
        if (!in_array($extension, $allowed, true)) {
            return null;
        }

        $maxKb = max(1, (int) config('dmi3yy.settings.dDocs.max_file_size_kb', 512));
        $size = filesize($path);
        if ($size === false || $size > ($maxKb * 1024)) {
            return null;
        }

        $content = file_get_contents($path);
        if ($content === false) {
            return null;
        }

        $mime = match ($extension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/png',
        };

        return 'data:' . $mime . ';base64,' . base64_encode($content);
    }

    public function imageDataUriFor(string $src, array $document): ?string
    {
        return $this->imageDataUri($src, $document);
    }

    protected function localImagePath(string $src, array $document): ?string
    {
        $docsPath = (string) ($document['docs_path'] ?? '');
        $rootPath = (string) ($document['root_path'] ?? '');
        $relative = ltrim($src, '/');
        $candidates = [];

        if (str_starts_with($src, '/')) {
            foreach ([$docsPath, $rootPath . '/docs/static', $rootPath . '/Docs/static', $rootPath . '/static', $rootPath] as $root) {
                if (trim($root) !== '') {
                    $candidates[] = rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
                }
            }
        } else {
            $base = dirname((string) ($document['absolute_path'] ?? ''));
            $candidates[] = $base . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $src);
        }

        foreach ($candidates as $candidate) {
            $path = $this->paths->normalize($candidate);
            if ($path === null || !is_file($path)) {
                continue;
            }

            if ($docsPath !== '' && $this->paths->isInside($path, $docsPath)) {
                return $path;
            }

            if ($rootPath !== '' && $this->paths->isInside($path, $rootPath)) {
                return $path;
            }
        }

        return null;
    }

    protected function isExternalUrl(string $value): bool
    {
        return preg_match('/^https?:\/\//i', trim($value)) === 1;
    }

    protected function isSafeUrlAttribute(string $value): bool
    {
        $value = trim($value);
        if ($value === '' || str_starts_with($value, '#') || str_starts_with($value, '/') || str_starts_with($value, './') || str_starts_with($value, '../')) {
            return true;
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:/i', $value) !== 1 && !str_starts_with($value, '//')) {
            return true;
        }

        return preg_match('/^(https?:|mailto:)/i', $value) === 1;
    }
}
