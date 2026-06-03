(function () {
    'use strict';

    const CONFIG = window.HI_CONFIG || {};

    /* ── Character counter ── */
    document.querySelectorAll('.hi-textarea[data-counter]').forEach(function (el) {
        var counterId = el.getAttribute('data-counter');
        var counterEl = document.getElementById(counterId);
        if (!counterEl) return;

        function update() {
            counterEl.textContent = el.value.length;
        }
        el.addEventListener('input', update);
        update();
    });

    /* ── Tags input (languages) ── */
    var tagsWrapper = document.getElementById('lang-tags-wrapper');
    var tagsInput   = document.getElementById('lang-input');
    if (tagsWrapper && tagsInput) {
        tagsInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                var val = tagsInput.value.trim();
                if (!val) return;

                var tag = document.createElement('span');
                tag.className = 'hi-tag';
                tag.innerHTML = val + ' <button type="button" title="Remove">&times;</button>';
                tag.querySelector('button').addEventListener('click', function () {
                    tag.remove();
                });
                tagsWrapper.insertBefore(tag, tagsInput);
                tagsInput.value = '';
            }
        });
    }

    /* ── Save button ── */
    var saveBtn = document.getElementById('hi-save-btn');
    if (saveBtn && CONFIG.updateUrl) {
        saveBtn.addEventListener('click', function () {
            var formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            /* Collect all inputs, selects, textareas */
            document.querySelectorAll('.hi-input, .hi-textarea, .hi-select').forEach(function (el) {
                formData.append(el.name, el.value);
            });

            /* Collect logo / favicon files */
            var mainLogo = document.getElementById('main_logo');
            if (mainLogo && mainLogo.files[0]) formData.append('main_logo', mainLogo.files[0]);

            var favicon = document.getElementById('favicon');
            if (favicon && favicon.files[0]) formData.append('favicon', favicon.files[0]);

            /* Collect languages from tags */
            var langs = [];
            tagsWrapper.querySelectorAll('.hi-tag').forEach(function (tag) {
                langs.push(tag.textContent.replace('×', '').trim());
            });
            formData.append('languages', JSON.stringify(langs));

            /* Disable button to prevent double-click */
            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving…';

            fetch(CONFIG.updateUrl, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' },
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    showFlash('success', data.message || 'Hostel information saved.');
                } else {
                    showFlash('error', data.message || 'Failed to save.');
                }
            })
            .catch(function () {
                showFlash('error', 'Network error. Please try again.');
            })
            .finally(function () {
                saveBtn.disabled = false;
                saveBtn.textContent = 'Save Changes';
            });
        });
    }

    function showFlash(type, msg) {
        var existing = document.querySelector('.hi-flash');
        if (existing) existing.remove();

        var div = document.createElement('div');
        div.className = 'hi-flash';
        div.style.cssText = 'padding:12px 16px; border-radius:10px; font-size:13px; font-weight:600; margin-bottom:16px;';

        if (type === 'success') {
            div.style.background = '#e6f4e6';
            div.style.border     = '1px solid #a3d4a3';
            div.style.color      = '#2e7d32';
            div.textContent = '\u2713 ' + msg;
        } else {
            div.style.background = '#fdecea';
            div.style.border     = '1px solid #f5a5a5';
            div.style.color      = '#c62828';
            div.textContent = '\u2717 ' + msg;
        }

        var header = document.querySelector('.hi-header');
        if (header) header.parentNode.insertBefore(div, header.nextSibling);

        setTimeout(function () { div.remove(); }, 5000);
    }
})();
