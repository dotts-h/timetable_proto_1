<?php

include_once 'room.php';
include_once 'professor.php';
include_once 'module.php';
include_once 'group.php';
include_once 'timeslot.php';
include_once 'helpers.php';
include_once 'individual.php';
include_once 'genetic_algorithm.php';


class Timetable
{
    private $rooms;
    private $professors;
    private $modules;
    private $groups;
    private $timeslots;
    private $sets = [];

    private $numSets = 0;

    function __construct()
    {
        //
    }

    function copyTimetable(Timetable $tt)
    {
        $this->rooms = $tt->getGroups();
        $this->professors = $tt->getProfessors();
        $this->modules = $tt->getModules();
        $this->groups = $tt->getGroups();
        $this->timeslots = $tt->getTimeslots();
    }

    function getGroups()
    {
        return $this->groups;
    }

    function getTimeslots()
    {
        return $this->timeslots;
    }

    function getModules()
    {
        return $this->modules;
    }

    function getProfessors()
    {
        return $this->professors;
    }


    function addRoom($roomId, $roomName, $capacity)
    {
        $this->rooms = [$roomId => new Room($roomId, $roomName, $capacity)];
    }

    function addProfessor($professorId, $professorName)
    {
        $this->professors = [$professorId, new Professor($professorId, $professorName)];
    }

    function addModule($moduleId, $moduleCode, $module, $professorIds)
    {
        $this->modules = [$moduleId, new Module($moduleId, $moduleCode, $module, $professorIds)];
    }

    function addGroup($groupId, $groupSize, $moduleIds)
    {
        $this->groups = [$groupId, new Group($groupId, $groupSize, $moduleIds)];
        $this->numSets = 0;
    }

    function addTimeslot($timeslotId, $timeslot)
    {
        $this->timeslots = [$timeslotId, new Timeslot($timeslotId, $timeslot)];
    }


    function createSets(Individual $individual)
    {
        // $sets = new Set();

        $chromosome = $individual->getChromosome();
        $chromosomePos = 0;
        $setIndex = 0;

        foreach ($this->getGroupsAsArray() as $group) {
            $moduleIds = $group->getModuleIds();
            foreach ($moduleIds as $moduleId) {
                $sets[$setIndex] = new Set($setIndex, $group->getGroupId(), $moduleId);

                $sets[$setIndex]->addTimeslot($chromosome[$chromosomePos]);
                $chromosomePos++;

                $sets[$setIndex]->setRoomId($chromosome[$chromosomePos]);
                $chromosomePos++;

                $sets[$setIndex]->addProfessor($chromosome[$chromosomePos]);
                $chromosomePos++;

                $setIndex++;
            }
        }

        $this->sets = $sets;
    }

    function getRoom($roomId)
    {
        if (!array_key_exists($roomId, $this->rooms)) {
            echo "Rooms doesn't contain key $roomId" . "<br>";
        }
        return $this->rooms[$roomId];
    }

    function getRooms()
    {
        return $this->rooms;
    }

    function getRandomRoom()
    {
        $roomsArray = array_values($this->rooms);
        $room = $roomsArray[(int) (count($roomsArray) * random())];

        return $room;
    }

    function getProfressor($professorId)
    {
        return $this->professor[$professorId];
    }

    function getModule($moduleId)
    {
        return $this->module[$moduleId];
    }

    function getGroupModules($groupId)
    {
        $group = $this->groups[$groupId];
        return $group->getModuleIds();
    }

    function getGroup($groupId)
    {
        return $this->groups[$groupId];
    }

    function getGroupsAsArray()
    {
        return array_values($this->groups);
    }

    function getTimeslot($timeslotId)
    {
        return $this->timeslot[$timeslotId];
    }

    function getRandomTimeslot()
    {
        $timeslotArray = array_values($this->timeslots);
        $timeslot = $timeslotArray[(int) (count($timeslotArray) * random())];
        return $timeslot;
    }

    function getSets()
    {
        return $this->sets;
    }

    function getNumSets()
    {
        if ($this->numSets > 0) {
            return $this->numSets;
        }

        $numSets = 0;
        $groups = array_values($this->groups);
        var_dump($groups);

        foreach ($groups as $group) {
            $numSets += count($group->getModuleIds());
        }
        $this->numSets = $numSets;

        return $this->numSets;
    }


    function calcClashes()
    {
        $clashes = 0;

        foreach ($this->sets as $setA) {
            $roomCapacity = $this->getRoom($setA->getRoomId())->getRoomCapacity();
            $groupSize = $this->getGroup($setA->getGroupId())->getGroupSize();

            if ($roomCapacity < $groupSize) {
                $clashes++;
            }

            foreach ($this->sets as $setB) {
                if (
                    $setA->getRoomId() == $setB->getRoomId() &&
                    $setA->getTimeslotId() == $setB->getTimeslotId()
                ) {
                    $clashes++;
                    break;
                }
            }

            foreach ($this->sets as $setB) {
                if (
                    $setA->getProfessorId() == $setB->getProfessorId() &&
                    $setA->getTimeslot() == $setB->getTimeslot() &&
                    $setA->getClassId() != $setB->getClassId()
                ) {
                    $clashes++;
                    break;
                }
            }
        }

        return $clashes;
    }
}
