@foreach($changes as $groupe_id => $groupe)
    @if(isset($groupes_titres[$groupe_id] ))
        <h4 style="color: #000; margin: 5px 0 10px 0; line-height: 18px; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
            {{ $groupes_titres[$groupe_id] }}
        </h4>
        <ul style="margin-left: 5px;padding-left: 5px;margin-right: 30px;">
            @foreach($groupe as $type_id => $label)
                <li style="color: #484848; line-height: 16px; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                    <strong>{{ $types[$type_id] }} :</strong> {{ $label }}
                </li>
            @endforeach
        </ul>
    @endif
@endforeach