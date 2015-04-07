<?php
    $id         = (isset($host[$groupe_id][$label]['id']) ? $host[$groupe_id][$label]['id'] : null);
    $used       = $helper->getUsedMetas($id , $metas, $groupe_id);
    $label_text = (isset($host[$groupe_id][$label]['label']) && $host[$groupe_id][$label]['label'] != '' ? $host[$groupe_id][$label]['label'] : false);
    $label_id   = (isset($host[$groupe_id][$label]['id']) ? $host[$groupe_id][$label]['id'] : '');
?>

@if($label_text)
    <div class="chat-msg-item riiinglink linked <?php echo ($used ? 'used' : ''); ?>">
        <div class="chat-msg-content chat-msg-host bg-<?php echo ($used ? 'activated' : 'grey'); ?>">
            <label class="text-left">{{ $types[$label] }}</label>
            <p>{{ $label_text }}</p>
        </div>
        <div class="chat-msg-switch chat-switch-host">
            <label class="switch switch-sm">
                <input type="checkbox" name="metas[{{$groupe_id}}][{{$label}}]" <?php echo ($used ? 'checked="checked"' : ''); ?> value="{{ $label_id }}">
                <span></span>
            </label>
        </div>
        <span class="clearfix"></span>
    </div>
@endif