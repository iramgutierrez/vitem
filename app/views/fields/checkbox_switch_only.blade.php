    
    <div class="input-group text-center">
        <span class="input-group-btn bsSwitch-input">
            {{ $control }}
        </span>
    </div>
    @if ($error)
        <p class="error_message">{{ $error }}</p>
    @endif