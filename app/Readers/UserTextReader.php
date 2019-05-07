<?php
namespace App\Readers;

use App\Entities\User;
use App\Entities\UserText;

class UserTextReader
{
    protected $basePath;

    /**
     * UserTextRepository constructor.
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getUserTexts(User $user): array
    {
        $result = [];

        foreach (glob($this->getFilesPattern($user)) as $fileName)
            $result[] = new UserText($user, $fileName);


        return $result;
    }


    //Private

    /**
     * @param User $user
     * @return string
     */
    private function getFilesPattern(User $user): string
    {
        return $this->basePath . "/". $user->getId() ."-[0-9][0-9][0-9].txt";
    }
}