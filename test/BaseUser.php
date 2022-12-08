<?php

namespace ToBinFree\Test;

use ToBinFree\Hydrator\Hydrator;
use ToBinFree\Hydrator\DataProperty;

class BaseUser
{
    const TYPE_CONTACT  = "contact";
    const TYPE_LEAD     = "lead";

    use Hydrator;

    #[DataProperty]
    private string $type;

    #[DataProperty]
    private ?int $cardId = null;

    public function __construct(string $type = self::TYPE_CONTACT)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): BaseUser
    {
        $this->type = $type;
        return $this;
    }

    public function getCardId(): ?int
    {
        return $this->cardId;
    }

    public function setCardId(?int $cardId): BaseUser
    {
        $this->cardId = $cardId;
        return $this;
    }
}
