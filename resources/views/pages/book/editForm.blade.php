<div class="form-group">
    <div class="row">
        {!! Form::label('title', 'Title', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('title', null, ['required', 'class'=>'form-control']) !!}
            @if ($errors->has('title'))<p style="color:red;">{!!$errors->first('title')!!}</p>@endif
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('author', 'Author', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('authors[]', $authors, null,
                ['class'=>'form-control', 'multiple' => 'multiple', 'required']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('genre', 'Genre', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('categories[]', $categories, null,
                ['class'=>'form-control', 'multiple' => 'multiple', 'required']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('sinopsis', 'Sinopsis', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::textarea('sinopsis', null, ['required', 'class'=>'form-control']) !!}
            @if ($errors->has('sinopsis'))<p style="color:red;">{!!$errors->first('sinopsis')!!}</p>@endif
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('pageCount', 'Numbers of page', ['class'=>'col-sm-2 col-md-2 control-label']) !!}
        <div class="col-sm-10 col-md-10">
            {!! Form::text('pageCount', null, ['required', 'class'=>'form-control']) !!}
            @if ($errors->has('pageCount'))
                {!! Form::label('messageError', $errors->first('pageCount'), ['class'=>'control-label', 'style'=>'color:red;']) !!}
            @endif
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        {!! Form::label('image', 'Image', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-8">
            <!-- image-preview-filename input [CUT FROM HERE]-->
            <div class="input-group image-preview">
                <input type="text" class="form-control image-preview-filename" disabled="disabled">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-default image-preview-input">
                    <span class="glyphicon glyphicon-folder-open"></span>
                    <span class="image-preview-input-title">Browse</span>
                    <input type="file" accept="image/png, image/jpeg, image/gif, image/bmp" name="image"/>
                    <!-- rename it -->
                </div>
            </span>
            </div>
            <!-- /input-group image-preview [TO HERE]-->
        </div>

        <div class="col-sm-2">
            {!! Form::submit('Add', ['class'=>'btn btn-primary  col-sm-12']) !!}
        </div>
    </div>
    @if ($errors->has('image'))
        <div class="row">
            {!! Form::label('messageError', $errors->first('image'), ['class'=>'col-sm-offset-3 control-label', 'style'=>'color:red;']) !!}
        </div>
    @endif
    {{--</div>--}}
</div>
