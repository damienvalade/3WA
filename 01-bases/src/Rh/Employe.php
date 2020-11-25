<?php

namespace Presentation\Rh;

use Exception;

/**
 * Cette classe permet de répresenter un employé de l'entreprise
 */
class Employe
{
    public string $firstName;
    public string $lastName;
    private int $age;

    /**
     * Permet de construire un employé
     *
     * @param string $firstName Le prénom de l'employé
     * @param string $lastName Le nom de famille de l'employé
     * @param int $age L'âge de l'employé
     */
    public function __construct(string $firstName, string $lastName, int $age)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
    }

    /**
     * @param int $age
     * @throws Exception
     */
    public function setAge(int $age)
    {
        if ($age > 70 || $age <= 18) {
            throw new Exception("L'âge d'un employé doit être un entier compris entre 18 et 70 ans inclus");
        }

        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * Permet de présenter les informations essentielles de l'employé
     */
    public function presentation()
    {
        var_dump("Je suis $this->firstName $this->lastName et j'ai $this->age ans");
    }
}