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
		max-width: 600px;
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
	}

	.room-modal .input-group input {
		border-right: 1px solid var(--border-color);
		border-top-right-radius: 2px;
		border-bottom-right-radius: 2px;
	}

	.room-modal .input-btn {
		background-color: var(--white);
		border: 1px solid var(--border-color);
		padding: 10px 12px;
		border-top-right-radius: 2px;
		border-bottom-right-radius: 2px;
		color: var(--primary-dark);
		cursor: pointer;
	}

	.room-modal .input-actions {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.room-modal .icon-btn {
		width: 40px;
		height: 40px;
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
	}

	.room-modal .icon-btn:hover {
		background-color: #f0f0f0;
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
		.room-modal .grid-3 {
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
			<div class="form-group">
				<label class="form-label">Photo of Main Room</label>
				<div class="upload-area">
					<i class="fa-regular fa-image upload-icon"></i>
					<span class="upload-text">Click to upload image</span>
					<span class="upload-subtext">JPG, PNG (Max 2MB)</span>
				</div>
			</div>

			<div class="form-group">
				<label class="form-label">Room Name</label>
				<input type="text" class="form-control" placeholder="Cth: Pavilion">
			</div>

			<div class="form-group">
				<label class="form-label">Room Type</label>
				<select class="form-control">
					<option>Male</option>
					<option>Female</option>
					<option>Mixed</option>
				</select>
			</div>

			<div class="form-group">
				<label class="form-label">Description</label>
				<textarea class="form-control" placeholder="Describe the atmosphere and advantages of this room..."></textarea>
			</div>

			<div class="grid-2">
				<div class="form-group">
					<label class="form-label">Capacity (Bed)</label>
					<input type="number" class="form-control" value="4">
				</div>

				<div class="form-group">
					<label class="form-label">Status</label>
					<select class="form-control">
						<option>Active</option>
						<option>Inactive</option>
						<option>Maintenance</option>
					</select>
				</div>
			</div>

				<div class="form-group">
					<label class="form-label">Attribute</label>
					<div class="input-actions">
						<div class="input-group" style="flex: 1;">
							<input type="text" class="form-control" value="Simple & Functional">
						</div>
						<div class="icon-group" aria-label="Attribute actions">
							<button type="button" class="icon-btn" aria-label="Add attribute">
								<img src="{{ asset('images/Plus square.svg') }}" alt="Add attribute">
							</button>
							<button type="button" class="icon-btn" aria-label="Delete attribute">
								<img src="{{ asset('images/delete.svg') }}" alt="Delete attribute">
							</button>
						</div>
					</div>
				</div>

			<div class="form-group">
				<label class="form-label">Main Facilities</label>
				<div class="facilities-list">
					<label class="facility-chip">
						<input type="checkbox" checked>
						<span class="custom-checkbox"></span>
						<span class="facility-text">AC</span>
					</label>

					<label class="facility-chip">
						<input type="checkbox" checked>
						<span class="custom-checkbox"></span>
						<span class="facility-text">Wifi</span>
					</label>

					<label class="facility-chip">
						<input type="checkbox">
						<span class="custom-checkbox"></span>
						<span class="facility-text">En-suite Bath</span>
					</label>

					<label class="facility-chip">
						<input type="checkbox">
						<span class="custom-checkbox"></span>
						<span class="facility-text">Lockers</span>
					</label>
				</div>
			</div>
		</div>

		<footer class="room-modal__footer">
			<button type="button" class="btn btn-outline" data-room-modal-close>Cancel</button>
			<button type="button" class="btn btn-orange">Simpan Kamar</button>
		</footer>
	</div>
</div>
