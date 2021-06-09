<?php

include 'helpers.php';

class Module
{
    private $moduleId;
    private $moduleCode;
    private $module;
    private $professorIds = [];


    function __construct($moduleId, $moduleCode, $module, $professorIds)
    {
        $this->moduleId = $moduleId;
        $this->moduleCode = $moduleCode;
        $this->module = $module;
        $this->professorIds = $professorIds;
    }

    function getModuleId()
    {
        return $this->moduleId;
    }

    function getModuleCode()
    {
        return $this->moduleCode;
    }

    function getModuleName()
    {
        return $this->module;
    }

    function getRandomProfessorId()
    {
        return $this->professorIds[(int)(count($this->professorIds) * random())];
    }
}
