<div class="well">
    <div class="row">
        <div class="col-md-12">
            <div class="checkbox">
                <label class="text-primary"><input id="partageCheckAll" class="partageCheckAll" data-who="{{ $who }}" type="checkbox">Tout sélectionner/desélectionner</label>
            </div>
            <hr/>
        </div>
    </div>

    <?php $GroupeTypes = [$all_groupe_type[1],$all_groupe_type[2]]; ?>

    <div id="partageMain">
        @include('backend.partage.labels', [ 'GroupeTypes' => $GroupeTypes, 'who' => $who, 'prive' => true ])
    </div>

</div>
