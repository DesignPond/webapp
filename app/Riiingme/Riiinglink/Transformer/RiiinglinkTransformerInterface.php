<?php namespace App\Riiingme\Riiinglink\Transformer;

interface RiiinglinkTransformerInterface
{
    public function transform($riiinglink);
    public function getUser($user_id);
    public function getName($user);
    public function getInvited($riiinglink);
    public function getTags($riiinglink);
    public function getHostLabels($riiinglink);
    public function userHasPeriodRange($user,$groupe);
    public function getInvitedLabels($riiinglink);
    public function getLabelItem($id);
    public function getLabels($data,$invited = null);
    public function getInvitedGroupLabels($group);
    public function getMetaLabelId($user_id,$metas);
}