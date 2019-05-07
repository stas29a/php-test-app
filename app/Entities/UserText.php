<?php
namespace App\Entities;


class UserText
{
    /**
     * @var User
     */
    protected $user;

    protected $pathToFile;

    /**
     * UserText constructor.
     * @param User $user
     * @param $pathToFile
     */
    public function __construct(User $user, $pathToFile)
    {
        $this->user = $user;
        $this->pathToFile = $pathToFile;
    }


    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }


    /**
     * @return mixed
     */
    public function getPathToFile(): string
    {
        return $this->pathToFile;
    }

    /**
     * @param mixed $pathToFile
     */
    public function setPathToFile(string $pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

    /**
     * @return bool|string
     */
    public function getText()
    {
        return file_get_contents($this->getPathToFile());
    }
}