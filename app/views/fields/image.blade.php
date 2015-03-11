    
    {{ Form::label($name, $label ) }}
    <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
            <img src="{{ $value }}" alt="" />
        </div>
        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
        <div>
            <span class="btn btn-white btn-file">
            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Seleccionar imagen</span>
            <span class="fileupload-exists"><i class="fa fa-undo"></i> Cambiar</span>
                {{ $control }}
            </span>
            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Eliminar</a>
        </div>
    </div>
    @if ($error)
        <p class="error_message">{{ $error }}</p>
    @endif