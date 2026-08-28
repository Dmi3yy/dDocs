@php
    $manager = app(\EvoUI\Support\ManagerContext::class);
    $theme = $manager->theme();
    $themeMode = $manager->themeMode($theme);
    $themeClasses = $manager->themeClasses($theme);
    $themeBackground = $manager->themeBackground($theme);
    $ui = $ui ?? \Dmi3yy\dDocs\Support\ManagerText::all();
    $dtuiRoot = public_path('assets/plugins/dTui.editor');
    $managerBaseUrl = defined('MODX_BASE_URL') ? MODX_BASE_URL : '/';
    $dtuiUrl = $managerBaseUrl . 'assets/plugins/dTui.editor';
    $dtuiAsset = static function (string $file) use ($dtuiRoot, $dtuiUrl): ?string {
        $path = rtrim($dtuiRoot, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR);

        if (!is_file($path)) {
            return null;
        }

        return rtrim($dtuiUrl, '/') . '/' . ltrim($file, '/') . '?v=' . filemtime($path);
    };
@endphp
<!doctype html>
<html
    class="evo-ui-page {{ $themeClasses }}"
    lang="{{ str_replace('_', '-', app()->getLocale() ?: 'uk') }}"
    data-theme="{{ $theme }}"
    data-theme-mode="{{ $themeMode }}"
    style="background-color: var(--evo-ui-bg, {{ $themeBackground }})"
>
<head>
    <meta charset="utf-8">
    <meta name="color-scheme" content="{{ $themeMode === 'dark' ? 'dark light' : 'light dark' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $ui['module_title'] ?? $ui['docs'] ?? 'Documentation' }}</title>
    @include('evo::partials.assets')
    <script>window.parent?.evo?.moduleViewport?.requestHiddenTree(window);</script>
    @if($href = $dtuiAsset('vendor/toastui-editor.min.css'))
        <link rel="stylesheet" href="{{ $href }}">
    @endif
    @if($href = $dtuiAsset('vendor/toastui-editor-dark.min.css'))
        <link rel="stylesheet" href="{{ $href }}">
    @endif
    @if($href = $dtuiAsset('vendor/toastui-editor-plugin-code-syntax-highlight.min.css'))
        <link rel="stylesheet" href="{{ $href }}">
    @endif
    @if($href = $dtuiAsset('vendor/toastui-editor-plugin-table-merged-cell.min.css'))
        <link rel="stylesheet" href="{{ $href }}">
    @endif
    @if($href = $dtuiAsset('vendor/toastui-editor-plugin-color-syntax.min.css'))
        <link rel="stylesheet" href="{{ $href }}">
    @endif
    @if($href = $dtuiAsset('vendor/prism.min.css'))
        <link rel="stylesheet" href="{{ $href }}">
    @endif
    @if($href = $dtuiAsset('css/dtui-editor.css'))
        <link rel="stylesheet" href="{{ $href }}">
    @endif
</head>
<body
    class="evo-ui-page {{ $themeClasses }}"
    data-theme="{{ $theme }}"
    data-theme-mode="{{ $themeMode }}"
    style="background-color: var(--evo-ui-bg, {{ $themeBackground }})"
