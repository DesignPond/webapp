@if( $errors->has() || Session::has('status'))

    <?php $class  = ($errors->has() ? 'warning' : Session::get('status')); ?>
    <?php $status = ( $class == 'danger' || $class == 'success' ? $class : 'warning' ); ?>

    <div class="alert alert-dismissable alert-{{ $status }}">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        @foreach($errors->all() as $message)
            <p>{{ $message }}</p>
        @endforeach

        @if(Session::has('message'))
            {{ Session::get('message') }}
        @endif

        @if( $class != 'danger' && $class != 'success' )
            {{ $class }}
        @endif

    </div>

@endif