<?php
namespace App\Commands;


use App\Entities\UserText;
use App\Readers\UserReader;
use App\Readers\UserTextReader;
use App\Entities\User;

class ReplaceDates implements ICommand
{
    /**
     * @var UserReader
     */
    protected $userReader;

    /**
     * @var UserTextReader
     */
    protected $usersTextReader;

    /**
     * @var string
     */
    protected $output;

    public function setUserReader(UserReader $userReader)
    {
        $this->userReader = $userReader;
    }

    public function setUsersTextsReader(UserTextReader $userTextReader)
    {
        $this->usersTextReader = $userTextReader;
    }

    public function getCommandName(): string
    {
        return "replaceDates";
    }

    public function execute(): bool
    {
        $this->output = "user name : replaces count\n";

        $users = $this->userReader->getUsers();

        /**
         * @var User $user
         */
        foreach ($users as $user) {
            $userTexts = $this->usersTextReader->getUserTexts($user);
            $count = 0;

            /**
             * @var UserText $userText
             */
            foreach ($userTexts as $userText) {
                $text = $userText->getText();
                $matches = [];
                preg_match_all("/[0-9]{2}\/[0-9]{2}\/[0-9]{2}/", $text, $matches, PREG_SET_ORDER);

                if (count($matches) > 0) {
                    $count += count($matches);

                    foreach ($matches as $match) {
                        $date = \DateTime::createFromFormat("d/m/y", $match[0]);
                        $text = str_replace($match[0], $date->format("m-d-Y"), $text);

                    }

                    file_put_contents($userText->getPathToFile(), $text);
                }
            }


            $this->output .= $user->getName() . " : " . $count . "\n";
        }

        return true;
    }

    public function getOutput(): string
    {
        return $this->output;
    }

}