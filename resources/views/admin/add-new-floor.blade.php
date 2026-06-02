<style>
    /* ... (CSS TETAP SAMA SEPERTI SEBELUMNYA) ... */
    :root {
        --primary-dark: #1A3D0A;
        --primary-light: #B8D9A0;
        --accent-orange: #D9864A;
        --bg-main: #F6F6F1;
        --bg-map-area: #F4F4EF;
        --bg-map-placeholder: #EEEEE9;
        --border-color: #C3C9BA;
        --text-muted: #43493E;
        --danger-red: #dc3545;
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
        max-width: 1200px;
        background-color: var(--bg-main);
        border-radius: 8px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        max-height: 95vh;
    }

    .floor-modal__header {
        background-color: var(--primary-light);
        padding: 20px 32px;
        border-bottom: 1px solid var(--primary-dark);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .floor-modal__title {
        color: var(--primary-dark);
        font-family: 'Liberation Serif', serif;
        font-size: 28px;
        font-weight: 700;
    }

    .floor-modal__close {
        background: none;
        border: none;
        font-size: 28px;
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
        gap: 16px;
        overflow-y: auto;
    }

    .floor-modal .map-toolbar {
        background-color: var(--bg-main);
        border-bottom: 1px solid var(--primary-dark);
        padding-bottom: 16px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .floor-modal .btn-action {
        background-color: var(--accent-orange);
        color: var(--white);
        border: none;
        padding: 10px 16px;
        border-radius: 6px;
        font-family: inherit;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }

    .floor-modal .btn-action.outline {
        background-color: var(--white);
        color: var(--primary-dark);
        border: 1px solid var(--primary-dark);
    }

    .floor-modal .btn-action.danger {
        background-color: var(--white);
        color: var(--danger-red);
        border: 1px solid var(--danger-red);
    }

    .floor-modal .btn-action.danger:hover {
        background-color: var(--danger-red);
        color: var(--white);
    }

    .floor-modal .btn-action.active {
        background-color: var(--primary-dark);
        color: var(--white);
    }

    .floor-modal .btn-action:hover:not(.danger) {
        opacity: 0.9;
    }

    .floor-modal .btn-action:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .floor-modal .toolbar-text {
        color: var(--text-muted);
        font-size: 14px;
        margin-left: auto;
    }

    /* KANVAS MAP - Tambahan Cursor Pointer agar user tahu ini bisa diklik */
    .floor-modal .map-canvas-container {
        background-color: var(--bg-map-placeholder);
        border: 2px dashed #ffffff;
        border-bottom: 6px dashed #ffffff;
        border-radius: 8px;
        padding: 20px;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 500px;
        overflow: auto;
        cursor: pointer; /* Indikator bisa diklik */
    }

    /* Jika gambar sudah ada, cursor kembali default kecuali saat add pin */
    .floor-modal .map-canvas-container.has-image {
        cursor: default;
    }

    .floor-modal .map-wrapper {
        position: relative;
        display: inline-block;
        max-width: 100%;
    }

    .floor-modal .map-wrapper img {
        display: block;
        max-width: 100%;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .floor-modal .pin {
        position: absolute;
        width: 30px;
        height: 30px;
        background-color: var(--accent-orange);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        font-size: 14px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        cursor: grab;
        border: 2px solid var(--white);
        transform: translate(-50%, -50%);
        user-select: none;
        z-index: 10;
        transition: transform 0.1s;
    }
    .floor-modal .pin:active {
        cursor: grabbing;
        transform: translate(-50%, -50%) scale(1.1);
    }

    .floor-modal .config-section {
        flex: 4;
        background-color: var(--bg-main);
        border-left: 1px solid var(--border-color);
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        overflow-y: auto;
    }

    .floor-modal .config-title {
        color: var(--primary-dark);
        font-family: 'Liberation Serif', serif;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .floor-modal .config-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .floor-modal .config-card {
        background-color: var(--white);
        border: 1px solid var(--primary-dark);
        border-radius: 8px;
        padding: 16px;
        display: flex;
        flex-direction: column;
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
        width: 30px;
        height: 30px;
        background-color: var(--accent-orange);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        font-size: 14px;
        transition: 0.3s;
    }

    .floor-modal .bed-number.unassigned {
        background-color: var(--accent-orange);
        color: var(--white);
    }

    .floor-modal .bed-name {
        color: var(--primary-dark);
        font-size: 15px;
        font-weight: 700;
    }

    .floor-modal .bed-actions {
        display: flex;
        gap: 12px;
    }

    .floor-modal .bed-actions button {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 16px;
        transition: color 0.2s;
    }

    .floor-modal .bed-actions button:hover {
        color: var(--accent-orange);
    }

    .floor-modal .assign-area {
        background-color: var(--bg-main);
        border: 1px dashed var(--primary-dark);
        border-radius: 6px;
        padding: 12px;
        margin-top: 16px;
        display: none;
        flex-direction: column;
        gap: 12px;
    }

    .floor-modal .assign-area.is-visible {
        display: flex;
    }

    .floor-modal .assign-select {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        font-family: inherit;
        color: var(--primary-dark);
        outline: none;
        cursor: pointer;
    }

    .floor-modal__footer {
        background-color: var(--primary-light);
        padding: 16px 32px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .floor-modal__footer .footer-right {
        display: flex;
        gap: 12px;
    }
    .floor-modal .bed-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

.floor-modal .bed-actions .icon-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
}

.floor-modal .bed-actions .icon-btn:hover {
    transform: scale(1.1); /* Efek sedikit membesar saat di-hover */
}

/* Mengatur dimensi gambar ikon di dalam konfigurasi bed */
.floor-modal .bed-actions .icon-btn img {
    width: 20px;
    height: 20px;
    display: block;
    object-fit: contain;
}
</style>

<div class="floor-modal is-open" id="floorModal" data-room-id="{{ $selectedRoom->id ?? '' }}">
    <div class="floor-modal__panel">
        <header class="floor-modal__header">
            <h2 class="floor-modal__title">Map Config: {{ $selectedRoom->name ?? 'Room' }}</h2>
            <button type="button" class="floor-modal__close" id="btnCloseTop">&times;</button>
        </header>

        <div class="floor-modal__body">
            
            <div class="map-section">
                <div class="map-toolbar">
                    <input type="file" id="uploadMapInput" accept="image/*" hidden>
                    
                    <button class="btn-action outline" type="button" id="btnUploadImage">
                        <i class="fa-solid fa-upload"></i> Upload Map Image
                    </button>

                    <button class="btn-action" type="button" id="btnAddPin" disabled>
                        <i class="fa-solid fa-location-dot"></i> + Add Bed Pin
                    </button>

                    <span class="toolbar-text" id="mapHelperText">Click the dashed area to upload map...</span>
                </div>

                <div class="map-canvas-container" id="mapContainer">
                    <div class="map-wrapper" id="mapWrapper">
                        @if(isset($selectedRoom) && $selectedRoom->layout_photo)
                            <img src="{{ asset('storage/' . $selectedRoom->layout_photo) }}" id="mapImage" alt="Floor Plan">
                        @else
                            <img src="" id="mapImage" alt="Floor Plan" style="display: none;">
                        @endif

                        @if(isset($selectedRoom) && $selectedRoom->bedPins->count() > 0)
                            @foreach($selectedRoom->bedPins as $pin)
                                <div
                                    class="pin"
                                    data-id="{{ $pin->bed_id ?? $loop->iteration }}"
                                    data-label="{{ $pin->point_label }}"
                                    style="left: {{ $pin->position_left }}; top: {{ $pin->position_top }};"
                                >
                                    {{ $pin->point_label }}
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="config-section">
                <h3 class="config-title">POINT CONFIGURATION</h3>
                
                <div class="config-list" id="bedList">
                    @if(isset($selectedRoom) && $selectedRoom->beds->count() > 0)
                        @foreach($selectedRoom->beds as $bed)
                            <div class="config-card" data-bed-id="{{ $bed->id }}">
                                <div class="config-card-header">
                                    <div class="bed-info">
                                        @if($bed->bedPin)
                                            <div class="bed-number">{{ $bed->bedPin->point_label }}</div>
                                        @else
                                            <div class="bed-number unassigned">?</div>
                                        @endif
                                        <div class="bed-name">{{ $bed->name }} [{{ $bed->position }}]</div>
                                    </div>
                                    <div class="bed-actions">
                                        <button type="button" class="icon-btn add-attr" aria-label="Add/Edit Pin" title="Add/Edit Pin">
                                            <img src="{{ asset('images/Plus square.svg') }}" alt="Add attribute">
                                        </button>
                                        <button type="button" class="icon-btn remove-attr" aria-label="Delete Pin" title="Delete Pin">
                                            <img src="{{ asset('images/delete.svg') }}" alt="Delete attribute">
                                        </button>
                                    </div>
                                </div>
                                <div class="assign-area">
                                    <label style="font-size: 13px; font-weight:bold; color:var(--primary-dark)">Select Pin Point:</label>
                                    <select class="assign-select pin-dropdown">
                                        <option value="">-- Choose a Pin --</option>
                                    </select>
                                    <button type="button" class="btn-action btn-save-assignment" style="width:100%; justify-content:center;">Confirm Point</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p style="color: var(--text-muted); font-size: 14px;">Belum ada bed di ruangan ini. Tambahkan bed terlebih dahulu sebelum mengatur denah.</p>
                    @endif
                </div>
            </div>
        </div>

        <footer class="floor-modal__footer">
            <div class="footer-left">
                <button class="btn-action danger" type="button" id="btnDeleteLayout"><i class="fa-solid fa-trash"></i> Reset Layout</button>
            </div>
            <div class="footer-right">
                <button class="btn-action outline" type="button" id="btnCancel"><i class="fa-solid fa-xmark"></i> Cancel</button>
                <button class="btn-action outline" type="button" id="btnToggleEdit"><i class="fa-solid fa-lock-open"></i> Lock/Edit</button>
                <button class="btn-action" type="button" id="btnSaveConfig" style="font-size: 16px; padding: 10px 24px;"><i class="fa-solid fa-floppy-disk"></i> Save Floor Plan</button>
            </div>
        </footer>
    </div>
</div>

<script>
(function() {
    // === 1. DEKLARASI ELEMEN UTAMA ===
    const modal = document.getElementById('floorModal');
    const roomId = "{{ $selectedRoom->id ?? '' }}"; 
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    const uploadInput = document.getElementById('uploadMapInput');
    const btnUpload = document.getElementById('btnUploadImage');
    const mapImage = document.getElementById('mapImage');
    const mapContainer = document.getElementById('mapContainer'); 
    const mapWrapper = document.getElementById('mapWrapper');
    const btnAddPin = document.getElementById('btnAddPin');
    const helperText = document.getElementById('mapHelperText');
    const bedList = document.getElementById('bedList');
    
    const btnCloseTop = document.getElementById('btnCloseTop');
    const btnCancel = document.getElementById('btnCancel');
    const btnDeleteLayout = document.getElementById('btnDeleteLayout');
    const btnToggleEdit = document.getElementById('btnToggleEdit');
    const btnSaveConfig = document.getElementById('btnSaveConfig');

    let isAddingPin = false;
    let isEditMode = true; 
    let pinCounter = Array.from(document.querySelectorAll('.pin')).reduce((max, pin) => {
        const labelValue = parseInt(pin.dataset.label || pin.textContent || '0', 10);
        return Number.isNaN(labelValue) ? max : Math.max(max, labelValue);
    }, 0);
    let draggedPin = null;

    // Aktifkan tombol jika gambar dari database sudah ada
    if (mapImage.getAttribute('src') && mapImage.getAttribute('src') !== '') {
        mapContainer.classList.add('has-image');
        btnAddPin.disabled = false;
        helperText.textContent = "Image loaded. Click '+ Add Bed Pin' to start pinning.";
    }

    // === 2. FUNGSI UPLOAD GAMBAR KE DATABASE (AJAX) ===
    mapContainer.addEventListener('click', function(e) {
        if (e.target === mapContainer || e.target === mapWrapper) {
            if (!mapImage.src || mapImage.style.display === 'none' || mapImage.getAttribute('src') === '') {
                uploadInput.click();
            }
        }
    });

    btnUpload.addEventListener('click', () => uploadInput.click());

    uploadInput.addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if(!file) return;

        // 1. TAMPILKAN PREVIEW LOKAL SECARA INSTAN
        const localUrl = URL.createObjectURL(file);
        mapImage.src = localUrl;
        mapImage.style.display = 'block';
        mapContainer.classList.add('has-image');
        
        if(!roomId) {
            alert("Error: ID Kamar tidak ditemukan!");
            return;
        }

        // 2. PROSES UPLOAD KE SERVER DI BALIK LAYAR
        const fd = new FormData();
        fd.append('layout_photo', file);

        helperText.textContent = "Uploading map image to server... please wait.";
        btnUpload.disabled = true;

        try {
            const res = await fetch(`/admin/rooms/${roomId}/upload-layout`, {
                method: 'POST',
                body: fd,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const json = await res.json();
            
            if(json.success) {
                // Timpa preview lokal dengan URL asli dari server (agar permanen)
                mapImage.src = json.layout_url; 
                
                btnAddPin.disabled = false;
                helperText.textContent = "Upload Success! Click '+ Add Bed Pin' to place points.";
                
                isEditMode = true;
                btnToggleEdit.innerHTML = '<i class="fa-solid fa-lock-open"></i> Lock Map';
                btnToggleEdit.classList.add('active');
            } else {
                alert(json.message || "Failed to upload map.");
                helperText.textContent = "Upload failed.";
                // Kembalikan ke awal jika server menolak
                mapImage.src = '';
                mapImage.style.display = 'none';
                mapContainer.classList.remove('has-image');
            }
        } catch(err) {
            console.error("Upload error:", err);
            alert("Error connecting to server.");
            helperText.textContent = "Upload failed.";
        } finally {
            btnUpload.disabled = false;
        }
    });

    // === 3. LOGIKA KANVAS (TAMBAH & GESER PIN) ===
    btnAddPin.addEventListener('click', function() {
        if(!isEditMode) return;
        isAddingPin = !isAddingPin;
        if(isAddingPin) {
            btnAddPin.classList.add('active');
            mapWrapper.style.cursor = 'crosshair';
            helperText.textContent = "Click anywhere on the map to place a pin.";
        } else {
            btnAddPin.classList.remove('active');
            mapWrapper.style.cursor = 'default';
            helperText.textContent = "Map editing active. You can drag pins.";
        }
    });

    mapWrapper.addEventListener('mousedown', function(e) {
        if(isAddingPin && !e.target.classList.contains('pin')) {
            const rect = mapWrapper.getBoundingClientRect();
            let x = ((e.clientX - rect.left) / rect.width) * 100;
            let y = ((e.clientY - rect.top) / rect.height) * 100;

            pinCounter++;
            createPinElement(pinCounter, x, y);
            updateAllDropdowns();

            isAddingPin = false;
            btnAddPin.classList.remove('active');
            mapWrapper.style.cursor = 'default';
            helperText.textContent = `Point ${pinCounter} added! Drag to adjust.`;
        }
    });

    function createPinElement(id, x, y) {
        const pin = document.createElement('div');
        pin.className = 'pin';
        pin.textContent = id;
        pin.dataset.id = id;
        pin.dataset.label = String(id);
        pin.style.left = x + '%';
        pin.style.top = y + '%';
        mapWrapper.appendChild(pin);
    }

    mapWrapper.addEventListener('mousedown', function(e) {
        if(isEditMode && e.target.classList.contains('pin') && !isAddingPin) {
            draggedPin = e.target;
        }
    });

    document.addEventListener('mousemove', function(e) {
        if(draggedPin && isEditMode) {
            const rect = mapWrapper.getBoundingClientRect();
            let x = ((e.clientX - rect.left) / rect.width) * 100;
            let y = ((e.clientY - rect.top) / rect.height) * 100;
            
            x = Math.max(0, Math.min(100, x));
            y = Math.max(0, Math.min(100, y));

            draggedPin.style.left = x + '%';
            draggedPin.style.top = y + '%';
        }
    });

    document.addEventListener('mouseup', function() {
        if(draggedPin) draggedPin = null;
    });

    function updateAllDropdowns() {
        document.querySelectorAll('.pin-dropdown').forEach(select => {
            const currentVal = select.value;
            select.innerHTML = '<option value="">-- Choose a Pin --</option>';
            for(let i = 1; i <= pinCounter; i++) {
                select.innerHTML += `<option value="${i}">Point ${i}</option>`;
            }
            select.value = currentVal; 
        });
    }

    // === 4. ASSIGN BED KE PIN ===
    bedList.addEventListener('click', function(e) {
        const card = e.target.closest('.config-card');
        if(!card) return;

        const assignArea = card.querySelector('.assign-area');
        const badge = card.querySelector('.bed-number');
        const select = card.querySelector('.pin-dropdown');

        // JIKA TOMBOL TAMBAH/EDIT DIKLIK (.add-attr)
        if(e.target.closest('.add-attr')) {
            document.querySelectorAll('.assign-area').forEach(area => {
                if(area !== assignArea) area.classList.remove('is-visible');
            });
            updateAllDropdowns(); // Segarkan isi dropdown pin
            assignArea.classList.toggle('is-visible');
        }

        // JIKA TOMBOL CONFIRM POINT DIKLIK
        if(e.target.closest('.btn-save-assignment')) {
            const selectedPin = select.value;
            if(selectedPin) {
                badge.textContent = selectedPin;
                badge.classList.remove('unassigned');
                assignArea.classList.remove('is-visible');
            } else {
                alert('Please select a point from the dropdown!');
            }
        }

        // JIKA TOMBOL HAPUS DIKLIK (.remove-attr)
        if(e.target.closest('.remove-attr')) {
            badge.textContent = '?';
            badge.classList.add('unassigned');
            select.value = "";
            assignArea.classList.remove('is-visible');
        }
    });

    // === 5. FUNGSI FOOTER: SIMPAN & TUTUP ===
    const closeModal = () => {
        if (window.closeInjectedModal) {
            window.closeInjectedModal();
        } else {
            modal.classList.remove('is-open'); 
        }
    };

    btnCancel.addEventListener('click', closeModal);
    btnCloseTop.addEventListener('click', closeModal);

    btnToggleEdit.addEventListener('click', function() {
        if(!mapImage.src || mapImage.style.display === 'none') {
            alert('Please upload a map image first!');
            return;
        }
        
        isEditMode = !isEditMode;
        if(isEditMode) {
            btnToggleEdit.innerHTML = '<i class="fa-solid fa-lock-open"></i> Lock Map';
            btnToggleEdit.classList.add('active');
            btnAddPin.disabled = false;
            helperText.textContent = "Edit Mode unlocked. You can drag pins or add new ones.";
            document.querySelectorAll('.pin').forEach(p => p.style.cursor = 'grab');
        } else {
            btnToggleEdit.innerHTML = '<i class="fa-solid fa-pen"></i> Edit Map';
            btnToggleEdit.classList.remove('active');
            btnAddPin.disabled = true;
            isAddingPin = false; 
            btnAddPin.classList.remove('active');
            mapWrapper.style.cursor = 'default';
            helperText.textContent = "Map Locked. Click 'Edit Map' to unlock.";
            document.querySelectorAll('.pin').forEach(p => p.style.cursor = 'default');
        }
    });

    // KIRIM SEMUA TITIK PIN KE DATABASE 
    btnSaveConfig.addEventListener('click', async function() {
        if(!roomId) return;

        const bedIdByPinLabel = {};
        document.querySelectorAll('.config-card').forEach(card => {
            const bedId = card.dataset.bedId;
            const assignedPin = card.querySelector('.bed-number')?.textContent?.trim();

            if (assignedPin && assignedPin !== '?') {
                bedIdByPinLabel[assignedPin] = bedId;
            }
        });

        const payload = Array.from(document.querySelectorAll('.pin')).map(pinElem => {
            const pinLabel = (pinElem.dataset.label || pinElem.textContent || '').trim();

            return {
                bed_id: bedIdByPinLabel[pinLabel] || null,
                point_label: pinLabel || null,
                position_left: pinElem.style.left,
                position_top: pinElem.style.top,
            };
        });

        if(payload.length === 0) {
            alert('Belum ada pin di map. Tambahkan pin dulu sebelum menyimpan.');
            return;
        }

        btnSaveConfig.disabled = true;
        btnSaveConfig.textContent = "Saving to Database...";

        try {
            const response = await fetch(`/admin/rooms/${encodeURIComponent(roomId)}/bed-pins/sync`, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ pins: payload }),
            });

            const rawText = await response.text();
            let json = {};

            try {
                json = rawText ? JSON.parse(rawText) : {};
            } catch (parseError) {
                json = { message: rawText || 'Gagal menyimpan pin denah' };
            }

            if (!response.ok || !json.success) {
                throw new Error(json.message || 'Gagal menyimpan pin denah');
            }
            
            alert('Floor Plan dan Pin berhasil disimpan ke Database!');
            closeModal();
            // Opsional: Reload halaman agar tabel utama ter-refresh
            window.location.reload(); 
        } catch (err) {
            console.error("Save config error:", err);
            alert(err.message || "Terjadi kesalahan saat menyimpan titik pin.");
        } finally {
            btnSaveConfig.disabled = false;
            btnSaveConfig.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Save Floor Plan';
        }
    });

    btnDeleteLayout.addEventListener('click', function() {
        if(confirm('Yakin ingin mereset layar denah ini?')) {
            mapImage.src = '';
            mapImage.style.display = 'none';
            mapContainer.classList.remove('has-image');
            uploadInput.value = '';
            
            document.querySelectorAll('.pin').forEach(p => p.remove());
            pinCounter = 0;
            
            document.querySelectorAll('.bed-number').forEach(b => {
                b.textContent = '?';
                b.classList.add('unassigned');
            });
            
            helperText.textContent = "Denah dibersihkan. Klik area putus-putus untuk unggah ulang.";
            btnAddPin.disabled = true;
        }
    });

})();
</script>