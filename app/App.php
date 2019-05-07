<?php
namespace App;


use App\Commands\CountAverageLineCount;
use App\Commands\ICommand;
use App\Commands\ReplaceDates;
use App\Readers\UserReader;
use App\Readers\UserTextReader;

class App
{
    /**
     * @var UserReader
     */
    protected $usersReader;

    /**
     * @var UserTextReader
     */
    protected $usersTextsReader;

    /**
     * @var ICommand[]
     */
    protected $commands;

    /**
     * App constructor.
     * @param $separatorName
     * @param $usersFilePath
     * @param $usersTextsDir
     */
    public function __construct($separatorName, $usersFilePath, $usersTextsDir)
    {
        $this->usersReader = new UserReader($separatorName, $usersFilePath);
        $this->usersTextsReader = new UserTextReader($usersTextsDir);


        $avgLineCountCommand = new CountAverageLineCount();
        $avgLineCountCommand->setUserReader($this->usersReader);
        $avgLineCountCommand->setUsersTextsReader($this->usersTextsReader);

        $rplcDatesCommand = new ReplaceDates();
        $rplcDatesCommand->setUserReader($this->usersReader);
        $rplcDatesCommand->setUsersTextsReader($this->usersTextsReader);

        $this->commands[] = $avgLineCountCommand;
        $this->commands[] = $rplcDatesCommand;
    }

    public function execute(string $commandName)
    {
        foreach ($this->commands as $command)
        {

            if ($command->getCommandName() === $commandName)
            {

                $command->execute();
                echo $command->getOutput();
                echo "\n";

                return;
            }
        }

        echo "Unknown command given\n";
    }
}