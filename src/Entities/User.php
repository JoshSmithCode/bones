<?php

namespace App\Entities;

/**
 * @Entity
 * @Table(name="users")
 */
class User extends AbstractEntity
{

    /**
     * @Column(type="string", name="email")
     *
     * @var string
     */
    private $email;

    /**
     * @Column(type="string", name="password")
     *
     * @var string
     */
    private $password;

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct($email, $password)
    {
        $this->setEmail($email);
        $this->setPassword($password);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}