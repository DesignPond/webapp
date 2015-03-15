@extends('layouts.app')
@section('content')

    <div class="center-block mt-xl wd-xl">
        <!-- START panel-->
        <div class="panel panel-grey">
            <div class="panel-heading text-center">
                <a href="{{ url('/') }}">
                    <img style="width: 70%;" src="{{ asset('frontend/images/logo.svg') }}" alt="Image" class="center-block img-rounded" />
                </a>
            </div>
            <div class="panel-body">
                <p class="text-center pv text-bold">Créer un compte </p>

                <form class="mb-lg" role="form" method="POST" action="/auth/register">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div role="tabpanel">
                        <?php $company = Input::old('company',null);  ?>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li <?php echo (!$company ? 'class="active"' : ''); ?>>
                                <a rel="private" href="#private" aria-controls="private" role="tab" data-toggle="tab">Compte privé</a>
                            </li>
                            <li <?php echo ($company ? 'class="active"' : ''); ?>>
                                <a rel="company" href="#company" aria-controls="company" role="tab" data-toggle="tab">Entreprise/Association</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane <?php echo (!$company ? 'active' : ''); ?>" id="private">
                                <div class="form-group has-feedback">
                                    <input value="{{ Input::old('first_name') }}" type="text" name="first_name" placeholder="Prénom" class="form-control" />
                                    <span class="fa fa-quote-left form-control-feedback text-muted"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <input value="{{ Input::old('last_name') }}" type="text" name="last_name" placeholder="Nom" class="form-control" />
                                    <span class="fa fa-quote-right form-control-feedback text-muted"></span>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane <?php echo ($company ? 'active' : ''); ?>" id="company">
                                <div class="form-group has-feedback">
                                    <input type="text" value="{{ Input::old('company') }}" name="company" placeholder="Nom de l'entreprise/association" class="form-control" />
                                    <span class="fa fa-quote-right form-control-feedback text-muted"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p><hr /></p>
                    <div class="form-group has-feedback">
                        <?php
                            $session_email = Session::get('email');
                            $input_email   = Input::old('email', null);

                            $email = (!empty($session_email) ? $session_email: $input_email);
                        ?>
                        <input required type="email" name="email" value="{{ $email or '' }}" placeholder="Email" class="form-control" />
                        <span class="fa fa-envelope form-control-feedback text-muted"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input required type="password" value="" name="password" placeholder="Mot de passe" class="form-control" />
                        <span class="fa fa-lock form-control-feedback text-muted"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input required type="password" value="" name="password_confirmation" placeholder="Confirmer le mot de passe" class="form-control" />
                        <span class="fa fa-lock form-control-feedback text-muted"></span>
                    </div>
                    <p><hr /></p>
                    <div class="clearfix">
                        <div class="checkbox c-checkbox mt0">
                            <label>
                                <input required="" type="checkbox" value="1" name="accept" />
                                <span class="fa fa-check"></span>
                               <p>J'accepte les <a href="#">Conditions d'utilisation</a> de RiiingMe</p>
                            </label>
                        </div>
                    </div>

                    <?php
                        $session_id = Session::get('invite_id');
                        $input_id   = Input::old('invite_id', null);
                        $user_type  = Input::old('user_type', 'private');

                        $invite_id = (!empty($session_id) ? $session_id: $input_id);
                    ?>
                    @if(isset($invite_id) && !empty($invite_id))
                        <input type="hidden" value="{{ $invite_id or '' }}" name="invite_id">
                    @endif

                    <input type="hidden" value="{{ $user_type }}" name="user_type" id="user_type">

                    <button type="submit" class="btn btn-block btn-primary mt-lg">Créer le compte</button>

                </form>
                <p class="pt-lg text-center">Déjà inscrit?</p>
                <a href="{{ url('auth/login') }}" class="btn btn-block btn-info"><strong>Login</strong></a>
            </div>
        </div>
        <!-- END panel-->
    </div>

@stop