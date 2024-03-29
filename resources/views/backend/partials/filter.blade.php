<div class="col-md-12">
    <div class="panel panel-default" id="filters">
        <div class="panel-body">
            <div class="col-md-5 col-xs-12">

                <form id="filterChange" action="{{ url('user') }}" method="post">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <select id="orderFilter" class="selectpicker" name="orderBy">
                        <option value="">{{ trans('menu.order') }}</option>
                        <option value="created_at">{{ trans('menu.recent') }}</option>
                        <option value="last_name">{{ trans('menu.alpha') }}</option>
                    </select>

                    <select id="selectFilter" class="selectpicker bg-info" name="tag">
                        <option value="">{{ trans('menu.filtertag') }}</option>
                        @if(!empty($tags))
                            @foreach($tags as $tag_id => $tag)
                                <option <?php echo (isset($filtres['tag']) && $filtres['tag'] == $tag_id  ? 'selected' : ''); ?> value="{{ $tag_id }}">{{ $tag }}</option>
                            @endforeach
                        @endif
                    </select>
                    &nbsp;<a href="{{ Request::url() }}" class="btn btn-primary collapseButton">{{ trans('menu.all') }}</a>
                </form>

            </div><!-- /.col-lg-6 -->
            <div class="col-md-4 col-xs-12">
                <form id="filterSearch" action="{{ url('user') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control search-input" placeholder="{{ trans('action.search') }}...">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">{{ trans('action.ok') }}</button>
                        </span>
                    </div><!-- /input-group -->
                </form>
            </div><!-- /.col-lg-6 -->
            <div class="col-md-3 col-xs-12">
                @if($riiinglinks->count() > 0)
                    <a href="{{ url('export') }}" class="btn btn-success pull-right">{{ trans('menu.export') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
