<?php

namespace CriminalOccurence\common;

/**
 * Result.
 *
 * Error handling and process state.
 *
 * @author Garcia Pedro <garciapedro.php@gmail.com>
 * @author Crisvan dos Santos <csdesigner.05@gmail.com>
 * @author António Gabriel <antoniocamposgabriel@gmail.com>
 */

use Exception;

class Result
{
    private function __construct(
        private bool $isSuccess,
        private $error = null,
        protected $value = null
    ) {
        if (
            $this->isSuccess === true && $this->error === true
        ) {
            throw new Exception("InvalidOperation: A result cannot be successful and contain an error");
        }

        if (
            $this->isSuccess === false && $this->error === false
        ) {
            throw new Exception("InvalidOperation: A failing result needs to contain an error message");
        }
    }

    public function getValue()
    {
        if ($this->isSuccess === false) {
            throw new Exception("Can't get the value of an error result. Use 'errorValue' instead.");
        }

        return $this->value;
    }

    public function errorValue()
    {
        return $this->error;
    }

    /**
     * Change status process ok
     * 
     * @return Result::Ok
     */
    public static function Ok($value): self
    {
        // Return status ok
        return new Result(true, null, $value);
    }

    /**
     * Change status process fail
     * 
     * @return Result::Fail
     */
    public static function Fail(string|array $error): self
    {
        // Retusn Bad
        return new Result(false, $error);
    }
}
