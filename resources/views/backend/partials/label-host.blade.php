<?php
    $used       = $helper->getUsedMetas($host[$groupe_id][$label]['id'], $metas,$groupe_id);
    $label_text = (isset($host[$groupe_id][$label]['label']) && $host[$groupe_id][$label]['label'] != '' ? $host[$groupe_id][$label]['label'] : false);
    $label_id   = (isset($host[$groupe_id][$label]['id']) ? $host[$groupe_id][$label]['id'] : '');
?>

@if($label_text)
    <div class="chat-msg-item riiinglink linked <?php echo ($used ? 'used' : ''); ?>">
        <div class="chat-msg-content bg-<?php echo ($used ? 'turquoise' : 'grey'); ?>">
            <label class="text-left">{{ $types[$label] }}</label>
            <p>{{ $label_text }}</p>
        </div>
        <div class="chat-msg-switch">
            <label class="switch switch-turquoise switch-sm">
                <input type="checkbox" name="metas[{{$groupe_id}}][]" <?php echo ($used ? 'checked="checked"' : ''); ?> value="{{ $label_id }}">
                <span></span>
            </label>
        </div>
        <span class="clearfix"></span>
    </div>
@endif