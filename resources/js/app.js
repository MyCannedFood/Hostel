import './bootstrap';

// Calendar interactivity: date selection, range highlighting, and summary updates
document.addEventListener('DOMContentLoaded', () => {
	const container = document.querySelector('.calendar-container');
	if (!container) return;

	const dayEls = Array.from(container.querySelectorAll('.day'));
	const summaryItems = Array.from(document.querySelectorAll('.summary-inputs .summary-item'));
	const checkInStrong = summaryItems[0]?.querySelector('strong');
	const checkOutStrong = summaryItems[1]?.querySelector('strong');
	const nightsIndicator = document.querySelector('.nights-indicator');

	let checkIn = null;
	let checkOut = null;

	function parseYMD(ymd) {
		if (!ymd) return null;
		const parts = ymd.split('-').map(Number);
		return new Date(parts[0], parts[1] - 1, parts[2]);
	}

	function formatDDMMYYYY(date) {
		const d = String(date.getDate()).padStart(2, '0');
		const m = String(date.getMonth() + 1).padStart(2, '0');
		const y = date.getFullYear();
		return `${d}/${m}/${y}`;
	}

	function clearSelection() {
		dayEls.forEach(el => el.classList.remove('selected', 'in-range', 'in-range-start', 'in-range-end'));
	}

	function updateRangeClasses() {
		clearSelection();
		if (!checkIn) return;
		const inTime = checkIn.getTime();
		const outTime = checkOut ? checkOut.getTime() : null;

		dayEls.forEach(el => {
			const dateStr = el.dataset.date;
			if (!dateStr) return;
			const d = parseYMD(dateStr);
			const t = d.getTime();
			if (outTime) {
				if (t >= inTime && t <= outTime) {
					el.classList.add('in-range');
					el.classList.add('selected');
				}
				if (t === inTime) el.classList.add('in-range-start');
				if (t === outTime) el.classList.add('in-range-end');
			} else {
				// Single selected day (only checkIn)
				if (t === inTime) {
					el.classList.add('selected');
					el.classList.add('in-range-start');
				}
			}
		});
	}

	function updateSummary() {
		if (checkIn) checkInStrong && (checkInStrong.textContent = formatDDMMYYYY(checkIn));
		else checkInStrong && (checkInStrong.textContent = '--/--/----');

		if (checkOut) checkOutStrong && (checkOutStrong.textContent = formatDDMMYYYY(checkOut));
		else checkOutStrong && (checkOutStrong.textContent = '--/--/----');

		if (checkIn && checkOut) {
			const nights = Math.round((checkOut - checkIn) / (1000 * 60 * 60 * 24));
			if (nightsIndicator) nightsIndicator.textContent = `${nights} Night${nights > 1 ? 's' : ''}`;
		}
	}

	function onDayClick(e) {
		const el = e.currentTarget;
		if (el.classList.contains('empty') || el.classList.contains('unavailable')) return;
		const dateStr = el.dataset.date;
		if (!dateStr) return;
		const clicked = parseYMD(dateStr);

		// If no checkIn or both set, start a new selection
		if (!checkIn || (checkIn && checkOut)) {
			checkIn = clicked;
			checkOut = null;
		} else {
			// checkIn exists but no checkOut
			if (clicked.getTime() < checkIn.getTime()) {
				// clicked before checkIn -> move checkIn
				checkIn = clicked;
			} else if (clicked.getTime() === checkIn.getTime()) {
				// same day -> single-night selection
				checkOut = new Date(checkIn.getTime());
			} else {
				checkOut = clicked;
			}
		}

		updateRangeClasses();
		updateSummary();
	}

	dayEls.forEach(el => {
		el.addEventListener('click', onDayClick);
	});

	// Responsiveness: compact layout on narrow viewports
	function onResize() {
		const wrap = document.querySelector('.calendar-page');
		if (!wrap) return;
		if (window.innerWidth < 720) wrap.classList.add('compact-calendar');
		else wrap.classList.remove('compact-calendar');
	}

	window.addEventListener('resize', onResize);
	onResize();
});
