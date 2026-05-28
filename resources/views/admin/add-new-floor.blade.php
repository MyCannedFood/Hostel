<style>
    :root {
        --primary-dark: #1A3D0A;
        --primary-light: #B8D9A0;
        --accent-orange: #D9864A;
        --bg-main: #F6F6F1;
        --bg-map-area: #F4F4EF;
        --bg-map-placeholder: #EEEEE9;
        --border-color: #C3C9BA;
        --text-muted: #43493E;
        --white: #FFFFFF;
    }

    .floor-modal {
        position: fixed;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(0, 0, 0, 0.6);
        z-index: 99999;
    }

    .floor-modal.is-open {
        display: flex;
    }

    .floor-modal__panel {
        width: 100%;
        max-width: 1100px;
        background-color: var(--bg-main);
        border-radius: 8px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        max-height: 90vh;
    }

    .floor-modal__header {
        background-color: var(--primary-light);
        padding: 24px 32px;
        border-bottom: 1px solid var(--primary-dark);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .floor-modal__title {
        color: var(--primary-dark);
        font-family: 'Liberation Serif', serif;
        font-size: 32px;
        font-weight: 400;
    }

    .floor-modal__close {
        background: none;
        border: none;
        font-size: 24px;
        color: var(--text-muted);
        cursor: pointer;
        transition: color 0.2s;
    }

    .floor-modal__close:hover {
        color: var(--primary-dark);
    }

    .floor-modal__body {
        display: flex;
        flex: 1;
        overflow: hidden;
    }

    .floor-modal .map-section {
        flex: 6;
        background-color: var(--bg-map-area);
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        overflow-y: auto;
    }

    .floor-modal .map-toolbar {
        background-color: var(--bg-main);
        border-bottom: 1px solid var(--primary-dark);
        padding-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .floor-modal .btn-add-pin {
        background-color: var(--accent-orange);
        color: var(--white);
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-family: 'Liberation Serif', serif;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
    }

    .floor-modal .btn-add-pin:hover {
        background-color: #c4763e;
    }

    .floor-modal .toolbar-text {
        color: var(--text-muted);
        font-family: 'Liberation Serif', serif;
        font-size: 16px;
    }

    .floor-modal .map-canvas {
        background-color: var(--bg-map-placeholder);
        border-radius: 8px;
        /* dashed white border with thicker bottom */
        border: 2px dashed #ffffff;
        border-bottom: 6px dashed #ffffff;
        padding: 24px 24px 56px 24px; /* extra space at bottom */
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 640px; /* diperbesar ke bawah */
        overflow: hidden;
    }

    .floor-modal .map-canvas img {
        position: static;
        width: auto;
        max-width: 100%;
        max-height: calc(100% - 56px);
        object-fit: contain;
        object-position: center center; /* center image */
        border-radius: 8px;
        display: block;
    }

    .floor-modal .pin {
        position: absolute;
        width: 28px;
        height: 28px;
        background-color: var(--accent-orange);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        font-size: 14px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        border: 2px solid var(--white);
    }

    .floor-modal .pin-1 { top: 68%; left: 45%; }
    .floor-modal .pin-2 { top: 46%; left: 40%; }
    .floor-modal .pin-3 { top: 25%; left: 70%; }
    .floor-modal .pin-4 { top: 17%; left: 45%; }

    .floor-modal .config-section {
        flex: 4;
        background-color: var(--bg-main);
        border-left: 1px solid var(--border-color);
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        overflow-y: auto;
    }

    .floor-modal .config-title {
        color: var(--primary-dark);
        font-family: 'Liberation Serif', serif;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .floor-modal .config-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .floor-modal .config-card {
        background-color: var(--white);
        border: 1px solid var(--primary-dark);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .floor-modal .config-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .floor-modal .bed-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .floor-modal .bed-number {
        width: 28px;
        height: 28px;
        background-color: var(--accent-orange);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        font-size: 12px;
    }

    .floor-modal .bed-number.unassigned {
        background-color: var(--accent-orange);
        color: var(--white);
    }

    .floor-modal .bed-name {
        color: var(--primary-dark);
        font-size: 16px;
        font-weight: 700;
    }

    .floor-modal .bed-actions {
        display: flex;
        gap: 12px;
        color: var(--primary-dark);
    }

    .floor-modal .bed-actions button {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--primary-dark);
        font-size: 16px;
        transition: color 0.2s;
    }

    .floor-modal .bed-actions button:hover {
        color: var(--accent-orange);
    }

    .floor-modal .assign-area {
        background-color: var(--white);
        border: 1px solid var(--text-muted);
        border-radius: 8px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-top: 8px;
    }

    .floor-modal .assign-title {
        color: var(--primary-dark);
        font-family: 'Liberation Serif', serif;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .floor-modal .assign-input-group {
        display: flex;
        align-items: center;
        border: 1px solid var(--primary-dark);
        border-radius: 4px;
        padding: 8px 12px;
        justify-content: space-between;
    }

    .floor-modal .assign-input-group span {
        color: var(--primary-dark);
        font-size: 14px;
    }

    /* Dropdown styles for assign input */
    .floor-modal .assign-select {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        border: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        font-size: 14px;
        color: var(--primary-dark);
        padding: 0;
    }

    .floor-modal .assign-options {
        position: absolute;
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        margin-top: 8px;
        list-style: none;
        padding: 8px 0;
        width: 200px;
        max-height: 220px;
        overflow-y: auto;
        z-index: 100000;
    }

    .floor-modal .assign-option {
        padding: 8px 12px;
        cursor: pointer;
        color: var(--primary-dark);
    }

    .floor-modal .assign-option:hover,
    .floor-modal .assign-option[aria-selected="true"] {
        background: var(--bg-map-placeholder);
    }

    .floor-modal .btn-save-point {
        background-color: var(--accent-orange);
        color: var(--white);
        border: none;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 700;
        width: 100%;
        transition: 0.2s;
    }

    .floor-modal .btn-save-point:hover {
        background-color: #c4763e;
    }

    .floor-modal__footer {
        background-color: var(--primary-light);
        padding: 16px 32px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .floor-modal .btn-outline {
        background-color: var(--white);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
        padding: 12px 24px;
        border-radius: 4px;
        font-family: 'Liberation Serif', serif;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s;
    }

    .floor-modal .btn-outline:hover {
        background-color: #f0f0f0;
        color: var(--primary-dark);
    }

    .floor-modal .btn-solid {
        background-color: var(--accent-orange);
        color: var(--white);
        border: none;
        padding: 12px 32px;
        border-radius: 8px;
        font-family: 'Liberation Serif', serif;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: 0.2s;
    }

    .floor-modal .btn-solid:hover {
        background-color: #c4763e;
    }

    @media (max-width: 1024px) {
        .floor-modal__panel {
            max-width: 100%;
        }

        .floor-modal__body {
            flex-direction: column;
        }

        .floor-modal .config-section {
            border-left: none;
            border-top: 1px solid var(--border-color);
        }
    }
</style>

<div class="floor-modal is-open" id="floorModal" role="dialog" aria-modal="true" aria-labelledby="floorModalTitle" aria-hidden="false">
    <div class="floor-modal__panel">
        <header class="floor-modal__header">
            <h2 class="floor-modal__title" id="floorModalTitle">Bed Layout & Mapping Configuration</h2>
            <button type="button" class="floor-modal__close" data-floor-modal-close aria-label="Close modal">&times;</button>
        </header>

        <div class="floor-modal__body">
            <div class="map-section">
                <div class="map-toolbar">
                    <button class="btn-add-pin" type="button">
                        <img src="{{ asset('images/pin.svg') }}" alt="Add Pin Icon">
                        <i class="fa-solid fa-location-dot"></i> + Add Bed Pin
                    </button>
                    <span class="toolbar-text">Click button, then click on the map to place a pin.</span>
                </div>

                <div class="map-canvas">
                    <img src="{{ asset('images/Floor1.png') }}" alt="Floor Plan Placeholder">

                    <div class="pin pin-1">1</div>
                    <div class="pin pin-2">2</div>
                    <div class="pin pin-3">3</div>
                    <div class="pin pin-4">4</div>
                </div>
            </div>

            <div class="config-section">
                <h3 class="config-title">POINT CONFIGURATION</h3>

                <div class="config-list">
                    <div class="config-card">
                        <div class="config-card-header">
                            <div class="bed-info">
                                <div class="bed-number">1</div>
                                <div class="bed-name">SH-1T [1 - Top Bed]</div>
                            </div>
                            <div class="bed-actions">
                                <button type="button"><i class="fa-regular fa-square-check"></i></button>
                                <button type="button"><i class="fa-solid fa-pen"></i></button>
                                <button type="button"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </div>
                        <div class="assign-area">
                            <span class="assign-title">Assign Point to 1 - Top Bed</span>
                            <div class="assign-input-group" style="position:relative;">
                                <button type="button" class="assign-select" aria-haspopup="listbox" aria-expanded="false">
                                    <span class="assign-selected">Point 1</span>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true" style="color: var(--primary-dark);"></i>
                                </button>
                                <ul class="assign-options" role="listbox" hidden>
                                    <li class="assign-option" role="option" data-value="1">Point 1</li>
                                    <li class="assign-option" role="option" data-value="2">Point 2</li>
                                    <li class="assign-option" role="option" data-value="3">Point 3</li>
                                </ul>
                            </div>
                            <button class="btn-save-point" type="button">Save Point</button>
                        </div>
                    </div>

                    <div class="config-card">
                        <div class="config-card-header">
                            <div class="bed-info">
                                <div class="bed-number">1</div>
                                <div class="bed-name">SH-1B [1 - Bottom Bed]</div>
                            </div>
                            <div class="bed-actions">
                                <button type="button"><i class="fa-regular fa-square-check"></i></button>
                                <button type="button"><i class="fa-solid fa-pen"></i></button>
                                <button type="button"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </div>
                        <div class="assign-area">
                            <span class="assign-title">Assign Point to 1 - Bottom Bed</span>
                            <div class="assign-input-group" style="position:relative;">
                                <button type="button" class="assign-select" aria-haspopup="listbox" aria-expanded="false">
                                    <span class="assign-selected">Point 1</span>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true" style="color: var(--primary-dark);"></i>
                                </button>
                                <ul class="assign-options" role="listbox" hidden>
                                    <li class="assign-option" role="option" data-value="1">Point 1</li>
                                    <li class="assign-option" role="option" data-value="2">Point 2</li>
                                    <li class="assign-option" role="option" data-value="3">Point 3</li>
                                </ul>
                            </div>
                            <button class="btn-save-point" type="button">Save Point</button>
                        </div>
                    </div>

                    <div class="config-card">
                        <div class="config-card-header">
                            <div class="bed-info">
                                <div class="bed-number unassigned">?</div>
                                <div class="bed-name">SH-2T [2 - Top Bed]</div>
                            </div>
                            <div class="bed-actions">
                                <button type="button"><i class="fa-regular fa-square-check"></i></button>
                                <button type="button"><i class="fa-solid fa-pen"></i></button>
                                <button type="button"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="config-card">
                        <div class="config-card-header">
                            <div class="bed-info">
                                <div class="bed-number unassigned">?</div>
                                <div class="bed-name">SH-2B [2 - Bottom Bed]</div>
                            </div>
                            <div class="bed-actions">
                                <button type="button"><i class="fa-regular fa-square-check"></i></button>
                                <button type="button"><i class="fa-solid fa-pen"></i></button>
                                <button type="button"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="floor-modal__footer">
            <button class="btn-outline" type="button" data-floor-modal-close>Clear All Points</button>
            <button class="btn-solid" type="button">Save Floor Plan</button>
        </footer>
    </div>
</div>

            <script>
            document.addEventListener('click', function(e){
                // toggle dropdown
                const select = e.target.closest('.assign-select');
                if(select){
                    const wrapper = select.closest('.assign-input-group');
                    const list = wrapper.querySelector('.assign-options');
                    const expanded = select.getAttribute('aria-expanded') === 'true';
                    select.setAttribute('aria-expanded', String(!expanded));
                    if(expanded){
                        list.hidden = true;
                    } else {
                        list.hidden = false;
                    }
                    return;
                }

                // option clicked
                const option = e.target.closest('.assign-option');
                if(option){
                    const list = option.closest('.assign-options');
                    const wrapper = list.closest('.assign-input-group');
                    const selectBtn = wrapper.querySelector('.assign-select');
                    const display = wrapper.querySelector('.assign-selected');
                    display.textContent = option.textContent.trim();
                    // mark selected
                    Array.from(list.querySelectorAll('.assign-option')).forEach(o=>o.removeAttribute('aria-selected'));
                    option.setAttribute('aria-selected','true');
                    list.hidden = true;
                    selectBtn.setAttribute('aria-expanded','false');
                    return;
                }

                // click outside - close any open lists
                document.querySelectorAll('.assign-options').forEach(list=>{
                    if(!list.hidden){
                        list.hidden = true;
                        const wrapper = list.closest('.assign-input-group');
                        const btn = wrapper.querySelector('.assign-select');
                        if(btn) btn.setAttribute('aria-expanded','false');
                    }
                });
            });
            </script>
