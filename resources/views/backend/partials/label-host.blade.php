<?php

// Label is passed
setlocale(LC_ALL, 'fr_FR.UTF-8');
$used = '';

// if we have a label in that group and some metas in that group test if this label is used those metas
if(isset($host[$groupe_id][$label]['id']) && isset($metas[$groupe_id]))
{
    $used = (in_array($host[$groupe_id][$label]['id'], $metas[$groupe_id]) ? true : false);
}

?>
@if( isset($host[$groupe_id][$label]['label']) && $host[$groupe_id][$label]['label'] != '')
    <div class="chat-msg-item riiinglink linked <?php echo ($used ? 'used' : ''); ?>">
        <div class="chat-msg-title bg-<?php echo ($used ? 'turquoise' : 'grey'); ?> text-left">
            {{ $types[$label] }}
        </div>
        <div class="chat-msg-content">
            @if(isset($host[$groupe_id][$label]['id']))
                <?php $label_name = ($label == 10 ? \Carbon\Carbon::parse($host[$groupe_id][$label]['label'])->formatLocalized('%d %B %Y') : $host[$groupe_id][$label]['label']); ?>
                {{ $label_name }}
            @endif
        </div>
        <div class="chat-msg-switch">
            <label class="switch switch-turquoise switch-sm">
                <input type="checkbox" name="metas[{{$groupe_id}}][]" <?php echo ($used ? 'checked="checked"' : ''); ?> value="{{ $host[$groupe_id][$label]['id'] or '' }}">
                <span></span>
            </label>
        </div>
        <span class="clearfix"></span>
    </div>
@endif