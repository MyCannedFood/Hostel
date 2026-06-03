(function () {
    'use strict';

    var CONFIG = window.OP_CONFIG || {};

    /* ── Tax toggle: hide/show tax fields ── */
    var taxToggle = document.getElementById('tax_toggle');
    var taxRow = document.getElementById('tax-fields-row');
    if (taxToggle && taxRow) {
        function syncTaxFields() {
            taxRow.style.display = taxToggle.checked ? 'grid' : 'none';
        }
        taxToggle.addEventListener('change', syncTaxFields);
        syncTaxFields();
    }

    /* ── Save button ── */
    var saveBtn = document.getElementById('op-save-btn');
    if (saveBtn && CONFIG.updateUrl) {
        saveBtn.addEventListener('click', function () {
            var formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            /* Selects */
            document.querySelectorAll('.op-select').forEach(function (el) {
                formData.append(el.name, el.value);
            });

            /* Textareas */
            document.querySelectorAll('.op-textarea').forEach(function (el) {
                formData.append(el.name, el.value);
            });

            /* Number inputs inside .op-input-suffix */
            document.querySelectorAll('.op-input-suffix input').forEach(function (el) {
                formData.append(el.name, el.value);
            });

            /* Tax toggle */
            formData.append('tax_included', taxToggle && taxToggle.checked ? '1' : '0');

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
                    showFlash('success', data.message || 'Operational policies saved.');
                } else {
                    showFlash('error', data.message || 'Failed to save.');
                }
            })
            .catch(function () {
                showFlash('error', 'Network error. Please try again.');
            })
            .finally(function () {
                saveBtn.disabled = false;
                saveBtn.textContent = 'Save Policies';
            });
        });
    }

    function showFlash(type, msg) {
        var existing = document.querySelector('.op-flash');
        if (existing) existing.remove();

        var div = document.createElement('div');
        div.className = 'op-flash';
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

        var header = document.querySelector('.op-header');
        if (header) header.parentNode.insertBefore(div, header.nextSibling);

        setTimeout(function () { div.remove(); }, 5000);
    }
})();
