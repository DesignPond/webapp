<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" id="filters">
            <div class="panel-body">
                <div class="col-md-8">

                    <form id="filterChange" action="{{ Request::url() }}" method="post">
                        <select id="orderFilter" style="width:130px;" name="order" class="selectpicker">
                            <option value="">Ordre</option>
                            <option value="created_at">Plus récent</option>
                            <option value="last_name">Alphabétique</option>
                        </select>

                        <select class="selectpicker" style="width:190px;" name="label">
                            <option data-filter="*" value="">Filtrer par label</option>
                            <option data-filter=".famille" value="created_at">Famille</option>
                            <option data-filter=".professionnel" value="last_name">Professionnel</option>
                        </select>
                    </form>

{{--                        <select class="selectpicker" style="width:130px;" name="export">
                            <option data-filter="*" value="">Exporter</option>
                            <option data-filter=".famille" value="created_at">Famille</option>
                            <option data-filter=".professionnel" value="last_name">Professionnel</option>
                        </select>--}}
                </div><!-- /.col-lg-6 -->

                <div class="col-md-4">
                    <input type="text" id="quicksearch" class="form-control" placeholder="Rechercher...">
                </div><!-- /.col-lg-6 -->

            </div>
        </div>
    </div>
</div>