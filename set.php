<?php

class Set
{
    private $classId;
    private $groupId;
    private $moduleId;
    private $professorId;
    private $timeslotId;
    private $roomId;

    function __construct($classId, $groupId, $moduleId)
    {
        $this->classId = $classId;
        $this->moduleId = $moduleId;
        $this->groupId = $groupId;
    }

    // function initSet($classId, $groupId, $moduleId)
    // {
    //     $this->classId = $classId;
    //     $this->moduleId = $moduleId;
    //     $this->groupId = $groupId;
    // }

    function addProfessor($professorId)
    {
        $this->professorId = $professorId;
    }

    function addTimeslot($timeslotId)
    {
        $this->timeslotId = $timeslotId;
    }

    function setRoomId($roomId)
    {
        $this->roomId = $roomId;
    }

    function getClassId()
    {
        return $this->classId;
    }

    function getGroupId()
    {
        return $this->groupId;
    }

    function getModuleId()
    {
        return $this->moduleId;
    }

    function getProfessorId()
    {
        return $this->professorId;
    }

    function getTimeslotId()
    {
        return $this->timeslotId;
    }

    function getRoomId()
    {
        return $this->roomId;
    }
}
