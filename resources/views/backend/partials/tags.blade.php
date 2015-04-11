<div class="panel panel-default">
    <div class="panel-heading panel-small">Tags</div>
    <div class="panel-body" style="position: relative;">
        <ul id="myTags" data-id="{{ $ringlink['id'] }}">
            @if(!$tags->isEmpty())
                @foreach($tags as $tag)
                    <li>{{ $tag->title }}</li>
                @endforeach
            @endif
        </ul>
        <button id="tagging" class="btn btn-primary btn-sm" type="submit">ajouter</button>
    </div>
</div>