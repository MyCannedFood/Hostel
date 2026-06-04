window.initAddAdditionalModal = function () {
	const API_URL = '/admin/add-ons';
	const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

	let addOns = [];
	let selectedId = null;

	const nameEl = document.getElementById('am-name');
	const priceEl = document.getElementById('am-price');
	const discountEl = document.getElementById('am-discount');
	const noteEl = document.getElementById('am-note');
	const autoEl = document.getElementById('am-auto');
	const daysRow = document.getElementById('am-days-row');
	const tbody = document.getElementById('am-tbody');
	const btnAdd = document.getElementById('am-btn-add');
	const btnUpdate = document.getElementById('am-btn-update');
	const btnDelete = document.getElementById('am-btn-delete');

	function getSelectedDays() {
		return Array.from(daysRow.querySelectorAll('.day-btn.active')).map(b => b.dataset.day);
	}

	function clearForm() {
		nameEl.value = '';
		priceEl.value = '';
		discountEl.value = '';
		noteEl.value = '';
		autoEl.checked = false;
		daysRow.querySelectorAll('.day-btn.active').forEach(b => b.classList.remove('active'));
		selectedId = null;
		btnUpdate.disabled = true;
		btnDelete.disabled = true;
		btnAdd.disabled = false;
	}

	function fillForm(data) {
		nameEl.value = data.name;
		priceEl.value = data.price;
		discountEl.value = data.discount || '';
		noteEl.value = data.note || '';
		autoEl.checked = !!data.is_auto_include;
		daysRow.querySelectorAll('.day-btn').forEach(b => {
			b.classList.toggle('active', (data.include_days || []).includes(b.dataset.day));
		});
		selectedId = data.id;
		btnUpdate.disabled = false;
		btnDelete.disabled = false;
		btnAdd.disabled = true;
	}

	function renderTable() {
		if (!addOns.length) {
			tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:24px;color:var(--text-muted);font-style:italic;">No add-ons yet — add one above</td></tr>`;
			return;
		}
		tbody.innerHTML = addOns.map((a, i) => `
			<tr data-id="${a.id}">
				<td>${i + 1}</td>
				<td>${a.name}</td>
				<td>IDR ${Number(a.price).toLocaleString('id-ID')}</td>
				<td>${(a.include_days || []).join(', ') || '-'}</td>
				<td>${a.is_active ? 'Active' : 'Inactive'}</td>
				<td style="white-space:nowrap;">
					<button class="btn-icon" onclick="amEdit(${a.id})" title="Edit">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
					</button>
					<button class="btn-icon btn-icon--delete" onclick="amDelete(${a.id})" title="Delete">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
					</button>
				</td>
			</tr>
		`).join('');
	}

	window.amEdit = function(id) {
		const data = addOns.find(a => a.id === id);
		if (data) fillForm(data);
	};

	window.amDelete = async function(id) {
		if (!confirm('Delete this add-on?')) return;
		try {
			const res = await fetch(`${API_URL}/${id}`, {
				method: 'DELETE',
				headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF_TOKEN },
				credentials: 'same-origin',
			});
			const json = await res.json();
			if (json.success) {
				if (selectedId === id) clearForm();
				await loadData();
			} else {
				alert(json.message || 'Failed to delete');
			}
		} catch (e) {
			alert('Error: ' + e.message);
		}
	};

	async function loadData() {
		try {
			const res = await fetch(API_URL, { credentials: 'same-origin' });
			if (!res.ok) return;
			const json = await res.json();
			if (json.success) addOns = json.data;
			renderTable();
		} catch (e) {
			console.error('Failed to load add-ons:', e);
		}
	}

	async function saveData() {
		const body = {
			name: nameEl.value,
			price: priceEl.value,
			discount: discountEl.value || null,
			note: noteEl.value || '',
			is_auto_include: autoEl.checked,
			include_days: getSelectedDays(),
		};
		try {
			const url = selectedId ? `${API_URL}/${selectedId}` : API_URL;
			const method = selectedId ? 'PUT' : 'POST';
			const res = await fetch(url, {
				method,
				headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF_TOKEN },
				credentials: 'same-origin',
				body: JSON.stringify(body),
			});
			const json = await res.json();
			if (json.success) {
				clearForm();
				await loadData();
			} else {
				alert(json.message || 'Failed to save');
			}
		} catch (e) {
			alert('Error: ' + e.message);
		}
	}

	async function deleteData() {
		if (!selectedId || !confirm('Delete this add-on?')) return;
		try {
			const res = await fetch(`${API_URL}/${selectedId}`, {
				method: 'DELETE',
				headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF_TOKEN },
				credentials: 'same-origin',
			});
			const json = await res.json();
			if (json.success) {
				clearForm();
				await loadData();
			} else {
				alert(json.message || 'Failed to delete');
			}
		} catch (e) {
			alert('Error: ' + e.message);
		}
	}

	daysRow.addEventListener('click', e => {
		const btn = e.target.closest('.day-btn');
		if (btn) btn.classList.toggle('active');
	});

	btnAdd.addEventListener('click', saveData);
	btnUpdate.addEventListener('click', saveData);
	btnDelete.addEventListener('click', deleteData);

	loadData();
};
