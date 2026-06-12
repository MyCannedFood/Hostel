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
			<h2 class="room-modal__title" id="addNewRoomTitle">Add New Room</h2>
			<button type="button" class="room-modal__close" data-room-modal-close aria-label="Close modal">&times;</button>
		</header>

		<div class="room-modal__body">
			<form id="addRoomForm" method="POST" enctype="multipart/form-data">
				@csrf

				<input type="file" name="photo" id="photoInput" accept="image/*" hidden>

				<div class="form-group">
					<label class="form-label">Photo of Main Room</label>
					<label class="upload-area" id="uploadArea" for="photoInput">
						<i class="fa-regular fa-image upload-icon"></i>
						<span class="upload-text">Click to upload image</span>
						<span class="upload-subtext">JPG, PNG (Max 5MB)</span>
					</label>
				</div>
				<div id="uploadPreview" style="display:none; margin-top:12px; padding: 12px; background-color: #f5f5f5; border: 2px dashed var(--primary-dark); border-radius: 4px; text-align: center; cursor: pointer;"></div>

				<div class="form-group">
					<label class="form-label">Room Name</label>
					<input type="text" name="name" class="form-control" placeholder="Cth: Pavilion" required>
				</div>

				<div class="grid-2">
					<div class="form-group">
						<label class="form-label">Room Type</label>
						<select name="gender_type" class="form-control" required>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Mixed">Mixed</option>
						</select>
					</div>

					<div class="form-group">
						<label class="form-label">Capacity (Bed)</label>
						<input type="number" min="1" name="capacity" class="form-control" value="4">
					</div>
				</div>

				{{-- Description EN + ID --}}
				<div class="grid-2">
					<div class="form-group">
						<label class="form-label">Description (EN)</label>
						<textarea name="description" class="form-control" placeholder="Describe the atmosphere and advantages of this room..."></textarea>
					</div>
					<div class="form-group">
						<label class="form-label">Description (ID)</label>
						<textarea name="description_id" class="form-control" placeholder="Deskripsikan suasana dan keunggulan kamar ini..."></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="form-label">Status</label>
					<select name="status" class="form-control">
						<option value="Available">Active</option>
						<option value="Inactive">Inactive</option>
						<option value="Maintenance">Maintenance</option>
					</select>
				</div>

				{{-- Attributes EN + ID --}}
				<div class="form-group">
					<label class="form-label">Attributes</label>
					<div id="attributesWrapper">
						<div class="input-actions attr-row">
							<div class="input-group">
								<div class="attr-input-wrap">
									<div class="attr-lang-label">EN</div>
									<input type="text" name="attributes[]" class="form-control" placeholder="e.g. Simple & Functional" value="Simple &amp; Functional">
								</div>
								<div class="attr-input-wrap">
									<div class="attr-lang-label">ID</div>
									<input type="text" name="attributes_id[]" class="form-control" placeholder="cth. Simpel & Fungsional" value="Simpel &amp; Fungsional">
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
					</div>
				</div>

				<div class="form-group">
					<label class="form-label">Main Facilities</label>
					<div class="facilities-list">
						<label class="facility-chip">
							<input type="checkbox" name="main_facilities[]" value="AC" checked>
							<span class="custom-checkbox"></span>
							<span class="facility-text">AC</span>
						</label>

						<label class="facility-chip">
							<input type="checkbox" name="main_facilities[]" value="Wifi" checked>
							<span class="custom-checkbox"></span>
							<span class="facility-text">Wifi</span>
						</label>

						<label class="facility-chip">
							<input type="checkbox" name="main_facilities[]" value="En-suite Bath">
							<span class="custom-checkbox"></span>
							<span class="facility-text">En-suite Bath</span>
						</label>

						<label class="facility-chip">
							<input type="checkbox" name="main_facilities[]" value="Lockers">
							<span class="custom-checkbox"></span>
							<span class="facility-text">Lockers</span>
						</label>
					</div>
				</div>

			</form>
		</div>

		<footer class="room-modal__footer">
			<button type="button" class="btn btn-outline" data-room-modal-close>Cancel</button>
			<button type="button" class="btn btn-orange" id="saveRoomBtn">Save Room</button>
		</footer>
	</div>
</div>

<script>
console.log('[Room Modal] Script loaded and executing');

