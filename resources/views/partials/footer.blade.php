<!-- Footer -->
<footer id="footer" class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <ul class="nav nav-footer">
                    <?php $locale = \Session::get('locale'); ?>
                    <li class="<?php echo (!isset($locale) || $locale == 'fr' ? 'active' : ''); ?>">
                        <a href="{{ url('setlang/fr') }}">Français</a>
                    </li>
                    <li class="<?php echo ($locale == 'en' ? 'active' : ''); ?>">
                        <a href="{{ url('setlang/en') }}">English</a>
                    </li>
                </ul>
            </div><!-- end of copyrights -->
            <div class="col-md-6 col-xs-12 text-right">
                <ul class="nav nav-footer">
                    <li><a href="#" title="Terms of Use">{{ trans('menu.conditions') }}</a></li>
                    <li><a href="#" title="Privacy Policy">{{ trans('menu.confiential') }}</a></li>
                </ul><!-- end of terms -->
            </div>
        </div><!-- end of row -->
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <hr/><p>{{ trans('menu.droits') }}<strong> &copy; RiiingMe 2015</strong></p>
            </div>
        </div>
    </div><!-- end of container -->
</footer><!-- end of footer -->