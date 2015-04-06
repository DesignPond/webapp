<div class="col-md-12">
    <div class="panel panel-default" id="filters">
        <div class="panel-body">
            <div class="col-md-8">

                <form id="filterChange" action="{{ Request::url() }}" method="post">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <select id="orderFilter" style="width:130px;" class="selectpicker" name="orderBy">
                        <option value="">Ordre</option>
                        <option value="created_at">Plus récent</option>
                        <option value="last_name">Alphabétique</option>
                    </select>

                    <select id="selectFilter" class="selectpicker bg-info" style="width:190px;" name="tag">
                        <option value="">Filtrer par tag</option>
                        @if(!$user->user_tags->isEmpty())
                            @foreach($user->user_tags->unique() as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                            @endforeach
                        @endif
                    </select>
                    &nbsp;<a href="{{ Request::url() }}" class="btn btn-primary">Tous</a>
                </form>

            </div><!-- /.col-lg-6 -->
            <div class="col-md-4">
                <input type="text" id="quicksearch" class="form-control" placeholder="Rechercher...">
            </div><!-- /.col-lg-6 -->

        </div>
    </div>
</div>
