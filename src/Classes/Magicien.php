<?php
session_start();


class Magicien extends Perso
{
    private $gotManaDate;

    // public function sleep($persoToAttack)
    // {
    //     $now = time();
    //     $dataDate = $this->getGotManaDate();
    //     echo $dataDate;

    //     $now = time();
    //     $timeSince = $now - $_SESSION['time_started'];
    //     $remainingSeconds = $_SESSION['countdown'] - $timeSince;

    //     if (!isset($_SESSION['countdown']) || $remainingSeconds <= 0) {
    //         $_SESSION['countdown'] = 5;
    //         $_SESSION['time_started'] = time();
    //         
    //         echo ($now);
    //     }
    // }
    public function sleep($persoToAttack)
    {
        if ($persoToAttack->getIsSleeping() === false)
            if (!isset($_SESSION['active_count'])) {
                $_SESSION['active_count'] = 10;
                $_SESSION['time_started'] = time();
                $persoToAttack->setIsSleeping(true);
            }
        $now = time();
        $final_remain_time = $now - $_SESSION['time_started'];
        $remainingSeconds = abs($_SESSION['active_count'] - $final_remain_time);
        echo "There are $remainingSeconds seconds remaining.";
        $now = time();
        $dataDate = $this->getGotManaDate();
        echo $dataDate;
        if ($remainingSeconds < 1) {
            $persoToAttack->setIsSleeping(false);
            echo ("la cible se reveille");
        }
        if ($remainingSeconds > 1 && $persoToAttack->getIsSleeping() === true) {
            echo ("la cible dort");
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