(() => {
	console.log('[Room Modal] IIFE started');

	const container = document.getElementById('roomModal');
	function closeInjectedModal() {
		const c = document.getElementById('addNewRoomContainer');
		if (c) c.remove();
		document.body.classList.remove('modal-open');
	}

	// wire close buttons
	document.querySelectorAll('[data-room-modal-close]').forEach(btn => btn.addEventListener('click', closeInjectedModal));

	// upload area
	const photoInput = document.getElementById('photoInput');
	const uploadArea = document.getElementById('uploadArea');
	const uploadPreview = document.getElementById('uploadPreview');

	console.log('[Room Modal] Elements found - photoInput:', !!photoInput, 'uploadArea:', !!uploadArea, 'uploadPreview:', !!uploadPreview);

	if (photoInput && uploadArea && uploadPreview) {
		// rely on label's `for` to open file picker; show preview when file selected
		photoInput.addEventListener('change', (e) => {
			const f = e.target.files && e.target.files[0];
			console.log('[Room Modal] File selected:', f ? f.name : 'none');

			if (!f) {
				// Clear preview - show text again
				uploadArea.style.display = 'flex';
				uploadPreview.style.display = 'none';
				uploadPreview.innerHTML = '';
				return;
			}

			const url = URL.createObjectURL(f);
			// create image element for clearer layout control
			const img = document.createElement('img');
			img.src = url;
			img.style.maxWidth = '100%';
			img.style.maxHeight = '140px';
			img.style.borderRadius = '4px';
			img.style.objectFit = 'contain';

			// Hide upload area text and show preview in its place
			uploadArea.style.display = 'none';
			uploadPreview.innerHTML = '';
			uploadPreview.appendChild(img);
			uploadPreview.style.display = 'block';
			console.log('[Room Modal] Preview displayed, upload area hidden');
		});

		// Click preview to upload new image
		uploadPreview.addEventListener('click', () => {
			photoInput.click();
		});
	}

	// attributes add/remove — clone both EN and ID inputs
	document.addEventListener('click', function (e) {
		if (e.target.closest('.add-attr')) {
			e.preventDefault();
			const wrapper = document.getElementById('attributesWrapper');
			const row = e.target.closest('.attr-row');
			if (wrapper && row) {
				const clone = row.cloneNode(true);
				clone.querySelectorAll('input').forEach(i => i.value = '');
				wrapper.appendChild(clone);
				console.log('[Room Modal] Attribute row added');
			}
			return;
		}
		if (e.target.closest('.remove-attr')) {
			e.preventDefault();
			const wrapper = document.getElementById('attributesWrapper');
			const rows = wrapper.querySelectorAll('.attr-row');
			if (rows.length <= 1) {
				console.log('[Room Modal] Cannot remove - only one attribute left');
				return;
			}
			const row = e.target.closest('.attr-row');
			if (row) {
				row.remove();
				console.log('[Room Modal] Attribute row removed');
			}
			return;
		}
	});

	// no bed UI in this modal — beds will be managed separately

	// form submit via AJAX
	const form = document.getElementById('addRoomForm');
	const saveBtn = document.getElementById('saveRoomBtn');

	console.log('[Room Modal] form:', form, 'saveBtn:', saveBtn);

	if (saveBtn && form) {
		saveBtn.addEventListener('click', async (ev) => {
			ev.preventDefault();
			const fd = new FormData(form);
			try {
				saveBtn.disabled = true;
				// debug: log FormData keys and file name (if any)
				console.log('[Room Modal] FormData contents:');
				for (const pair of fd.entries()) {
					if (pair[0] === 'photo' && pair[1] instanceof File) {
						console.log('  ' + pair[0] + ':', pair[1].name, '(' + pair[1].size + ' bytes)');
					} else {
						console.log('  ' + pair[0] + ':', pair[1]);
					}
				}

				console.log('[Room Modal] Sending to /rooms');
				const res = await fetch('/rooms', {
					method: 'POST',
					credentials: 'same-origin',
					body: fd,
					headers: {
						'X-Requested-With': 'XMLHttpRequest',
						'Accept': 'application/json'
					}
				});

				console.log('[Room Modal] Response status:', res.status);

				let json = null;
				try {
					json = await res.json();
					console.log('[Room Modal] Response JSON:', json);
				} catch (e) {
					const txt = await res.text();
					console.error('[Room Modal] Non-JSON response:', txt);
					alert('Server returned non-JSON response. See console for details.');
					return;
				}

				if (res.ok && json.success) {
					console.log('[Room Modal] Room saved successfully!');
					closeInjectedModal();
					location.reload();
				} else {
					// show validation errors if present
					if (json.errors) {
						const messages = Object.values(json.errors).flat().join('\n');
						console.error('[Room Modal] Validation errors:', messages);
						alert(messages);
					} else {
						console.error('[Room Modal] Save failed:', json.message);
						alert((json.message || 'Failed to save room'));
					}
				}
			} catch (err) {
				console.error('[Room Modal] Error:', err);
				alert('Error while saving room: ' + err.message);
			} finally {
				saveBtn.disabled = false;
			}
		});
	}
})();
</script>