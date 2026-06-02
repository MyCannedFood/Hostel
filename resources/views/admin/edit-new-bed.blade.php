<style>
    :root {
        --primary-dark: #1A3D0A;
        --primary-light: #B8D9A0;
        --accent-orange: #D9864A;
        --bg-main: #FAFAF5;
        --bg-body: #F6F6F1;
        --white: #FFFFFF;
        --text-muted: #73796D;
        --border-color: rgba(26, 61, 10, 0.35);
    }

    .bed-modal {
        position: fixed;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(0, 0, 0, 0.6);
        z-index: 99999;
    }

    .bed-modal.is-open {
        display: flex;
    }

    .bed-modal__panel {
        width: 100%;
        max-width: 500px;
        background-color: var(--bg-main);
        border-radius: 12px;
        outline: 1px solid rgba(75, 153, 96, 0.2);
        box-shadow: 0 4px 24px rgba(26, 61, 10, 0.08);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        max-height: 90vh;
    }

    .bed-modal__header {
        background-color: var(--primary-light);
        padding: 16px 24px;
        border-bottom: 1px solid var(--primary-dark);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bed-modal__title {
        color: var(--primary-dark);
        font-family: 'EB Garamond', serif;
        font-size: 24px;
        font-weight: 500;
    }

    .bed-modal__close {
        background: none;
        border: none;
        font-size: 20px;
        color: var(--primary-dark);
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .bed-modal__close:hover {
        opacity: 0.7;
    }

    .bed-modal__body {
        padding: 24px;
        background-color: var(--bg-body);
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-height: 70vh;
        overflow-y: auto;
        font-family: 'DM Sans', sans-serif;
    }

    .bed-modal .alert-info {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px;
        background-color: var(--bg-body);
        border: 1px solid var(--primary-dark);
        border-radius: 4px;
        color: var(--primary-dark);
        font-size: 14px;
        line-height: 1.4;
    }

    .bed-modal .alert-info i {
        color: var(--accent-orange);
        font-size: 16px;
        margin-top: 2px;
    }

    .bed-modal .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .bed-modal .form-label {
        color: var(--primary-dark);
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .bed-modal .form-control {
        width: 100%;
        padding: 10px 12px;
        background-color: var(--white);
        border: 1px solid var(--primary-dark);
        border-radius: 4px;
        font-family: inherit;
        font-size: 14px;
        color: var(--primary-dark);
        outline: none;
        transition: box-shadow 0.2s;
    }

    .bed-modal .form-control:focus {
        box-shadow: 0 0 0 2px rgba(26, 61, 10, 0.1);
    }

    .bed-modal select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%231A3D0A%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
        background-repeat: no-repeat;
        background-position: right 12px top 50%;
        background-size: 10px auto;
    }

    .bed-modal .input-group {
        display: flex;
        align-items: center;
        background-color: var(--white);
        border: 1px solid var(--primary-dark);
        border-radius: 4px;
        overflow: hidden;
    }

    .bed-modal .input-group-text {
        padding: 10px 12px;
        background-color: var(--white);
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 14px;
    }

    .bed-modal .input-group input {
        border: none;
        border-radius: 0;
        flex: 1;
    }

    .bed-modal .input-group input:focus {
        box-shadow: none;
    }

    .bed-modal__footer {
        background-color: var(--primary-light);
        padding: 16px 24px;
        border-top: 1px solid var(--primary-dark);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .bed-modal .btn {
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        font-family: inherit;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .bed-modal .btn-outline {
        background-color: var(--white);
        color: var(--primary-dark);
        border: 1px solid var(--primary-dark);
    }

    .bed-modal .btn-outline:hover {
        background-color: #f0f0f0;
    }

    .bed-modal .btn-orange {
        background-color: var(--accent-orange);
        color: var(--white);
        border: 1px solid transparent;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .bed-modal .btn-orange:hover {
        background-color: #c4763e;
    }
</style>

@php
    $rooms = $rooms ?? collect();
    $bed = $bed ?? null;
    $selectedRoomId = (int) ($selectedRoomId ?? ($bed?->room_id ?? $rooms->first()?->id ?? 0));
    $modalTitle = $bed ? 'Edit BED' : 'Edit BED';
    $formAction = $bed ? route('beds.update', $bed->id) : route('beds.store');
@endphp

<div class="bed-modal is-open" id="bedModal" role="dialog" aria-modal="true" aria-labelledby="editBedTitle" aria-hidden="false">
    <div class="bed-modal__panel">
        <header class="bed-modal__header">
            <h2 class="bed-modal__title" id="editBedTitle">{{ $modalTitle }}</h2>
            <button type="button" class="bed-modal__close" data-bed-modal-close aria-label="Close modal">&times;</button>
        </header>

        <form action="{{ $formAction }}" method="POST" id="editBedForm">
            @csrf
            @if ($bed)
                @method('PUT')
            @endif

            <div class="bed-modal__body">
                <div class="alert-info">
                    <img src="{{ asset('images/warning.svg') }}" alt="Warning">
                    <span>Update bed data before saving the changes.</span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="room_id">Room</label>
                    <select id="room_id" name="room_id" class="form-control" required>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" @selected((int) $room->id === $selectedRoomId)>
                                {{ $room->name }} ({{ $room->capacity}} beds)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="bed_name">Bed ID/Name</label>
                    <input type="text" id="bed_name" name="name" class="form-control" placeholder="Enter Bed ID (e.g. SH-B3)" value="{{ old('name', $bed?->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="bed_position">Position</label>
                    <input type="text" id="bed_position" name="position" class="form-control" placeholder="e.g. 1 - Bottom Bed" value="{{ old('position', $bed?->position) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="bed_status">Current Status</label>
                    <select id="bed_status" name="status" class="form-control" required>
                        <option value="Available" @selected(old('status', $bed?->status) === 'Available')>Available</option>
                        <option value="Occupied" @selected(old('status', $bed?->status) === 'Occupied')>Occupied</option>
                        <option value="Maintenance" @selected(old('status', $bed?->status) === 'Maintenance')>Maintenance</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="base_price">Base Price (IDR / Night)</label>
                    <div class="input-group">
                        <span class="input-group-text">IDR</span>
                        <input type="number" id="base_price" name="base_price" class="form-control" placeholder="0" min="0" value="{{ old('base_price', $bed?->base_price) }}" required>
                    </div>
                </div>
            </div>

            <footer class="bed-modal__footer">
                <button type="button" class="btn btn-outline" data-bed-modal-close>Cancel</button>
                <button type="submit" class="btn btn-orange">Save Changes</button>
            </footer>
        </form>
    </div>
</div>

<script>
(() => {
    const modal = document.getElementById('bedModal');
    const form = document.getElementById('editBedForm');
    const closeButtons = document.querySelectorAll('[data-bed-modal-close]');
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

    function closeInjectedModal() {
        const container = document.getElementById('editNewBedContainer');
        if (container) container.remove();
        document.body.classList.remove('modal-open');
    }

    window.closeInjectedModal = closeInjectedModal;

    closeButtons.forEach(btn => btn.addEventListener('click', closeInjectedModal));

    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeInjectedModal();
            }
        });
    }

    if (form) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const fd = new FormData(form);
            if (csrfToken && !fd.get('_token')) {
                fd.append('_token', csrfToken);
            }

            const headers = {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            };
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }

            try {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) submitBtn.disabled = true;

                const response = await fetch(form.action, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: fd,
                    headers,
                });

                const json = await response.json();
                if (response.ok && json.success) {
                    closeInjectedModal();
                    location.reload();
                    return;
                }

                if (json.errors) {
                    alert(Object.values(json.errors).flat().join('\n'));
                } else {
                    alert(json.message || 'Failed to update bed');
                }
            } catch (err) {
                console.error('[Bed Modal] Error:', err);
                alert('Error while saving bed: ' + err.message);
            } finally {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    }
})();
</script>