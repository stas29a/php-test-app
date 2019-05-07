<?php
namespace App\Commands;

use App\Entities\UserText;
use App\Readers\UserReader;
use App\Readers\UserTextReader;

interface ICommand
{
    /**
     * @param UserReader $userReader
     * @return mixed
     */
    public function setUserReader(UserReader $userReader);

    /**
     * @param UserTextReader $userTextReader
     * @return mixed
     */
    public function setUsersTextsReader(UserTextReader $userTextReader);

    /**
     * @return string
     */
    public function getCommandName(): string;


    /**
     * @return bool
     */
    public function execute(): bool;

    /**
     * @return string
     */
    public function getOutput(): string ;
}