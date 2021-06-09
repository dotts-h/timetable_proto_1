<?php

class Group
{
    private $groupId;
    private $groupSize;
    private $moduleIds = [];

    function __construct($groupId, $groupSize, $moduleIds)
    {
        $this->groupId = $groupId;
        $this->groupSize = $groupSize;
        $this->moduleIds = $moduleIds;
    }

    function getGroupId()
    {
        return $this->groupId;
    }

    function getGroupSize()
    {
        return $this->groupSize;
    }

    function getModuleIds()
    {
        return $this->moduleIds;
    }
}
