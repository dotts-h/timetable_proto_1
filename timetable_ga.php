<?php

require_once 'timetable.php';


function initializeTimeTable()
{
    $tt = new Timetable();

    $tt->addRoom(1, "A1", 15);
    $tt->addRoom(2, "B1", 30);
    $tt->addRoom(4, "D1", 20);
    $tt->addRoom(5, "F1", 25);

    $tt->addTimeslot(1, "Mon 9:00 - 11:00");
    $tt->addTimeslot(2, "Mon 11:00 - 13:00");
    $tt->addTimeslot(3, "Mon 13:00 - !5:00");
    $tt->addTimeslot(4, "Tue 9:00 - 11:00");
    $tt->addTimeslot(5, "Tue 11:00 - 13:00");
    $tt->addTimeslot(6, "Tue 13:00 - 15:00");
    $tt->addTimeslot(7, "Wed 9:00 - 11:00");
    $tt->addTimeslot(8, "Wed 11:00 - 13:00");
    $tt->addTimeslot(9, "Wed 13:00 - 15:00");
    $tt->addTimeslot(10, "Thu 9:00 - 11:00");
    $tt->addTimeslot(11, "Thu 11:00 - 13:00");
    $tt->addTimeslot(12, "Thu 13:00 - 15:00");
    $tt->addTimeslot(13, "Fri 9:00 - 11:00");
    $tt->addTimeslot(14, "Fri 11:00 - 13:00");
    $tt->addTimeslot(15, "Fri 13:00 - 15:00");

    $tt->addProfessor(1, "P Smith");
    $tt->addProfessor(2, "E Mitchell");
    $tt->addProfessor(3, "R Williams");
    $tt->addProfessor(4, "A Thompson");

    $tt->addModule(1, "cs1", "Computer Science", [1, 2]);
    $tt->addModule(2, "en1", "English", [1, 3]);
    $tt->addModule(3, "ma1", "Math", [1, 2]);
    $tt->addModule(4, "ph1", "Physics", [3, 4]);
    $tt->addModule(5, "hi1", "History", [4]);
    $tt->addModule(6, "dr1", "Drama", [1, 4]);

    $tt->addGroup(1, 10, [1, 3, 4]);
    $tt->addGroup(2, 30, [2, 3, 5, 6]);
    $tt->addGroup(3, 18, [3, 4, 5]);
    $tt->addGroup(4, 25, [1, 4]);
    $tt->addGroup(5, 20, [2, 3, 5]);
    $tt->addGroup(6, 22, [1, 4, 5]);
    $tt->addGroup(7, 16, [1, 3]);
    $tt->addGroup(8, 18, [2, 6]);
    $tt->addGroup(9, 24, [1, 6]);
    $tt->addGroup(10, 25, [3, 4]);

    return $tt;
}


$tt = initializeTimeTable();

$ga = new GeneticAlgorithm(100, 0.01, 0.9, 2, 5);

$population = $ga->initPopulation($tt);

$ga->evalPopulation($population, $tt);

$generation = 1;

while (
    $ga->isTerminationConditionMetByGenerations($generation, 1000) == false &&
    $ga->isTerminationConditionMetByPopulation($population) == false
) {
    echo 'G' . $generation . " Best Fitness: " . $population->getFittest(0)->getFitness() . '<br>';

    $population = $ga->crossoverPopulation($population);

    $population = $ga->mutatePopulation($population, $tt);

    $ga->evalPopulation($population, $tt);

    $generation++;
}


$tt->createSets($population->getFittest(0));
echo '<br>';
echo "Solution found in " . $generation . " generations" . '<br>';
echo "Final solution fitness: " . $population->getFittest(0)->getFitness() . '<br>';
echo "Clashes: " . $tt->calcClashes() . '<br>';

$sets = $tt->getSets();
$setIndex = 1;

foreach ($sets as $bestSet) {
    echo "Set " . $setIndex . ':' . '<br>';
    echo "Module: " . $tt->getModule($bestSet->getModuleId())->getModuleName() . '<br>';
    echo "Group: " . $tt->getGroup($bestSet->getGroupId())->getGroupId() . '<br>';
    echo "Room: " . $tt->getRoom($bestSet->getRoomId())->getRoomNumber();
    echo "Professor: " . $tt->getProfessors($bestSet->getProfessorId())->getProfessorName() . '<br>';
    echo "Time: " . $tt->getTimeslot($bestSet->getTimeslotId())->getTimeslot() . '<br>';

    $setIndex++;
}
