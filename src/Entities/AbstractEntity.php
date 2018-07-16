<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }
}