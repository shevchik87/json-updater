<?php
declare(strict_types = 1);

namespace App\Component\User;

class NewTokenDto implements \JsonSerializable
{
    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $token;

    /**
     * @var integer
     */
    private $until;

    /**
     * NewTokenDto constructor.
     * @param string $login
     * @param string $token
     * @param int $until
     */
    public function __construct(string $login, string $token, int $until)
    {
        $this->until = $until;
        $this->token = $token;
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getUntil(): int
    {
        return $this->until;
    }

    public function jsonSerialize()
    {
        return [
            'user' => $this->login,
            'token' => $this->token,
            'until' => $this->until
        ];
    }
}
