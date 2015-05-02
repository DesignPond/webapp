@foreach($changes as $groupes => $groupe)
    <h4 style="color: #000; margin: 5px 0 10px 0; line-height: 18px; font-size: 14px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
        {{ $groupes_titres[$groupes] }}
    </h4>
    <ul style="margin-left: 5px;padding-left: 5px;margin-right: 30px;">
        @foreach($groupe as $type_id => $type)
            <li style="color: #484848; line-height: 16px; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                {{ $types[$type_id] }} {{ $type }}
            </li>
        @endforeach
    </ul>
@endforeach