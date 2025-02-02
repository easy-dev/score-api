<?php
namespace App\Scores\External;

use JMS\Serializer\Annotation\Type;

class User
{
    /**
     * @Type("string")
     */
    private string $id;
    /**
     * @Type("string")
     */
    private string $name;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}