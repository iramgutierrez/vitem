    @if ($name)
        {{ Form::label($name, $label) }}
    @endif
    @if(isset($attributes['addon-first']) || isset($attributes['addon-last']))
    	<div class="input-group col-md-12">
    	@if(isset($attributes['addon-first']))
	    	<span class="input-group-addon">{{ $attributes['addon-first'] }}</span>
    	@endif	
    @endif
    {{ $control }}
     @if(isset($attributes['addon-first']) || isset($attributes['addon-last']))
    	@if(isset($attributes['addon-last']))
	    	<span class="input-group-addon">{{ $attributes['addon-last'] }}</span>
    	@endif	
    	</div>
    @endif
    @if ($error)
        <p class="error_message">{{ $error }}</p>
    @endif