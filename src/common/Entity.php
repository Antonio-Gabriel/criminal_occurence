<?php

namespace CriminalOccurence\common;

/**
 * Entity.
 *
 * The base of entities
 *
 * @author Garcia Pedro <garciapedro.php@gmail.com>
 * @author Crisvan dos Santos <csdesigner.05@gmail.com>
 */

use Ramsey\Uuid\UuidFactory;

class Entity
{
    public function __construct(
        public $props,
        protected ?string $id = null
    ) {
        if (
            is_null($this->id)
        ) {
            $generateUuid = new UuidFactory();
            $this->id = strval($generateUuid->uuid4());
        }
    }

    public function getId(): string
    {
        return $this->id;
    }
}
