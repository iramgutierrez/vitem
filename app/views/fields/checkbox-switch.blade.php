    {{ Form::label($name, $label ) }}
    <div class="input-group col-lg-12">
        <span class="input-group-addon">
            {{ $control }}
        </span>
        <label class="form-control">{{ $label_value }}</label>
    </div>
    @if ($error)
        <p class="error_message">{{ $error }}</p>
    @endif