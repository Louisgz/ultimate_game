<?php
session_start();


class Magicien extends Perso
{
    private $gotManaDate;

    public function sleep($persoToAttack)
    {
        $now = time();
        $dataDate = $this->getGotManaDate();
        echo $dataDate;

        $now = time();
        $timeSince = $now - $_SESSION['time_started'];
        $remainingSeconds = $_SESSION['countdown'] - $timeSince;

        if (!isset($_SESSION['countdown']) || $remainingSeconds <= 0) {
            $_SESSION['countdown'] = 5;
            $_SESSION['time_started'] = time();
            $persoToAttack->setIsSleeping(true);
        }
    }

    /**
     * @return mixed
     */
    public function getGotManaDate()
    {
        return $this->gotManaDate;
    }

    /**
     * @param mixed $gotManaDate
     */
    public function setGotManaDate($gotManaDate)
    {
        $this->gotManaDate = $gotManaDate;
    }
}