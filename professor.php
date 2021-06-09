<?php


class Professor
{
    private $professorId;
    private $professorName;

    function __construct($professorId, $professorName)
    {
        $this->professorId = $professorId;
        $this->professorName = $professorName;
    }

    function getProfessorId()
    {
        return $this->professorId;
    }

    function getProfessorName()
    {
        return $this->professorName;
    }
}
