<div class="selection-bottom-bar">
    <div class="bottom-bar-container">
        <div class="bottom-bar-title">{{ $title ?? 'Select Your Room' }}</div>
        <div class="bottom-bar-row">
            <div class="total-label">{{ $label ?? 'EST.Total' }}</div>
            <div class="total-value">{{ $value ?? 'IDR 0' }}</div>
        </div>
        <div class="bottom-bar-actions">
            <a href="{{ $backUrl ?? '#' }}" class="btn-back">{{ $backText ?? 'Back' }}</a>
            <a href="{{ $continueUrl ?? '#' }}" class="btn-continue">{{ $continueText ?? 'Continue' }}</a>
        </div>
    </div>
</div>
