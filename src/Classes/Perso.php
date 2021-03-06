<?php

require('Magicien.php');
require('Guerrier.php');

class Perso
{
    private $pv = 100;
    private $force;
    private $defense;
    private $name;
    private $type;
    private $id;
    private $isSleeping;
    private $wakeDate;

    public function setWakeDate($wakeDate)
    {
        $this->wakeDate = $wakeDate;
    }

    public function __construct(array $data = array())
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            // One gets the setter's name matching the attribute.
            $method = 'set' . ucfirst($key);

            // If the matching setter exists
            if (method_exists($this, $method)) {
                // One calls the setter.
                $this->$method($value);
            }
        }
    }

    public function deleteSelectedPerso($id)
    {
        $bdd = PDOManager::getBdd();
        $destroy = "DELETE FROM `persos` WHERE id=?";
        $request = $bdd->prepare($destroy);
        $request->execute(array($id));
    }

    public function attack($persoToAttack)
    {

        if ($persoToAttack && $this->getWakeDate() < time()) {

            $bdd = PDOManager::getBdd();
            $newPv = $persoToAttack->getPv() - (
                $persoToAttack->getDefense() > $this->getForce() ? 0 : $this->getForce() - $persoToAttack->getDefense()
                );
            if ($newPv < 0) {
                $SQL_REQ = "DELETE FROM `persos` WHERE id = '" . $persoToAttack->getId() . "'";
            } else {
                $SQL_REQ = "UPDATE `persos`
                        SET pv = " . $newPv . "
                        WHERE id = '" . $persoToAttack->getId() . "'";
            }
            $request = $bdd->prepare($SQL_REQ);
            $request->execute();
        }
    }

    public function fallAsleep()
    {
        $now = time();
        $dateWakeUp = $now + 15;
        $bdd = PDOManager::getBdd();
        $updateSleep = "UPDATE `persos` SET wakeDate=" . $dateWakeUp . " where id = '" . $this->getId(). "'";
        $request = $bdd->prepare($updateSleep);
        $request->execute();
    }

    public function createNewPerso($type, $name)
    {
        $VIE_PERSO = 100;
        $FORCE_PERSO = self::getRandomForce($type);
        $DEFENSE_PERSO = self::getRandomDefense($type);
        $ID_PERSO = uniqid();
        $bdd = PDOManager::getBdd();

        $insert = "INSERT INTO persos (`type`, `name`, `force`, `pv`, `defense`, `id`, `wakeDate`) VALUES (:type, :name, :force, :pv, :defense, :id, :wakeDate)";
        $request = $bdd->prepare($insert);
        $request->execute(array(
            'type' => $type,
            'name' => $name,
            'force' => $FORCE_PERSO,
            'pv' => $VIE_PERSO,
            'defense' => $DEFENSE_PERSO,
            'id' => $ID_PERSO,
            'wakeDate' => time()
        ));
    }

    public function getSinglePerso($id)
    {
        $bdd = PDOManager::getBdd();
        $getPerso = "SELECT * FROM `persos` WHERE id=?";
        $request = $bdd->prepare($getPerso);
        $request->execute(array($id));
        $persoValues = $request->fetch(PDO::FETCH_ASSOC);
        if ($persoValues['type'] === 'magicien') {
            return new Magicien($persoValues);
        } else {
            return new Guerrier($persoValues);
        };
    }

    public function getAllPersos($playerId)
    {
        $bdd = PDOManager::getBdd();
        $getAllPersosQuery = "SELECT * FROM `persos`";
        $request = $bdd->query($getAllPersosQuery);
        $request->setFetchMode(PDO::FETCH_CLASS, 'Perso');
        return $request->fetchAll();
    }

    private function getRandomForce($type)
    {
        if ($type === 'magicien') {
            return rand(0, 10);
        } else {
            return rand(20, 40);
        }
    }

    private function getRandomDefense($type)
    {
        if ($type === 'magicien') {
            return 0;
        } else {
            return rand(10, 19);
        }
    }

    /**
     * @return int
     */
    public function getPv()
    {
        return $this->pv;
    }

    /**
     * @param int $pv
     */
    public function setPv($pv)
    {
        $this->pv = $pv;
    }

    /**
     * @return mixed
     */
    public function getForce()
    {
        return $this->force;
    }

    /**
     * @param mixed $force
     */
    public function setForce($force)
    {
        $this->force = $force;
    }

    /**
     * @return mixed
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * @param mixed $defense
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getIsSleeping()
    {
        return $this->isSleeping;
    }

    /**
     * @param mixed $isSleeping
     */
    public function setIsSleeping($isSleeping)
    {
        $this->isSleeping = $isSleeping;
    }

    /**
     * @return mixed
     */
    public function getWakeDate()
    {
        return $this->wakeDate;
    }

    /**
     * @param mixed $wakeDate
     */

}