>
    <div
        class="evo-ui {{ $themeClasses }}"
        data-evo-ui-root
        data-theme="{{ $theme }}"
        data-theme-mode="{{ $themeMode }}"
    >
        <livewire:ddocs.module-panel
            :tabs="$tabs"
            :active-tab="$activeTab"
            :context="['moduleUrl' => $moduleUrl]"
        />
    </div>
    @if($src = $dtuiAsset('vendor/prism.min.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('vendor/prism-evo-languages.min.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('vendor/toastui-editor-all.min.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('vendor/tui-color-picker.min.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('vendor/toastui-chart.min.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('vendor/toastui-editor-plugin-code-syntax-highlight.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('vendor/toastui-editor-plugin-table-merged-cell.min.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('vendor/toastui-editor-plugin-color-syntax.min.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('vendor/toastui-editor-plugin-chart.min.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('vendor/toastui-editor-plugin-uml.min.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('js/dtui-image.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('js/dtui-evolinks.js'))
        <script src="{{ $src }}"></script>
    @endif
    @if($src = $dtuiAsset('js/dtui-init.js'))
        <script src="{{ $src }}"></script>
    @endif
    <script>
        (function () {
            'use strict';

            var copyCodeLabel = @js($ui['copy_code'] ?? 'Copy code');
            var copiedCodeLabel = @js($ui['copied_code'] ?? 'Copied');

            function normalizeCodeLanguage(language) {
                language = String(language || '').toLowerCase();

                if (language === 'laravel-blade' || language === 'bladephp') {
                    return 'blade';
                }

                if (language === 'md') {
                    return 'markdown';
                }

                if (language === 'yml') {
                    return 'yaml';
                }

                if (language === 'none' || language === 'no-highlight' || language === 'text' || language === 'txt') {
                    return '';
                }

                return language;
            }

            function codeLanguage(code, pre) {
                var language = Array.prototype.find.call(code.classList || [], function (item) {
                    return item.indexOf('language-') === 0;
                });

                if (language) {
                    return normalizeCodeLanguage(language.replace(/^language-/, ''));
                }

                return pre && pre.dataset ? normalizeCodeLanguage(pre.dataset.ddocsCodeLanguage || pre.dataset.language || '') : '';
            }

            function copyIcon() {
                return '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M8 8.5c0-1.4 1.1-2.5 2.5-2.5h6C17.9 6 19 7.1 19 8.5v8c0 1.4-1.1 2.5-2.5 2.5h-6C9.1 19 8 17.9 8 16.5v-8Zm2.5-.5c-.3 0-.5.2-.5.5v8c0 .3.2.5.5.5h6c.3 0 .5-.2.5-.5v-8c0-.3-.2-.5-.5-.5h-6ZM5 13.5V5.5C5 4.1 6.1 3 7.5 3h6c.6 0 1 .4 1 1s-.4 1-1 1h-6c-.3 0-.5.2-.5.5v8c0 .6-.4 1-1 1s-1-.4-1-1Z" fill="currentColor"/></svg>';
            }

            function writeClipboard(value) {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    return navigator.clipboard.writeText(value);
                }

                var textarea = document.createElement('textarea');
                textarea.value = value;
                textarea.setAttribute('readonly', 'readonly');
                textarea.style.position = 'fixed';
                textarea.style.left = '-9999px';
                document.body.appendChild(textarea);
                textarea.select();

                try {
                    document.execCommand('copy');
                } finally {
                    textarea.remove();
                }

                return Promise.resolve();
            }

            function ddocsViewerPlugins() {
                var registry = window.toastui && window.toastui.Editor && window.toastui.Editor.plugin;
                var plugins = [];

                if (!registry) {
                    return plugins;
                }

                if (registry.codeSyntaxHighlight && window.Prism) {
                    plugins.push([registry.codeSyntaxHighlight, {
                        highlighter: {
                            languages: {
                                html: window.Prism.languages.markup,
                                markup: window.Prism.languages.markup,
                                xml: window.Prism.languages.markup,
                                css: window.Prism.languages.css,
                                scss: window.Prism.languages.scss,
                                javascript: window.Prism.languages.javascript,
                                js: window.Prism.languages.javascript,
                                typescript: window.Prism.languages.typescript,
                                ts: window.Prism.languages.typescript,
                                php: window.Prism.languages.php,
                                blade: window.Prism.languages.blade,
                                'laravel-blade': window.Prism.languages.blade,
                                bladephp: window.Prism.languages.blade,
                                sql: window.Prism.languages.sql,
                                json: window.Prism.languages.json,
                                markdown: window.Prism.languages.markdown,
                                md: window.Prism.languages.markdown,
                                bash: window.Prism.languages.bash,
                                shell: window.Prism.languages.bash,
                                sh: window.Prism.languages.bash,
                                yaml: window.Prism.languages.yaml,
                                yml: window.Prism.languages.yaml
                            },
                            highlight: window.Prism.highlight.bind(window.Prism),
                            tokenize: window.Prism.tokenize.bind(window.Prism)
                        }
                    }]);
                }

                if (registry.tableMergedCell) {
                    plugins.push(registry.tableMergedCell);
                }

                return plugins;
            }

            function readDdocsPayload(viewer) {
                var payloadId = viewer.dataset.ddocsPayloadId || '';
                var script = payloadId ? document.getElementById(payloadId) : null;
                if (!script) {
                    return null;
                }

                try {
                    return JSON.parse(script.textContent || '{}');
                } catch (e) {
                    console.warn('dDocs viewer payload parse failed', e);
                    return null;
                }
            }

            function escapeHtml(value) {
                return String(value || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function safeBase64UrlEncode(value) {
                var text = String(value || '');
                var binary = '';
                var bytes;

                try {
                    if (window.TextEncoder) {
                        bytes = new window.TextEncoder().encode(text);
                        for (var i = 0; i < bytes.length; i += 1) {
                            binary += String.fromCharCode(bytes[i]);
                        }
                    } else {
                        binary = unescape(encodeURIComponent(text));
                    }

                    return window.btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/g, '');
                } catch (e) {
                    return '';
                }
            }

            function maskLiteralBlocks(markdown) {
                var blocks = [];
                var text = String(markdown || '');
                var mask = function (value) {
                    var token = '@@DDOCS_LITERAL_' + blocks.length + '@@';
                    blocks.push(value);
                    return token;
                };

                text = text.replace(/(^|\n)(`{3,}|~{3,})[^\n]*\n[\s\S]*?\n\2[ \t]*(?=\n|$)/g, function (match, prefix) {
                    return prefix + mask(match.slice(prefix.length));
                });
                text = text.replace(/(^|\n)\$\$uml[ \t]*\n[\s\S]*?\n\$\$[ \t]*(?=\n|$)/gi, function (match, prefix) {
                    return prefix + mask(match.slice(prefix.length));
                });

                return {
                    text: text,
                    restore: function (value) {
                        return String(value || '').replace(/@@DDOCS_LITERAL_(\d+)@@/g, function (match, index) {
                            return blocks[Number(index)] || match;
                        });
                    }
                };
            }

            function preprocessUmlBlocks(markdown) {
                return String(markdown || '').replace(/\$\$uml[ \t]*\n([\s\S]*?)\n\$\$/gi, function (match, source) {
                    var normalized = normalizeUmlSource(source);

                    return '\n```uml\n' + normalized + '\n```\n';
                });
            }

            function normalizeUmlSource(source) {
                return String(source || '')
                    .replace(/\r\n?/g, '\n')
                    .replace(/^\s*!theme\b[^\n]*(?:\n|$)/gim, '')
                    .replace(/\n{3,}/g, '\n\n')
                    .replace(/^\n+|\n+$/g, '');
            }

            function umlMapValue(items, source) {
                var normalized = normalizeUmlSource(source);

                for (var i = 0; i < (items || []).length; i += 1) {
                    if (normalizeUmlSource(items[i].source || '') === normalized) {
                        return items[i].src || '';
                    }
                }

                return '';
            }

            function umlItemBySource(items, source) {
                var normalized = normalizeUmlSource(source);

                for (var i = 0; i < (items || []).length; i += 1) {
                    if (normalizeUmlSource(items[i].source || '') === normalized && items[i].src) {
                        return items[i];
                    }
                }

                return null;
            }

            function umlItemAt(items, index) {
                if (!items || index < 0 || !items[index] || !items[index].src) {
                    return null;
                }

                return items[index];
            }

            function umlItemFor(items, source, index) {
                return umlItemAt(items, index) || umlItemBySource(items, source);
            }

            var ddocsUmlPlaceholderItems = [];

            function umlPlaceholderToken(index) {
                return 'DDOCSUMLBLOCK' + String(index);
            }

            function umlFigureHtml(source, src) {
                var encodedSource = safeBase64UrlEncode(source);

                return '<figure class="ddocs-uml dtui-uml" data-uml="' + escapeHtml(encodedSource) + '" data-uml-encoding="base64url">'
                    + '<img src="' + escapeHtml(src) + '" alt="uml" class="ddocs-uml__image ddocs-image-local" loading="lazy" decoding="async">'
                    + '</figure>';
            }

            function createUmlFallbackBlock(source) {
                var pre = document.createElement('pre');
                var code = document.createElement('code');

                code.className = 'language-uml';
                code.textContent = normalizeUmlSource(source);
                pre.className = 'ddocs-uml-fallback';
                pre.setAttribute('data-ddocs-code-language', 'uml');
                pre.appendChild(code);

                return pre;
            }

            function fallbackBrokenUmlImage(image, source) {
                var figure = image ? image.closest('figure.ddocs-uml, figure.dtui-uml') : null;
                var target = figure || image;

                if (!target || !target.parentNode || !source) {
                    return;
                }

                target.parentNode.replaceChild(createUmlFallbackBlock(source), target);
            }

            function bindUmlImageRecovery(image, source, src) {
                if (!image || image.dataset.ddocsUmlRecoveryBound === '1') {
                    return;
                }

                image.dataset.ddocsUmlRecoveryBound = '1';
                image.addEventListener('error', function () {
                    if (image.dataset.ddocsUmlRetried !== '1' && src) {
                        image.dataset.ddocsUmlRetried = '1';
                        image.setAttribute('src', src + (src.indexOf('?') === -1 ? '?' : '&') + 'retry=' + Date.now());
                        return;
                    }

                    fallbackBrokenUmlImage(image, source);
                });

                window.setTimeout(function () {
                    if (image.complete && image.naturalWidth === 0) {
                        fallbackBrokenUmlImage(image, source);
                    }
                }, 5000);
            }

            function createUmlFigure(source, src) {
                var normalized = normalizeUmlSource(source);
                var encodedSource = safeBase64UrlEncode(normalized);
                var figure = document.createElement('figure');
                var image = document.createElement('img');

                figure.className = 'ddocs-uml dtui-uml';
                figure.setAttribute('data-uml', encodedSource);
                figure.setAttribute('data-uml-encoding', 'base64url');

                image.src = src;
                image.alt = 'uml';
                image.className = 'ddocs-uml__image ddocs-image-local';
                image.loading = 'lazy';
                image.decoding = 'async';
                image.setAttribute('data-dtui-uml', encodedSource);
                bindUmlImageRecovery(image, normalized, src);

                figure.appendChild(image);

                return figure;
            }

            function replaceUmlBlocksWithPlaceholders(markdown, payload, placeholderItems) {
                var blockIndex = 0;
                var items = placeholderItems || ddocsUmlPlaceholderItems;

                items.length = 0;

                return String(markdown || '').replace(/(^|\n)\$\$uml[ \t]*\n([\s\S]*?)\n\$\$[ \t]*(?=\n|$)/gi, function (match, prefix, source) {
                    var normalized = normalizeUmlSource(source);
                    var umlItems = (payload || {}).uml || [];
                    var item = umlItemFor(umlItems, normalized, blockIndex);
                    var token = umlPlaceholderToken(blockIndex);

                    if (!item || !item.src) {
                        var mappedSrc = umlMapValue(umlItems, normalized);
                        item = mappedSrc ? { source: normalized, src: mappedSrc } : null;
                    }

                    items[blockIndex] = item;
                    blockIndex += 1;

                    return prefix + '\n\n' + token + '\n\n';
                });
            }

            function preprocessMarkdownItSyntax(markdown) {
                var masked = maskLiteralBlocks(markdown);
                var text = masked.text;
                var footnotes = [];
                var footnoteMap = {};
                var inlineFootnote = 0;
                var abbreviations = {};

                text = text.replace(/^\*\[([^\]]+)]:[ \t]*(.+)$/gm, function (match, key, title) {
                    abbreviations[key] = title.trim();
                    return '';
                });

                text = text.replace(/^\[\^([^\]]+)]:[ \t]*([\s\S]*?)(?=\n\[\^[^\]]+]:|\n{2,}\S|\n?$)/gm, function (match, id, body) {
                    if (!footnoteMap[id]) {
                        footnoteMap[id] = footnotes.length + 1;
                        footnotes.push({ id: id, body: body.replace(/\n {4}/g, '\n').trim() });
                    }

                    return '';
                });

                text = text.replace(/\^\[([^\]]+)]/g, function (match, body) {
                    inlineFootnote += 1;
                    var id = 'inline-' + inlineFootnote;
                    footnoteMap[id] = footnotes.length + 1;
                    footnotes.push({ id: id, body: body.trim() });

                    return '<sup class="ddocs-footnote-ref"><a href="#fn-' + id + '" id="fnref-' + id + '">' + footnoteMap[id] + '</a></sup>';
                });

                text = text.replace(/\[\^([^\]]+)]/g, function (match, id) {
                    var index = footnoteMap[id];
                    if (!index) {
                        return match;
                    }

                    return '<sup class="ddocs-footnote-ref"><a href="#fn-' + id + '" id="fnref-' + id + '">' + index + '</a></sup>';
                });

                text = text.replace(/^([^\n:][^\n]+)\n\n: {1,3}([^\n]+(?:\n(?!\n)[^\n:][^\n]+)*)/gm, function (match, term, description) {
                    return '<dl class="ddocs-definition-list"><dt>' + term.trim() + '</dt><dd>' + description.trim() + '</dd></dl>';
                });

                text = text.replace(/^([^\n:][^\n]+)\n(?: {2}~[ \t]*[^\n]+(?:\n|$))+/gm, function (match, term) {
                    var defs = match.split('\n').slice(1).filter(function (line) {
                        return /^\s*~/.test(line);
                    }).map(function (line) {
                        return '<dd>' + line.replace(/^\s*~\s*/, '').trim() + '</dd>';
                    }).join('');

                    return '<dl class="ddocs-definition-list"><dt>' + term.trim() + '</dt>' + defs + '</dl>';
                });

                text = text
                    .replace(/(^|[^~])~([^~\s][^~]*?)~(?!~)/g, '$1<sub>$2</sub>')
                    .replace(/\^([^^\s][^^]*?)\^/g, '<sup>$1</sup>')
                    .replace(/\+\+([^\n+][^\n]*?)\+\+/g, '<ins>$1</ins>')
                    .replace(/==([^\n=][^\n]*?)==/g, '<mark>$1</mark>')
                    .replace(/:wink:/g, '😉')
                    .replace(/:cry:/g, '😢')
                    .replace(/:laughing:/g, '😆')
                    .replace(/:yum:/g, '😋')
                    .replace(/(^|[\s(]):-\)/g, '$1😀')
                    .replace(/(^|[\s(]):-\(/g, '$1🙁')
                    .replace(/(^|[\s(])8-\)/g, '$1😎')
                    .replace(/(^|[\s(]);\)/g, '$1😉');

                text = text.replace(/^::: *([a-z0-9_-]+)[ \t]*\n([\s\S]*?)\n:::[ \t]*$/gmi, function (match, type, body) {
                    return '<div class="ddocs-container ddocs-container--' + escapeHtml(type.toLowerCase()) + '">' + body.trim() + '</div>';
                });

                Object.keys(abbreviations).forEach(function (key) {
                    var pattern = new RegExp('\\b' + key.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '\\b', 'g');
                    text = text.replace(pattern, '<abbr title="' + escapeHtml(abbreviations[key]) + '">' + escapeHtml(key) + '</abbr>');
                });

                if (footnotes.length > 0) {
                    text += '\n\n<section class="ddocs-footnotes"><ol>';
                    footnotes.forEach(function (item) {
                        text += '<li id="fn-' + escapeHtml(item.id) + '">' + item.body + ' <a href="#fnref-' + escapeHtml(item.id) + '" class="ddocs-footnote-backref">↩</a></li>';
                    });
                    text += '</ol></section>';
                }

                return masked.restore(text);
            }

            function preprocessMarkdownForViewer(markdown, payload, placeholderItems) {
                if (placeholderItems) {
                    placeholderItems.length = 0;
                }

                return preprocessMarkdownItSyntax(replaceUmlBlocksWithPlaceholders(markdown, payload || {}, placeholderItems));
            }

            function normalizeMarkdownUrl(value) {
                value = String(value || '').trim();
                if (!value) {
                    return '';
                }

                try {
                    value = decodeURIComponent(value);
                } catch (e) {}

                return value.split('#')[0].replace(/^\.?\//, '');
            }

            function mappedValue(items, keyName, value, targetName) {
                var normalized = normalizeMarkdownUrl(value);
                for (var i = 0; i < (items || []).length; i += 1) {
                    if (normalizeMarkdownUrl(items[i][keyName]) === normalized) {
                        return items[i][targetName] || '';
                    }
                }

                return '';
            }

            function isExternalUrl(value) {
                return /^https?:\/\//i.test(String(value || '').trim());
            }

            function isRelativeDocumentLink(value) {
                value = String(value || '').trim();
                if (!value || value.charAt(0) === '#' || /^[a-z][a-z0-9+.-]*:/i.test(value) || value.indexOf('//') === 0) {
                    return false;
                }

                var path = value.split('#')[0].toLowerCase();
                var match = path.match(/\.([a-z0-9]+)$/);
                return !match || ['md', 'mdx'].indexOf(match[1]) !== -1;
            }

            function sanitizeRenderedHtml(viewer) {
                viewer.querySelectorAll('script, style, iframe, object, embed, form').forEach(function (node) {
                    node.remove();
                });

                viewer.querySelectorAll('*').forEach(function (node) {
                    Array.prototype.slice.call(node.attributes || []).forEach(function (attribute) {
                        var name = attribute.name.toLowerCase();
                        var value = String(attribute.value || '').trim();

                        if (name.indexOf('on') === 0 || ((name === 'href' || name === 'src') && /^(javascript:|data:text\/html)/i.test(value))) {
                            node.removeAttribute(attribute.name);
                        }
                    });
                });
            }

            function enableDetailsBlocks(viewer) {
                viewer.querySelectorAll('details').forEach(function (details) {
                    var summary = details.querySelector(':scope > summary');
                    if (!summary) {
                        return;
                    }

                    if (!details.querySelector(':scope > .ddocs-details-body')) {
                        var body = document.createElement('div');
                        body.className = 'ddocs-details-body';
                        var node = summary.nextSibling;
                        while (node) {
                            var next = node.nextSibling;
                            body.appendChild(node);
                            node = next;
                        }
                        details.appendChild(body);
                    }
                });

                viewer.querySelectorAll('details > summary').forEach(function (summary) {
                    if (summary.dataset.ddocsDetailsReady === '1') {
                        return;
                    }

                    summary.dataset.ddocsDetailsReady = '1';
                    summary.addEventListener('click', function (event) {
                        event.preventDefault();
                        var details = summary.parentElement;
                        if (details) {
                            details.open = !details.open;
                        }
                    });
                });
            }

            function safeBase64UrlDecode(value) {
                value = String(value || '').replace(/-/g, '+').replace(/_/g, '/');
                if (!value) {
                    return '';
                }

                while (value.length % 4) {
                    value += '=';
                }

                try {
                    var binary = window.atob(value);
                    if (window.TextDecoder) {
                        var bytes = new Uint8Array(binary.length);
                        for (var i = 0; i < binary.length; i += 1) {
                            bytes[i] = binary.charCodeAt(i);
                        }

                        return new window.TextDecoder('utf-8').decode(bytes);
                    }

                    return decodeURIComponent(Array.prototype.map.call(binary, function (char) {
                        return '%' + ('00' + char.charCodeAt(0).toString(16)).slice(-2);
                    }).join(''));
                } catch (e) {
                    return '';
                }
            }

            function umlSourceFromNode(node) {
                if (!node) {
                    return '';
                }

                var direct = node.getAttribute('data-uml') || '';
                if (direct && node.getAttribute('data-uml-encoding') === 'text') {
                    return direct;
                }

                if (direct) {
                    return safeBase64UrlDecode(direct);
                }

                return safeBase64UrlDecode(node.getAttribute('data-dtui-uml') || '');
            }

            function replaceWithUmlFigure(node, source, payload, index) {
                var item = umlItemFor((payload || {}).uml || [], source, typeof index === 'number' ? index : -1);
                var normalized = item ? normalizeUmlSource(item.source || source) : normalizeUmlSource(source);
                var src = item ? (item.src || '') : umlMapValue((payload || {}).uml || [], normalized);
                var figure;

                if (!normalized || !src || !node || !node.parentNode) {
                    return false;
                }

                figure = createUmlFigure(normalized, src);
                node.parentNode.replaceChild(figure, node);
                return true;
            }

            function replaceWithUmlFigureByItem(node, item) {
                var source = item ? normalizeUmlSource(item.source || '') : '';
                var src = item ? (item.src || '') : '';
                var figure;

                if (!source || !src || !node || !node.parentNode) {
                    return false;
                }

                figure = createUmlFigure(source, src);
                node.parentNode.replaceChild(figure, node);
                return true;
            }

            function resolveUmlPlaceholderItem(placeholderItems, payload, index) {
                var umlItems = (payload || {}).uml || [];
                var item = index >= 0 ? placeholderItems[index] : null;

                if (!item || !item.src) {
                    item = index >= 0 ? umlItems[index] : null;
                }

                if ((!item || !item.src) && placeholderItems[index] && placeholderItems[index].source) {
                    item = umlItemBySource(umlItems, placeholderItems[index].source) || item;
                }

                return item && item.src ? item : null;
            }

            function umlPlaceholderReplaceTarget(textNode, token, viewer) {
                var container = textNode.parentElement;
                var replaceableTags = ['P', 'DIV', 'PRE', 'LI', 'BLOCKQUOTE'];
                var tagName;

                if (container && container.tagName === 'CODE' && container.parentElement && container.parentElement.tagName === 'PRE') {
                    container = container.parentElement;
                }

                while (container && container !== viewer) {
                    tagName = container.tagName || '';

                    if ((container.textContent || '').trim() === token && replaceableTags.indexOf(tagName) !== -1) {
                        return container;
                    }

                    if (replaceableTags.indexOf(tagName) !== -1) {
                        break;
                    }

                    container = container.parentElement;
                }

                return textNode;
            }

            function replaceUmlPlaceholderTextNode(textNode, payload, placeholderItems, viewer) {
                var text = textNode.nodeValue || '';
                var pattern = /DDOCSUMLBLOCK(\d+)/g;
                var exact = text.trim().match(/^DDOCSUMLBLOCK(\d+)$/);
                var fragment;
                var lastIndex;
                var match;
                var target;
                var item;
                var figure;

                if (exact) {
                    item = resolveUmlPlaceholderItem(placeholderItems, payload, Number(exact[1]));
                    target = umlPlaceholderReplaceTarget(textNode, exact[0], viewer);

                    if (item && item.src) {
                        replaceWithUmlFigureByItem(target, item);
                    }

                    return;
                }

                fragment = document.createDocumentFragment();
                lastIndex = 0;

                while ((match = pattern.exec(text))) {
                    if (match.index > lastIndex) {
                        fragment.appendChild(document.createTextNode(text.slice(lastIndex, match.index)));
                    }

                    item = resolveUmlPlaceholderItem(placeholderItems, payload, Number(match[1]));

                    if (item && item.src) {
                        figure = createUmlFigure(item.source || '', item.src);
                        fragment.appendChild(figure);
                    } else {
                        fragment.appendChild(document.createTextNode(match[0]));
                    }

                    lastIndex = match.index + match[0].length;
                }

                if (lastIndex < text.length) {
                    fragment.appendChild(document.createTextNode(text.slice(lastIndex)));
                }

                if (fragment.childNodes.length > 0 && textNode.parentNode) {
                    textNode.parentNode.replaceChild(fragment, textNode);
                }
            }

            function recoverUmlPlaceholders(viewer, payload) {
                var placeholderItems = viewer.ddocsUmlPlaceholderItems || ddocsUmlPlaceholderItems || [];
                var nodes = [];
                var walker = document.createTreeWalker(viewer, NodeFilter.SHOW_TEXT, {
                    acceptNode: function (node) {
                        return /DDOCSUMLBLOCK\d+/.test(node.nodeValue || '')
                            ? NodeFilter.FILTER_ACCEPT
                            : NodeFilter.FILTER_REJECT;
                    }
                });
                var node;

                while ((node = walker.nextNode())) {
                    nodes.push(node);
                }

                nodes.forEach(function (textNode) {
                    replaceUmlPlaceholderTextNode(textNode, payload || {}, placeholderItems, viewer);
                });
            }

            function recoverStoredUmlFigures(viewer, payload) {
                var umlItems = (payload || {}).uml || [];
                var nodes = [];
                var seen = [];

                viewer.querySelectorAll('figure.dtui-uml, figure.ddocs-uml').forEach(function (figure) {
                    nodes.push(figure);
                    seen.push(figure);
                });

                viewer.querySelectorAll('img[data-dtui-uml]').forEach(function (image) {
                    var figure = image.closest('figure');
                    if (figure && seen.indexOf(figure) !== -1) {
                        return;
                    }

                    nodes.push(figure || image);
                    if (figure) {
                        seen.push(figure);
                    }
                });

                nodes.forEach(function (node, index) {
                    var figure = node.tagName && node.tagName.toLowerCase() === 'figure' ? node : node.closest('figure');
                    var image = node.tagName && node.tagName.toLowerCase() === 'img' ? node : node.querySelector('img');
                    var fallback = umlItems[index] || {};
                    var source = umlSourceFromNode(node) || umlSourceFromNode(figure) || umlSourceFromNode(image) || fallback.source || '';
                    var item = fallback.src ? fallback : umlItemBySource(umlItems, source);
                    var src = item ? (item.src || '') : (source ? umlMapValue(umlItems, source) : '');
                    var currentSrc = image ? (image.getAttribute('src') || '') : '';

                    if (figure && src) {
                        replaceWithUmlFigure(figure, item ? (item.source || source) : source, payload, index);
                        return;
                    }

                    if (!image) {
                        return;
                    }

                    image.classList.add('ddocs-uml__image', 'ddocs-image-local');
                    image.setAttribute('loading', 'lazy');
                    image.setAttribute('decoding', 'async');
                    bindUmlImageRecovery(image, source, src || currentSrc);

                    if (src && currentSrc !== src) {
                        image.setAttribute('src', src);
                    }
                });
            }

            function recoverRenderedUmlCodeBlocks(viewer, payload) {
                var umlItems = (payload || {}).uml || [];
                var umlCodeIndex = 0;

                viewer.querySelectorAll('pre').forEach(function (pre) {
                    var code = pre.querySelector('code');
                    var language = code ? codeLanguage(code, pre) : normalizeCodeLanguage(pre.dataset.language || pre.dataset.ddocsCodeLanguage || '');
                    var source = code ? (code.textContent || '') : (pre.textContent || '');
                    var item;

                    if (pre.closest('figure.ddocs-uml, figure.dtui-uml')) {
                        return;
                    }

                    if (!language && /^\s*(UML|PLANTUML)\s*\n/i.test(source)) {
                        source = source.replace(/^\s*(UML|PLANTUML)\s*\n/i, '');
                        language = 'uml';
                    }

                    if (language !== 'uml' && language !== 'plantuml') {
                        return;
                    }

                    item = umlItemFor(umlItems, source, umlCodeIndex);
                    umlCodeIndex += 1;

                    if (item && replaceWithUmlFigureByItem(pre, item)) {
                        return;
                    }

                    replaceWithUmlFigure(pre, source, payload);
                });
            }

            function recoverUmlBlocks(viewer, payload) {
                recoverUmlPlaceholders(viewer, payload || {});
                recoverStoredUmlFigures(viewer, payload || {});
                recoverRenderedUmlCodeBlocks(viewer, payload || {});
                repairUmlImages(viewer, payload || {});
            }

            function repairUmlImages(viewer, payload) {
                var umlItems = (payload || {}).uml || [];

                viewer.querySelectorAll('figure.ddocs-uml, figure.dtui-uml').forEach(function (figure, index) {
                    var image = figure.querySelector('img');
                    var source = umlSourceFromNode(figure) || umlSourceFromNode(image);
                    var item = umlItemFor(umlItems, source, index);
                    var src = item ? (item.src || '') : (source ? umlMapValue(umlItems, source) : '');

                    if (!src && image) {
                        src = image.getAttribute('src') || '';
                    }

                    if (!src) {
                        return;
                    }

                    if (!image) {
                        image = document.createElement('img');
                        image.alt = 'uml';
                        figure.appendChild(image);
                    }

                    image.classList.add('ddocs-uml__image', 'ddocs-image-local');
                    image.setAttribute('loading', 'lazy');
                    image.setAttribute('decoding', 'async');

                    if (item && item.source) {
                        figure.setAttribute('data-uml', safeBase64UrlEncode(item.source));
                        figure.setAttribute('data-uml-encoding', 'base64url');
                        image.setAttribute('data-dtui-uml', safeBase64UrlEncode(item.source));
                    }

                    if ((image.getAttribute('src') || '') !== src) {
                        image.setAttribute('src', src);
                    }

                    bindUmlImageRecovery(image, item && item.source ? item.source : source, src);
                });
            }

            function normalizeViewerUmlImages(viewer) {
                viewer.querySelectorAll('img[src]').forEach(function (image) {
                    var src = image.getAttribute('src') || '';
                    if (src.indexOf('dtui-plantuml/') === -1 && src.indexOf('plantuml') === -1) {
                        return;
                    }

                    image.classList.add('ddocs-uml__image', 'ddocs-image-local');
                    image.setAttribute('loading', 'lazy');
                    image.setAttribute('decoding', 'async');
                    bindUmlImageRecovery(image, umlSourceFromNode(image), src);

                    if (image.closest('figure.ddocs-uml')) {
                        return;
                    }

                    var figure = document.createElement('figure');
                    figure.className = 'ddocs-uml dtui-uml';
                    image.parentNode.insertBefore(figure, image);
                    figure.appendChild(image);
                });
            }

            function postProcessDdocsViewer(viewer, payload) {
                sanitizeRenderedHtml(viewer);
                enableDetailsBlocks(viewer);
                normalizeViewerUmlImages(viewer);
                recoverUmlBlocks(viewer, payload || {});

                viewer.querySelectorAll('a[href]').forEach(function (link) {
                    var href = link.getAttribute('href') || '';
                    var targetId = mappedValue(payload.links, 'href', href, 'target_id');

                    if (targetId) {
                        link.setAttribute('href', '#');
                        link.setAttribute('data-ddocs-document-id', targetId);
                        link.classList.add('ddocs-link-internal');
                        return;
                    }

                    if (isExternalUrl(href)) {
                        link.setAttribute('target', '_blank');
                        link.setAttribute('rel', 'noopener noreferrer');
                        return;
                    }

                    if (isRelativeDocumentLink(href)) {
                        link.setAttribute('href', '#');
                        link.setAttribute('data-ddocs-missing-link', href);
                        link.classList.add('ddocs-link-missing');
                    }
                });

                viewer.querySelectorAll('img[src]').forEach(function (image) {
                    var src = image.getAttribute('src') || '';
                    var dataUri = mappedValue(payload.images, 'src', src, 'data_uri');

                    if (/^data:image\//i.test(src) || src.indexOf('dtui-plantuml/') !== -1 || src.indexOf('plantuml') !== -1) {
                        image.classList.add('ddocs-image-local');
                        image.setAttribute('loading', 'lazy');
                        image.setAttribute('decoding', 'async');
                        bindUmlImageRecovery(image, umlSourceFromNode(image), src);
                        return;
                    }

                    if (dataUri) {
                        image.setAttribute('src', dataUri);
                        image.classList.add('ddocs-image-local');
                        image.setAttribute('loading', 'lazy');
                        image.setAttribute('decoding', 'async');
                        return;
                    }

                    if (isExternalUrl(src)) {
                        image.classList.add('ddocs-image-external');
                        image.setAttribute('loading', 'lazy');
                        image.setAttribute('decoding', 'async');
                        return;
                    }

                    var replacement = document.createElement('span');
                    replacement.className = 'ddocs-image-blocked';
                    replacement.textContent = image.getAttribute('alt') || @js($ui['blocked_image'] ?? 'Image blocked');
                    image.replaceWith(replacement);
                });

                normalizeViewerUmlImages(viewer);
                recoverUmlBlocks(viewer, payload || {});

                viewer.querySelectorAll('h1, h2, h3, h4, h5, h6').forEach(function (heading) {
                    if (!heading.id) {
                        heading.id = String(heading.textContent || '').trim().toLowerCase().replace(/[^\p{L}\p{N}]+/gu, '-').replace(/^-+|-+$/g, '');
                    }

                    if (heading.id && !heading.querySelector('.ddocs-heading-anchor')) {
                        heading.classList.add('ddocs-heading');
                        var anchor = document.createElement('a');
                        anchor.href = '#' + heading.id;
                        anchor.className = 'ddocs-heading-anchor';
                        anchor.setAttribute('aria-label', @js($ui['copy_heading_link'] ?? 'Copy heading link'));
                        anchor.textContent = '#';
                        heading.appendChild(anchor);
                    }
                });
            }

            function bootDdocsViewer(root) {
                if (!root) {
                    return;
                }

                queryAllWithRoot(root, '[data-ddocs-viewer]').forEach(function (viewer) {
                    var payload = readDdocsPayload(viewer);
                    var key = viewer.dataset.ddocsPayloadId || '';

                    if (!payload) {
                        return;
                    }

                    if (viewer.dataset.ddocsViewerBooted === key) {
                        queueDdocsViewerPostProcess(viewer, payload, [80]);
                        return;
                    }

                    clearDdocsViewerPostProcess(viewer);

                    if (viewer.ddocsViewer && typeof viewer.ddocsViewer.destroy === 'function') {
                        viewer.ddocsViewer.destroy();
                    }

                    viewer.innerHTML = '';
                    viewer.dataset.ddocsViewerBooted = key;

                    try {
                        var placeholderItems = [];
                        var markdown = preprocessMarkdownForViewer(payload.markdown || '', payload, placeholderItems);
                        viewer.ddocsUmlPlaceholderItems = placeholderItems;
                        if (window.toastui && window.toastui.Editor && typeof window.toastui.Editor.factory === 'function') {
                            viewer.ddocsViewer = window.toastui.Editor.factory({
                                el: viewer,
                                viewer: true,
                                initialValue: markdown,
                                plugins: ddocsViewerPlugins(),
                                usageStatistics: false
                            });
                        } else if (window.toastui && window.toastui.Editor) {
                            viewer.ddocsViewer = new window.toastui.Editor({
                                el: viewer,
                                viewer: true,
                                initialValue: markdown,
                                plugins: ddocsViewerPlugins(),
                                usageStatistics: false
                            });
                        } else {
                            viewer.innerHTML = '<pre><code>' + escapeHtml(markdown) + '</code></pre>';
                        }
                    } catch (e) {
                        console.warn('dDocs TOAST UI viewer failed, falling back to escaped markdown', e);
                        viewer.innerHTML = '<pre><code>' + escapeHtml(payload.markdown || '') + '</code></pre>';
                    }

                    queueDdocsViewerPostProcess(viewer, payload, [80, 300, 800]);
                });
            }

            function clearDdocsViewerPostProcess(viewer) {
                if (!viewer) {
                    return;
                }

                (viewer.ddocsPostProcessTimers || []).forEach(function (timer) {
                    window.clearTimeout(timer);
                });
                viewer.ddocsPostProcessTimers = [];

                if (viewer.ddocsPostProcessFrame) {
                    window.cancelAnimationFrame(viewer.ddocsPostProcessFrame);
                    viewer.ddocsPostProcessFrame = null;
                }
            }

            function queueDdocsViewerPostProcess(viewer, payload, delays) {
                var key = viewer && viewer.dataset ? (viewer.dataset.ddocsPayloadId || '') : '';

                clearDdocsViewerPostProcess(viewer);

                var run = function () {
                    if (!viewer || !viewer.isConnected || (viewer.dataset.ddocsPayloadId || '') !== key) {
                        return;
                    }

                    postProcessDdocsViewer(viewer, payload);
                    ensureCodeTools(viewer);
                };

                run();
                viewer.ddocsPostProcessFrame = window.requestAnimationFrame(run);
                viewer.ddocsPostProcessTimers = (delays || []).map(function (delay) {
                    return window.setTimeout(run, delay);
                });
            }

            function ensureCodeTools(root) {
                if (!root) {
                    return;
                }

                queryAllWithRoot(root, '.ddocs-markdown pre').forEach(function (pre) {
                    var code = pre.querySelector('code');

                    if (!code) {
                        return;
                    }

                    var language = codeLanguage(code, pre);
                    if (language) {
                        pre.dataset.language = language;
                        pre.classList.add('has-language');
                    } else {
                        delete pre.dataset.language;
                        pre.classList.remove('has-language');
                    }

                    pre.classList.add('ddocs-code-block', 'toastui-editor-ww-code-block-highlighting');

                    if (pre.querySelector('.ddocs-code-copy')) {
                        return;
                    }

                    var button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'ddocs-code-copy';
                    button.style.width = '1.45rem';
                    button.style.height = '1.45rem';
                    button.style.minWidth = '1.45rem';
                    button.style.minHeight = '1.45rem';
                    button.style.maxWidth = '1.45rem';
                    button.style.maxHeight = '1.45rem';
                    button.style.padding = '0';
                    button.style.lineHeight = '1';
                    button.title = copyCodeLabel;
                    button.setAttribute('aria-label', copyCodeLabel);
                    button.innerHTML = copyIcon();
                    button.addEventListener('click', function (event) {
                        event.preventDefault();
                        event.stopPropagation();

                        var value = code.innerText || code.textContent || '';
                        writeClipboard(value).then(function () {
                            button.classList.add('is-copied');
                            button.title = copiedCodeLabel;
                            button.setAttribute('aria-label', copiedCodeLabel);
                            window.setTimeout(function () {
                                button.classList.remove('is-copied');
                                button.title = copyCodeLabel;
                                button.setAttribute('aria-label', copyCodeLabel);
                            }, 1200);
                        });
                    });

                    pre.appendChild(button);
                });
            }

            function highlight(root) {
                if (!root) {
                    return;
                }

                if (root.nodeType === Node.TEXT_NODE) {
                    root = root.parentElement;
                }

                if (!root || typeof root.querySelectorAll !== 'function') {
                    root = document;
                }

                bootDdocsViewer(root);

                queryAllWithRoot(root, '.ddocs-markdown pre code').forEach(function (code) {
                    var pre = code.closest('pre');
                    var language = codeLanguage(code, pre);

                    if (language && code.dataset) {
                        code.dataset.language = language;
                    }

                    if (!window.Prism || code.dataset.ddocsHighlighted === '1') {
                        return;
                    }

                    window.Prism.highlightElement(code);
                    code.dataset.ddocsHighlighted = '1';
                });

                ensureCodeTools(root);
                bootDdocsEditor(root);
            }

            function queryAllWithRoot(root, selector) {
                var items = [];

                if (!root || typeof root.querySelectorAll !== 'function') {
                    return items;
                }

                if (root.matches && root.matches(selector)) {
                    items.push(root);
                }

                return items.concat(Array.prototype.slice.call(root.querySelectorAll(selector)));
            }

            var ddocsHighlightFrame = null;
            var ddocsHighlightRoot = null;

            function scheduleHighlight(root) {
                if (root && root.nodeType === Node.TEXT_NODE) {
                    root = root.parentElement;
                }

                if (!root || typeof root.querySelectorAll !== 'function') {
                    root = document;
                }

                root = root.closest && root.closest('[data-ddocs-workspace]')
                    ? root.closest('[data-ddocs-workspace]')
                    : document;

                ddocsHighlightRoot = root;

                if (ddocsHighlightFrame !== null) {
                    return;
                }

                ddocsHighlightFrame = window.requestAnimationFrame(function () {
                    var target = ddocsHighlightRoot || document;
                    ddocsHighlightFrame = null;
                    ddocsHighlightRoot = null;

                    if (target !== document && !target.isConnected) {
                        target = document;
                    }

                    highlight(target);
                });
            }

            function bootDdocsEditor(root) {
                if (!root || !window.dTuiEditor) {
                    return;
                }

                queryAllWithRoot(root, 'textarea[data-ddocs-editor]').forEach(function (textarea) {
                    if (textarea.dataset.ddocsEditorBooted === '1') {
                        return;
                    }

                    textarea.dataset.ddocsEditorBooted = '1';
                    var initialMarkdown = textarea.value || '';
                    var config = {
                        themeMode: document.documentElement.dataset.themeMode || document.body.dataset.themeMode || 'light',
                        plugins: {
                            codeSyntaxHighlight: {
                                options: {
                                    languages: ['html', 'markup', 'css', 'scss', 'javascript', 'typescript', 'php', 'blade', 'sql', 'json', 'markdown', 'bash', 'yaml'],
                                    aliases: {
                                        blade: ['laravel-blade', 'bladephp'],
                                        yaml: ['yml'],
                                        markdown: ['md'],
                                        markup: ['html', 'xml']
                                    }
                                }
                            }
                        },
                        queue: [{
                            selector: '#' + textarea.id,
                            name: textarea.name || textarea.id,
                            profile: 'full',
                            plugins: ['codeSyntaxHighlight', 'colorSyntax', 'tableMergedCell', 'image', 'evolinks', 'uml'],
                            options: {
                                editorMode: 'markdown',
                                height: '100%',
                                usageStatistics: false,
                                toolbarItems: [
                                    ['heading', 'bold', 'italic', 'strike'],
                                    ['hr', 'quote'],
                                    ['ul', 'ol', 'task', 'indent', 'outdent'],
                                    ['table', 'image', 'link'],
                                    ['code', 'codeblock']
                                ]
                            }
                        }]
                    };

                    if (typeof window.dTuiEditor.enqueue === 'function' && typeof window.dTuiEditor.flush === 'function') {
                        window.dTuiEditor.enqueue(config);
                        window.dTuiEditor.flush();
                    } else if (typeof window.dTuiEditor.boot === 'function') {
                        window.dTuiEditor.boot(config);
                    }

                    var restoreMarkdown = function () {
                        var editor = window.dTuiEditor && window.dTuiEditor.get ? window.dTuiEditor.get(textarea) : null;
                        if (!editor || typeof editor.setMarkdown !== 'function') {
                            return;
                        }

                        editor.setMarkdown(initialMarkdown, false);
                        textarea.value = initialMarkdown;
                    };

                    restoreMarkdown();
                    window.setTimeout(restoreMarkdown, 0);
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                scheduleHighlight(document);
            });

            document.addEventListener('livewire:navigated', function () {
                scheduleHighlight(document);
            });

            document.addEventListener('livewire:initialized', function () {
                if (window.Livewire && typeof window.Livewire.hook === 'function') {
                    try {
                        window.Livewire.hook('morph.updated', function () {
                            scheduleHighlight(document);
                        });
                    } catch (e) {}

                    try {
                        window.Livewire.hook('message.processed', function () {
                            scheduleHighlight(document);
                        });
                    } catch (e) {}
                }
            });
        }());
    </script>
</body>
</html>
