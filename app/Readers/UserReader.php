<?php
namespace App\Readers;


use App\Entities\User;

class UserReader
{
    const SEPARATOR_NAME_COMMA = 'comma';
    const SEPARATOR_NAME_SEMICOLON = 'semicolon';

    protected $pathToUsersFile;
    protected $separator;


    /**
     * UserRepository constructor.
     * @param string $separatorName
     * @param string $pathToUsersFile
     * @throws \Exception
     */
    public function __construct(string $separatorName, string $pathToUsersFile)
    {
        if ($separatorName !== self::SEPARATOR_NAME_COMMA && $separatorName !== self::SEPARATOR_NAME_SEMICOLON) {
            throw new \Exception("Unknown separatorName given");
        }

        switch ($separatorName) {
            case self::SEPARATOR_NAME_COMMA:
                $this->separator = ",";
                break;
            case self::SEPARATOR_NAME_SEMICOLON:
                $this->separator = ";";
                break;
        }

        $this->pathToUsersFile = $pathToUsersFile;
    }

    /**
     * @return array
     * @throws \Exception
     */
    function getUsers(): array
    {
        $result = [];

        $data = file_get_contents($this->pathToUsersFile);

        if (strlen($data) == 0) {
            throw new \Exception("Users file is empty");
        }

        $lines = explode("\n", $data);

        foreach ($lines as $line) {
            $tmp = explode($this->separator, $line);
            $user = new User();
            $user->setId($tmp[0]);
            $user->setName($tmp[1]);

            $result[] = $user;
        }

        return $result;
    }
}