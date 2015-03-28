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
            <input required="" type="checkbox" value="1" name="accept" /><span class="fa fa-check"></span>
            <p>J'accepte les <a href="#">Conditions d'utilisation</a> de RiiingMe</p>
        </label>
    </div>
</div>

<?php
    $session_id = Session::get('invite_id');
    $input_id   = Input::old('invite_id', null);
    $invite_id  = (!empty($session_id) ? $session_id: $input_id);
?>

@if(isset($invite_id) && !empty($invite_id))
    <input type="hidden" value="{{ $invite_id or '' }}" name="invite_id">
@endif

<button type="submit" class="btn btn-block btn-primary mt-lg">Créer le compte</button>
