@php
	$room = $room ?? null;
	$attributes   = array_values(array_filter(array_map('trim', explode(',', (string) ($room->attributes    ?? '')))));
	$attributesId = array_values(array_filter(array_map('trim', explode(',', (string) ($room->attributes_id ?? '')))));
	$mainFacilities = array_values(array_filter(array_map('trim', explode(',', (string) ($room->main_facilities ?? '')))));
	$roomPhoto = !empty($room?->photo) ? asset('storage/' . $room->photo) : asset('images/Background.png');
	$hasExistingPhoto = !empty($room?->photo);
@endphp
<style>
	:root {
		--primary-dark: #1A3D0A;
		--primary-light: #B8D9A0;
		--accent-orange: #D9864A;
		--bg-main: #FAFAF5;
		--bg-upload: #EEEEE9;
		--border-color: rgba(26, 61, 10, 0.5);
		--text-muted: #73796D;
		--white: #FFFFFF;
	}

	.room-modal {
		position: fixed;
		inset: 0;
		display: none;
		align-items: center;
		justify-content: center;
		padding: 20px;
		background: rgba(0, 0, 0, 0.6);
		z-index: 99999;
	}

	.room-modal.is-open {
		display: flex;
	}

	.room-modal__panel {
		width: 100%;
		max-width: 680px;
		background-color: var(--bg-main);
		border-radius: 8px;
		outline: 1px solid var(--primary-dark);
		box-shadow: 0 4px 24px rgba(26, 61, 10, 0.08);
		display: flex;
		flex-direction: column;
		overflow: hidden;
		max-height: 90vh;
	}

	.room-modal__header {
		background-color: var(--primary-light);
		padding: 16px 24px;
		border-bottom: 1px solid var(--primary-dark);
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.room-modal__title {
		color: var(--primary-dark);
		font-family: 'EB Garamond', serif;
		font-size: 30px;
		font-weight: 500;
	}

	.room-modal__close {
		background: none;
		border: none;
		font-size: 20px;
		color: var(--text-muted);
		cursor: pointer;
		transition: color 0.2s;
	}

	.room-modal__close:hover {
		color: var(--primary-dark);
	}

	.room-modal__body {
		padding: 24px;
		display: flex;
		flex-direction: column;
		gap: 20px;
		max-height: 70vh;
		overflow-y: auto;
		font-family: 'DM Sans', sans-serif;
	}

	.room-modal .form-group {
		display: flex;
		flex-direction: column;
		gap: 8px;
	}

	.room-modal .form-label {
		color: var(--primary-dark);
		font-size: 16px;
		font-weight: 700;
		letter-spacing: 1.2px;
	}

	.room-modal .form-control {
		width: 100%;
		padding: 10px 12px;
		background-color: var(--white);
		border: 1px solid var(--border-color);
		border-radius: 2px;
		font: inherit;
		font-size: 14px;
		color: var(--primary-dark);
		outline: none;
		box-sizing: border-box;
	}

	.room-modal .form-control:focus {
		border-color: var(--primary-dark);
	}

	.room-modal .form-control::placeholder {
		color: rgba(26, 61, 10, 0.5);
	}

	.room-modal select.form-control {
		appearance: none;
		background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%231A3D0A%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
		background-repeat: no-repeat;
		background-position: right 12px top 50%;
		background-size: 10px auto;
	}

	.room-modal textarea.form-control {
		resize: vertical;
		min-height: 80px;
	}

	.room-modal .upload-area {
		background-color: var(--bg-upload);
		border: 2px dashed var(--primary-dark);
		border-radius: 8px;
		height: 140px;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		gap: 8px;
		cursor: pointer;
		transition: background-color 0.2s;
	}

	.room-modal .upload-area:hover {
		background-color: #e5e5df;
	}

	.room-modal .upload-icon {
		color: #4B9960;
		font-size: 24px;
	}

	.room-modal .upload-text {
		color: var(--primary-dark);
		font-size: 14px;
	}

	.room-modal .upload-subtext {
		color: var(--text-muted);
		font-size: 12px;
	}

	.room-modal .grid-3 {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 16px;
	}

	.room-modal .grid-2 {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 16px;
	}

	.room-modal .input-group {
		display: flex;
		align-items: center;
		gap: 8px;
		flex: 1;
	}

	.room-modal .input-actions {
		display: flex;
		align-items: center;
		gap: 8px;
		margin-bottom: 8px;
	}

	.room-modal .icon-btn {
		width: 40px;
		height: 40px;
		flex-shrink: 0;
		border: 1px solid var(--border-color);
		border-radius: 2px;
		background-color: var(--white);
		color: var(--primary-dark);
		display: inline-flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
	}

	.room-modal .icon-btn img {
		width: 18px;
		height: 18px;
		display: block;
	}

	.room-modal .icon-group {
		display: inline-flex;
		gap: 8px;
		flex-shrink: 0;
	}

	.room-modal .icon-btn:hover {
		background-color: #f0f0f0;
	}

	.room-modal .attr-lang-label {
		font-size: 11px;
		font-weight: 600;
		color: var(--text-muted);
		letter-spacing: 0.8px;
		text-transform: uppercase;
		margin-bottom: 2px;
	}

	.room-modal .attr-input-wrap {
		display: flex;
		flex-direction: column;
		flex: 1;
	}

	.room-modal .facilities-list {
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
	}

	.room-modal .facility-chip {
		background-color: var(--primary-light);
		border: 1px solid var(--primary-dark);
		border-radius: 2px;
		padding: 6px 12px;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		cursor: pointer;
	}

	.room-modal .facility-chip input[type="checkbox"] {
		display: none;
	}

	.room-modal .custom-checkbox {
		width: 14px;
		height: 14px;
		background-color: var(--white);
		border: 1px solid var(--primary-dark);
		display: inline-flex;
		justify-content: center;
		align-items: center;
	}

	.room-modal .facility-chip input[type="checkbox"]:checked + .custom-checkbox {
		background-color: var(--accent-orange);
		border-color: var(--accent-orange);
	}

	.room-modal .facility-chip input[type="checkbox"]:checked + .custom-checkbox::after {
		content: '';
		width: 10px;
		height: 10px;
		background: url("{{ asset('images/Input.svg') }}") center center / contain no-repeat;
	}

	.room-modal .facility-text {
		color: var(--primary-dark);
		font-size: 14px;
		font-weight: 500;
	}

	.room-modal__footer {
		background-color: var(--primary-light);
		padding: 16px 24px;
		border-top: 1px solid var(--primary-dark);
		display: flex;
		justify-content: flex-end;
		gap: 12px;
	}

	.room-modal .btn {
		padding: 10px 20px;
		font-size: 14px;
		font-family: inherit;
		border-radius: 2px;
		cursor: pointer;
		transition: all 0.2s;
	}

	.room-modal .btn-outline {
		background-color: var(--white);
		color: var(--primary-dark);
		border: 1px solid var(--primary-dark);
	}

	.room-modal .btn-outline:hover {
		background-color: #f0f0f0;
	}

	.room-modal .btn-orange {
		background-color: var(--accent-orange);
		color: var(--white);
		border: 1px solid transparent;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
	}

	.room-modal .btn-orange:hover {
		background-color: #c4763e;
	}

	@media (max-width: 768px) {
		.room-modal .grid-3,
		.room-modal .grid-2 {
			grid-template-columns: 1fr;
		}

		.room-modal__panel {
			max-width: 100%;
		}
	}
</style>

<div class="room-modal is-open" id="roomModal" role="dialog" aria-modal="true" aria-labelledby="addNewRoomTitle" aria-hidden="false">
	<div class="room-modal__panel">
		<header class="room-modal__header">
			<h2 class="room-modal__title" id="addNewRoomTitle">Edit Room</h2>
			<button type="button" class="room-modal__close" data-room-modal-close aria-label="Close modal">&times;</button>
		</header>

		<div class="room-modal__body">
			<form id="addRoomForm" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="room_id" value="{{ $room->id ?? '' }}">
				<input type="file" name="photo" id="photoInput" accept="image/*" hidden>

				{{-- Photo --}}
				<div class="form-group">
					<label class="form-label">Photo of Main Room</label>
					<label for="photoInput" class="upload-area" id="uploadArea">
						<div class="upload-icon">+</div>
						<div class="upload-text">Click to upload photo</div>
					</label>
				</div>

				<div id="uploadPreview" style="display:{{ $hasExistingPhoto ? 'block' : 'none' }}; margin-top:12px; padding: 12px; background-color: #f5f5f5; border: 2px dashed var(--primary-dark); border-radius: 4px; text-align: center; cursor: pointer;">
					@if ($hasExistingPhoto)
						<img src="{{ $roomPhoto }}" alt="{{ $room->name }}" style="max-width:100%; max-height:140px; border-radius:4px; object-fit:contain;">
					@endif
				</div>

				{{-- Room Name --}}
				<div class="form-group" style="margin-top:20px;">
					<label class="form-label">Room Name</label>
					<input type="text" name="name" class="form-control" placeholder="Cth: Pavilion" value="{{ old('name', $room->name ?? '') }}" required>
				</div>

				{{-- Room Type + Capacity --}}
				<div class="grid-2">
					<div class="form-group">
						<label class="form-label">Room Type</label>
						<select name="gender_type" class="form-control" required>
							<option value="Male"   @selected(old('gender_type', $room->gender_type ?? 'Male') === 'Male')>Male</option>
							<option value="Female" @selected(old('gender_type', $room->gender_type ?? '') === 'Female')>Female</option>
							<option value="Mixed"  @selected(old('gender_type', $room->gender_type ?? '') === 'Mixed')>Mixed</option>
						</select>
					</div>
					<div class="form-group">
						<label class="form-label">Capacity (Bed)</label>
						<input type="number" min="1" name="capacity" class="form-control" value="{{ old('capacity', $room->capacity ?? 4) }}">
					</div>
				</div>

				{{-- Description EN + ID --}}
				<div class="grid-2">
					<div class="form-group">
						<label class="form-label">Description (EN)</label>
						<textarea name="description" class="form-control" placeholder="Describe the atmosphere and advantages of this room...">{{ old('description', $room->description ?? '') }}</textarea>
					</div>
					<div class="form-group">
						<label class="form-label">Description (ID)</label>
						<textarea name="description_id" class="form-control" placeholder="Deskripsikan suasana dan keunggulan kamar ini...">{{ old('description_id', $room->description_id ?? '') }}</textarea>
					</div>
				</div>

				{{-- Status --}}
				<div class="form-group">
					<label class="form-label">Status</label>
					<select name="status" class="form-control">
						<option value="Available"   @selected(old('status', $room->status ?? 'Available') === 'Available')>Active</option>
						<option value="Inactive"    @selected(old('status', $room->status ?? '') === 'Inactive')>Inactive</option>
						<option value="Maintenance" @selected(old('status', $room->status ?? '') === 'Maintenance')>Maintenance</option>
					</select>
				</div>

				{{-- Attributes --}}
				<div class="form-group">
					<label class="form-label">Attributes</label>
					<div id="attributesWrapper">
						@if (count($attributes))
							@foreach ($attributes as $i => $attribute)
								<div class="input-actions attr-row">
									<div class="input-group">
										<div class="attr-input-wrap">
											<div class="attr-lang-label">EN</div>
											<input type="text" name="attributes[]" class="form-control" placeholder="e.g. Simple & Functional" value="{{ $attribute }}">
										</div>
										<div class="attr-input-wrap">
											<div class="attr-lang-label">ID</div>
											<input type="text" name="attributes_id[]" class="form-control" placeholder="cth. Simpel & Fungsional" value="{{ $attributesId[$i] ?? '' }}">
										</div>
									</div>
									<div class="icon-group" aria-label="Attribute actions">
										<button type="button" class="icon-btn add-attr" aria-label="Add attribute">
											<img src="{{ asset('images/Plus square.svg') }}" alt="Add attribute">
										</button>
										<button type="button" class="icon-btn remove-attr" aria-label="Delete attribute">
											<img src="{{ asset('images/delete.svg') }}" alt="Delete attribute">
										</button>
									</div>
								</div>
							@endforeach
						@else
							<div class="input-actions attr-row">
								<div class="input-group">
									<div class="attr-input-wrap">
										<div class="attr-lang-label">EN</div>
										<input type="text" name="attributes[]" class="form-control" placeholder="e.g. Simple & Functional">
									</div>
									<div class="attr-input-wrap">
										<div class="attr-lang-label">ID</div>
										<input type="text" name="attributes_id[]" class="form-control" placeholder="cth. Simpel & Fungsional">
									</div>
								</div>
								<div class="icon-group" aria-label="Attribute actions">
									<button type="button" class="icon-btn add-attr" aria-label="Add attribute">
										<img src="{{ asset('images/Plus square.svg') }}" alt="Add attribute">
									</button>
									<button type="button" class="icon-btn remove-attr" aria-label="Delete attribute">
										<img src="{{ asset('images/delete.svg') }}" alt="Delete attribute">
									</button>
								</div>
							</div>
						@endif
					</div>
				</div>

				{{-- Main Facilities --}}
				<div class="form-group">
					<label class="form-label">Main Facilities</label>
					<div class="facilities-list">
						<label class="facility-chip">
							<input type="checkbox" name="main_facilities[]" value="AC" @checked(in_array('AC', $mainFacilities))>
							<span class="custom-checkbox"></span>
							<span class="facility-text">AC</span>
						</label>
						<label class="facility-chip">
							<input type="checkbox" name="main_facilities[]" value="Wifi" @checked(in_array('Wifi', $mainFacilities))>
							<span class="custom-checkbox"></span>
							<span class="facility-text">Wifi</span>
						</label>
						<label class="facility-chip">
							<input type="checkbox" name="main_facilities[]" value="En-suite Bath" @checked(in_array('En-suite Bath', $mainFacilities))>
							<span class="custom-checkbox"></span>
							<span class="facility-text">En-suite Bath</span>
						</label>
						<label class="facility-chip">
							<input type="checkbox" name="main_facilities[]" value="Lockers" @checked(in_array('Lockers', $mainFacilities))>
							<span class="custom-checkbox"></span>
							<span class="facility-text">Lockers</span>
						</label>
					</div>
				</div>
			</form>
		</div>

		<footer class="room-modal__footer">
			<button type="button" class="btn btn-outline" data-room-modal-close>Cancel</button>
			<button type="button" class="btn btn-outline" id="deleteRoomBtn">Delete Room</button>
			<button type="button" class="btn btn-orange" id="saveRoomBtn">Edit Room</button>
		</footer>
	</div>
</div>

<script>
(() => {
	const roomId = {{ (int) ($room->id ?? 0) }};
	const form = document.getElementById('addRoomForm');
	const saveBtn = document.getElementById('saveRoomBtn');
	const deleteBtn = document.getElementById('deleteRoomBtn');
	const photoInput = document.getElementById('photoInput');
	const uploadArea = document.getElementById('uploadArea');
	const uploadPreview = document.getElementById('uploadPreview');
	const csrfMeta = document.querySelector('meta[name="csrf-token"]');
	const formTokenInput = form ? form.querySelector('input[name="_token"]') : null;
	const csrfToken = (csrfMeta && csrfMeta.getAttribute('content')) || (formTokenInput && formTokenInput.value) || '';

	function closeInjectedModal() {
		const container = document.getElementById('editNewRoomContainer');
		if (container) container.remove();
		document.body.classList.remove('modal-open');
	}

	window.closeInjectedModal = closeInjectedModal;

	document.querySelectorAll('[data-room-modal-close]').forEach(btn =>
		btn.addEventListener('click', closeInjectedModal)
	);

	if (photoInput && uploadArea && uploadPreview) {
		photoInput.addEventListener('change', (e) => {
			const file = e.target.files && e.target.files[0];
			if (!file) {
				uploadArea.style.display = 'flex';
				uploadPreview.style.display = 'none';
				uploadPreview.innerHTML = '';
				return;
			}
			const img = document.createElement('img');
			img.src = URL.createObjectURL(file);
			img.style.maxWidth = '100%';
			img.style.maxHeight = '140px';
			img.style.borderRadius = '4px';
			img.style.objectFit = 'contain';
			uploadArea.style.display = 'none';
			uploadPreview.innerHTML = '';
			uploadPreview.appendChild(img);
			uploadPreview.style.display = 'block';
		});

		uploadPreview.addEventListener('click', () => photoInput.click());
	}

	// Add / remove attribute rows — clone both EN and ID inputs
	document.addEventListener('click', function (e) {
		if (e.target.closest('.add-attr')) {
			e.preventDefault();
			const wrapper = document.getElementById('attributesWrapper');
			const row = e.target.closest('.attr-row');
			if (wrapper && row) {
				const clone = row.cloneNode(true);
				clone.querySelectorAll('input').forEach(input => input.value = '');
				wrapper.appendChild(clone);
			}
			return;
		}

		if (e.target.closest('.remove-attr')) {
			e.preventDefault();
			const wrapper = document.getElementById('attributesWrapper');
			const rows = wrapper ? wrapper.querySelectorAll('.attr-row') : [];
			if (rows.length <= 1) return;
			const row = e.target.closest('.attr-row');
			if (row) row.remove();
			return;
		}
	});

	if (saveBtn && form && roomId) {
		saveBtn.addEventListener('click', async (event) => {
			event.preventDefault();
			const fd = new FormData(form);
			fd.append('_method', 'PUT');
			if (csrfToken && !fd.get('_token')) fd.append('_token', csrfToken);

			try {
				saveBtn.disabled = true;
				const response = await fetch(`/rooms/${roomId}`, {
					method: 'POST',
					credentials: 'same-origin',
					body: fd,
					headers: {
						'X-Requested-With': 'XMLHttpRequest',
						'Accept': 'application/json',
						'X-CSRF-TOKEN': csrfToken,
					},
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
					alert(json.message || 'Failed to update room');
				}
			} catch (err) {
				console.error('[Room Edit Modal] Error:', err);
				alert('Error while updating room: ' + err.message);
			} finally {
				saveBtn.disabled = false;
			}
		});
	}

	if (deleteBtn && roomId) {
		deleteBtn.addEventListener('click', async () => {
			if (!window.confirm('Delete this room?')) return;

			const fd = new FormData();
			fd.append('_method', 'DELETE');
			if (csrfToken) fd.append('_token', csrfToken);

			try {
				deleteBtn.disabled = true;
				const response = await fetch(`/rooms/${roomId}`, {
					method: 'POST',
					credentials: 'same-origin',
					body: fd,
					headers: {
						'X-Requested-With': 'XMLHttpRequest',
						'Accept': 'application/json',
						'X-CSRF-TOKEN': csrfToken,
					},
				});

				const json = await response.json();
				if (response.ok && json.success) {
					closeInjectedModal();
					location.reload();
					return;
				}
				alert(json.message || 'Failed to delete room');
			} catch (err) {
				console.error('[Room Edit Modal] Error:', err);
				alert('Error while deleting room: ' + err.message);
			} finally {
				deleteBtn.disabled = false;
			}
		});
	}
})();
</script>