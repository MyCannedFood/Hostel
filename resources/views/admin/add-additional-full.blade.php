<div class="room-modal is-open" id="additionalModal" role="dialog" aria-modal="true" aria-labelledby="am-title">
	<div class="room-modal__panel-additional">
		<header class="room-modal__header">
			<h2 class="room-modal__title" id="am-title">Additional Management</h2>
			<button type="button" class="room-modal__close" data-additional-modal-close>&times;</button>
		</header>

		<div class="room-modal__body">
			<div class="form-row">
				<div class="form-col">
					<div class="form-group">
						<label class="form-label" for="am-name">Add-on Name</label>
						<input class="form-control" id="am-name" type="text" placeholder="Bamboo Pillow">
					</div>
					<div class="form-group">
						<label class="form-label" for="am-price">Price (IDR)</label>
						<input class="form-control" id="am-price" type="number" min="0" placeholder="1000">
					</div>
					<div class="form-group">
						<label class="form-label" for="am-discount">Discount (%)</label>
						<input class="form-control" id="am-discount" type="number" min="0" max="100" placeholder="0">
					</div>
				</div>

				<div class="form-col">
					<div class="form-group">
						<label class="form-label" for="am-note">Note / Description</label>
						<textarea class="form-control" id="am-note" placeholder="Description of the add-on..."></textarea>
					</div>

					<div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 12px;">
					<div class="auto-row">
						<span class="form-label">Auto Include</span>
						<label class="toggle">
							<input type="checkbox" id="am-auto">
							<span class="toggle-track"></span>
						</label>
					</div>
				</div>

				<div class="days-wrap">
					<span class="form-label">Include Days</span>
					<div class="days-row" id="am-days-row">
						<button type="button" class="day-btn" data-day="Mon">Mon</button>
						<button type="button" class="day-btn" data-day="Tue">Tue</button>
						<button type="button" class="day-btn" data-day="Wed">Wed</button>
						<button type="button" class="day-btn" data-day="Thu">Thu</button>
						<button type="button" class="day-btn" data-day="Fri">Fri</button>
						<button type="button" class="day-btn" data-day="Sat">Sat</button>
						<button type="button" class="day-btn" data-day="Sun">Sun</button>
					</div>
				</div>

				</div>
			</div>

			<div class="action-row">
				<button type="button" class="btn" id="am-btn-delete" disabled>Delete</button>
				<button type="button" class="btn" id="am-btn-update" disabled>Update</button>
				<button type="button" class="btn btn-orange" id="am-btn-add">Add New</button>
			</div>

			<div class="table-wrap">
				<table>
					<colgroup>
						<col style="width:5%">
						<col style="width:25%">
						<col style="width:15%">
						<col style="width:25%">
						<col style="width:15%">
						<col style="width:15%">
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Price</th>
							<th>Include Days</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="am-tbody"></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>window.initAddAdditionalModal()</script>
