<div class="panel panel-default">
    <div class="panel-heading panel-small">Tags</div>
    <div class="panel-body">
        <ul id="myTags" data-id="{{ $ringlink['id'] }}">
            @if(!$tags->isEmpty())
                @foreach($tags as $tag)
                    <li>{{ $tag->title }}</li>
                @endforeach
            @endif
        </ul>
    </div>
</div>