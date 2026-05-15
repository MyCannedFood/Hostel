<div class="selection-bottom-bar">
    <div class="bottom-bar-container">
        <div class="bottom-bar-info">
            <div class="info-row">
                <span class="info-label">{{ $label ?? 'Selected' }}</span>
                <span class="info-separator">:</span>
                <span class="info-value selected-value">{{ $title ?? 'Select Your Room' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ $totalLabel ?? 'Total' }}</span>
                <span class="info-separator">:</span>
                <span class="info-value total-value">{{ $value ?? 'IDR 0' }}</span>
            </div>
        </div>
        <div class="bottom-bar-actions">
            <a href="{{ $backUrl ?? '#' }}" class="btn-back">{{ $backText ?? 'Back To Rooms' }}</a>
            <a href="{{ $continueUrl ?? '#' }}" class="btn-continue">{{ $continueText ?? 'Continue To Details' }}</a>
        </div>
    </div>
</div>