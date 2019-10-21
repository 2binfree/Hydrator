<?php


namespace ToBinFree\Test;

use ToBinFree\Hydrator\Hydrator;

class BaseUser
{
    const TYPE_CONTACT  = "contact";
    const TYPE_LEAD     = "lead";

    use Hydrator;

    /**
     * @var string
     * @DataProperty
     */
    private $type;

    /** @var int */
    private $cardId;

    /**
     * BaseUser constructor.
     * @param string $type
     */
    public function __construct(string $type = self::TYPE_CONTACT)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return BaseUser
     */
    public function setType(string $type): BaseUser
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCardId(): ?int
    {
        return $this->cardId;
    }

    /**
     * @param int|null $cardId
     * @return BaseUser
     */
    public function setCardId(?int $cardId): BaseUser
    {
        $this->cardId = $cardId;
        return $this;
    }

}
