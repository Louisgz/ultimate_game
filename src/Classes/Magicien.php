<?php
session_start();


class Magicien extends Perso
{
    private $gotManaDate;

    public function makeSleep($persoToAttack)
    {
        $now = time();
        $dataDate = $this->getGotManaDate();
        echo $dataDate;

        $now = time();
        $timeSince = $now - $_SESSION['time_started'];
        $remainingSeconds = $_SESSION['countdown'] - $timeSince;
        echo $remainingSeconds;
        if (!isset($_SESSION['countdown']) || $remainingSeconds <= 0) {
            $_SESSION['countdown'] = 120;
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
