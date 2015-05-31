<?php
    $id         = (isset($host[$items['id']][$label['id']]['id']) ? $host[$items['id']][$label['id']]['id'] : null);
    $used       = $helper->getUsedMetas($id , $metas, $items['id']);
    $label_text = (isset($host[$items['id']][$label['id']]['label']) && $host[$items['id']][$label['id']]['label'] != '' ? $host[$items['id']][$label['id']]['label'] : false);
    $label_id   = (isset($host[$items['id']][$label['id']]['id']) ? $host[$items['id']][$label['id']]['id'] : '');
?>

@if($label_text)
    <div class="chat-msg-item riiinglink linked <?php echo ($used ? 'used' : ''); ?>">
        <div class="chat-msg-content chat-msg-host bg-<?php echo ($used ? 'activated' : 'grey'); ?>">
            <label class="text-left">{{ trans('label.label_'.$label['id']) }}</label>
            <p>{{ $label_text }}</p>
        </div>
        <div class="chat-msg-switch chat-switch-host">
            <label class="switch switch-sm">
                <input type="checkbox" name="metas[{{$items['id']}}][{{$label['id']}}]" <?php echo ($used ? 'checked="checked"' : ''); ?> value="{{ $label_id }}">
                <span></span>
            </label>
        </div>
        <span class="clearfix"></span>
    </div>
@endif