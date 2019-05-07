<?php
namespace App\Commands;

use App\Entities\User;
use App\Entities\UserText;
use App\Readers\UserReader;
use App\Readers\UserTextReader;

class CountAverageLineCount implements ICommand
{
    /**
     * @var UserReader
     */
    protected $userReader;

    /**
     * @var UserTextReader
     */
    protected $usersTextsReader;

    /**
     * @var string
     */
    protected $lastOutput;


    public function setUserReader(UserReader $userReader)
    {
        $this->userReader = $userReader;
    }

    public function setUsersTextsReader(UserTextReader $userTextReader)
    {
        $this->usersTextsReader = $userTextReader;
    }

    public function getCommandName(): string
    {
        return "countAverageLineCount";
    }


    public function execute():bool
    {
        $this->lastOutput = $this->output = "user name : avg count\n";;

        $users = $this->userReader->getUsers();

        /**
         * @var User $user
         */
        foreach ($users as $user) {
            $userTexts = $this->usersTextsReader->getUserTexts($user);
            $lines = 0;

            /**
             * @var UserText $userText
             */
            foreach ($userTexts as $userText)
                $lines += substr_count($userText->getText(), "\n");

            if (count($userTexts) != 0)
                $avg =  $lines/count($userTexts);
            else
                $avg = " not available";


            $this->lastOutput .= $user->getName() . " : " . $avg . "\n";
        }

        return true;
    }

    public function getOutput(): string
    {
        return $this->lastOutput;
    }

}