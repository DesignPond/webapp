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

@if(!$user->activated_at)
    <div class="alert alert-warning alert-dismissible" role="alert">
        <a href="{{ url('sendActivationLink') }}" class="btn btn-default pull-right">Renvoyer le lien</a>
        <h4><strong>Activation!</strong></h4>
        <p>Veuillez confirmer votre adresse email avec le lien qui vous à été envoyé.</p>
    </div>
@endif