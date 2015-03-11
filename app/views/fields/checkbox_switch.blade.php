    
    <div class="input-group col-lg-12">
        <span class="input-group-btn bsSwitch-input">
            {{ $control }}
        </span>
        <label class="form-control">{{ $label_value }}</label>
    </div>
    @if ($error)
        <p class="error_message">{{ $error }}</p>
    @endif