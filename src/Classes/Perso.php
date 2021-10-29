<?php

class Perso
{
    private $pv = 100;
    private $force;
    private $defense;
    private $attack;
    private $id;

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

    public function deleteSelectedPerso($id){
        $bdd = PDOManager::getBdd();
        $destroy = "DELETE FROM `persos` WHERE id=?";
        $request = $bdd -> prepare($destroy);
        $request -> execute(array($id));
    }

    public function attack($persoToAttack)
    {
        $persoToAttack->setPv($persoToAttack->getPv - (
            $persoToAttack->getDefense() > $this->getAttack() ? 0 : $persoToAttack->getDefense() - $this->getAttack()
            )
        );
    }

    public function createNewPerso($type, $name){
        echo 'test';
        $VIE_PERSO = 100;
        $FORCE_PERSO = self::getRandomForce($type);
        $DEFENSE_PERSO = self::getRandomDefense($type);
        $ID_PERSO = uniqid();
        $bdd = PDOManager::getBdd();

        $insert = "INSERT INTO persos (`type`, `name`, `force`, `pv`, `defense`, `id`) VALUES (:type, :name, :force, :pv, :defense, :id)";
        $request = $bdd->prepare($insert);
        $request->execute(array(
            'type'=> $type,
            'name'=> $name,
            'force'=> $FORCE_PERSO,
            'pv'=> $VIE_PERSO,
            'defense'=> $DEFENSE_PERSO,
            'id'=> $ID_PERSO
        ));
    }

    private function getRandomForce($type) {
        if($type === 'magicien'){
            return rand(0, 10);
        } else{
            return rand(20, 40);
        }
    }

    private function getRandomDefense($type) {
        if($type === 'magicien'){
            return 0;
        } else{
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
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * @param mixed $attack
     */
    public function setAttack($attack)
    {
        $this->attack = $attack;
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
}