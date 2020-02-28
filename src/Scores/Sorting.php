<?php
namespace App\Scores;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\PersistentCollection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Sorting
{
    public const ASC = 'ASC';
    public const DESC = 'DESC';
    public const SORT_ORDERS = [self::ASC, self::DESC];
    /**
     * @var string|null
     */
    private ?string $field;
    /**
     * @var string|null
     */
    private ?string $order;

    /**
     * @param string|null $field
     * @param string|null $order
     */
    public function __construct(?string $field, ?string $order)
    {
        $this->field = $field;
        $this->order = $order;

        if($order != null && !in_array($order, self::SORT_ORDERS)) {
            throw new BadRequestHttpException("Invalid sorting order");
        }
    }

    /**
     * @param array $data
     * @return ArrayCollection
     */
    public function sort(array $data): ArrayCollection
    {
        uasort($data,function ($a, $b) {
            if ($this->order == self::DESC ) {
                return $a->{'get' . ucfirst($this->field)}() > $b->{'get' . ucfirst($this->field)}() ? -1 : 1;
            } elseif ($this->order == self::ASC) {
                return $a->{'get' . ucfirst($this->field)}() < $b->{'get' . ucfirst($this->field)}() ? -1 : 1;
            }
        });
        return new ArrayCollection($data);
    }

    /**
     * @return string|null
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * @return string|null
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }
}