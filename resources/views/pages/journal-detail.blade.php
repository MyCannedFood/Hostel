<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $article->title }} - AlaSare Journal</title>
    @vite(['resources/css/app.css', 'resources/css/journal.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; background: var(--color-bg-light); color: #111;">

@include('components.navbar')

<article>
    <div class="journal-detail-hero">
        @if($article->thumbnail)
            <img src="{{ asset($article->thumbnail) }}" alt="{{ $article->title }}">
        @else
            <img src="{{ asset('images/journal/The harmony islamic.png') }}" alt="{{ $article->title }}">
        @endif
    </div>

    <div class="journal-detail-content">
        <div class="journal-meta">
            <span data-en="BY " data-id="OLEH ">BY </span>{{ strtoupper($article->author ?? ($article->admin?->name ?? 'ADMIN')) }}
            • {{ strtoupper($article->publish_at ? $article->publish_at->format('d M Y') : $article->created_at->format('d M Y')) }}
            @if($article->source)
                • <span data-en="SOURCE:" data-id="SUMBER:">SOURCE:</span> {{ $article->source }}
            @endif
        </div>
        <h1 data-en="{{ $article->title_en ?? $article->title }}" data-id="{{ $article->title_id ?? $article->title }}">{{ $article->title }}</h1>
        
        <div class="journal-body" data-en-html="{{ $article->content_en ?? $article->content }}" data-id-html="{{ $article->content }}">
            {!! $article->content !!}
        </div>
    </div>
</article>

@include('components.footer')

<x-whatsapp_floating />

<script>
(function () {
    var el = document.querySelector('.journal-body');
    if (!el || !el.dataset.enHtml) return;

    // Helper: extract image HTML blocks from content string
    function extractImages(html) {
        var tmp = document.createElement('div');
        tmp.innerHTML = html;
        var imgElements = [];
        var handled = [];
        // First: collect <p> elements that contain images
        tmp.querySelectorAll('p').forEach(function(node) {
            if (node.querySelector('img')) {
                imgElements.push(node.outerHTML);
                node.querySelectorAll('img').forEach(function(img) {
                    handled.push(img);
                });
            }
        });
        // Then: collect standalone <img> not inside a <p>
        tmp.querySelectorAll('img').forEach(function(img) {
            if (handled.indexOf(img) === -1) {
                imgElements.push(img.outerHTML);
            }
        });
        return imgElements;
    }

    function applyBody(lang) {
        var key = lang === 'en' ? 'enHtml' : 'idHtml';
        var otherKey = lang === 'en' ? 'idHtml' : 'enHtml';
        var html = el.dataset[key];
        if (!html) return;

        // Check if the target content has images
        var hasImages = /<img\s/i.test(html);

        if (!hasImages) {
            // Get images from the other language content
            var otherHtml = el.dataset[otherKey];
            if (otherHtml && /<img\s/i.test(otherHtml)) {
                var imageBlocks = extractImages(otherHtml);
                if (imageBlocks.length > 0) {
                    html = html + imageBlocks.join('');
                }
            }
        }

        el.innerHTML = html;
    }

    function isImgOnlyParagraph(p) {
        var imgs = p.querySelectorAll('img');
        if (imgs.length === 0) return false;
        var text = p.textContent.replace(/[\u200B\uFEFF\u00A0]/g, '').trim();
        return text === '';
    }

    function updateImageLayout() {
        var paragraphs = Array.from(el.querySelectorAll('p'));

        paragraphs.forEach(function (p) {
            p.removeAttribute('data-img-count');
            p.removeAttribute('data-img-group');
            p.removeAttribute('data-img-inline');
        });

        var i = 0, groupId = 0;
        while (i < paragraphs.length) {
            var p = paragraphs[i];
            if (!isImgOnlyParagraph(p)) { i++; continue; }

            var imgsInP = p.querySelectorAll('img').length;

            if (imgsInP > 1) {
                // Multiple images in ONE paragraph → flex
                var cols = Math.min(imgsInP, 3);
                p.setAttribute('data-img-inline', cols);
                p.setAttribute('data-img-group', groupId++);
                i++;
            } else {
                // Consecutive single-image paragraphs → inline-block grid
                var start = i;
                while (
                    i + 1 < paragraphs.length &&
                    isImgOnlyParagraph(paragraphs[i + 1]) &&
                    paragraphs[i + 1].querySelectorAll('img').length === 1
                ) { i++; }
                var count = Math.min(i - start + 1, 3);
                for (var j = start; j <= i; j++) {
                    paragraphs[j].setAttribute('data-img-count', count);
                    paragraphs[j].setAttribute('data-img-group', groupId);
                }
                groupId++;
                i++;
            }
        }
    }

    document.addEventListener('alas:langchange', function (e) {
        applyBody(e.detail.lang);
        updateImageLayout();
    });

    var lang = (window.AlasLang ? window.AlasLang.current() : null)
               || localStorage.getItem('alas_lang')
               || 'en';
    applyBody(lang);
    updateImageLayout();
})();
</script>
</body>
</html>
