@if( $errors->has() || Session::has('status'))

    <?php $class = ($errors->has() ? 'warning' : Session::get('status')); ?>
    <div class="alert alert-dismissable alert-{{ $class }}">

            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            @foreach($errors->all() as $message)
                <p>{{ $message }}</p>
            @endforeach

            @if(Session::has('message'))
                {{ Session::get('message') }}
            @endif

    </div>

@endif