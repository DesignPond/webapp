<nav class="navbar nav-frontend">
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-xs-12">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#"><img style="display: block;width: 200px;" alt="Riiingme" src="{{ asset('frontend/images/logo.svg') }}"></a>
                    </div>
                </div>
                <div class="col-md-7 col-xs-12">

                    {!! Form::open(array( 'method' => 'POST', 'id'  => 'homeLogin', 'url'  => array('auth/login'))) !!}

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group has-feedback">
                                <input required type="email" name="email" placeholder="{{ trans('message.youremail') }}" autocomplete="off" class="form-control" />
                                <span class="fa fa-envelope form-control-feedback text-muted"></span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group has-feedback">
                                <input required type="password" name="password" placeholder="{{ trans('message.yourpassword') }}" class="form-control" />
                                <span class="fa fa-lock form-control-feedback text-muted"></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group has-feedback">
                                <button type="submit" class="btn btn-primary">Go!</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <input type="checkbox" name="cookie" value="1" /> &nbsp;{{ trans('message.rememberme') }}
                        </div>
                        <div class="col-md-7">
                            <a href="{{ url('password/email') }}" class="text-muted">{{ trans('message.lostpassword') }}?</a>
                        </div>
                    </div>


                    {!! Form::close() !!}

                </div>
            </div>

        </div>
    </div><!-- end of all wrapper -->
</nav>