<?php

namespace Rubix\ML\Loggers;

/**
 * Black Hole
 *
 * A logger that sends messages straight into a super-massive black hole.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class BlackHole extends Logger
{
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string|\Stringable $message
     * @param mixed[] $context
     */
    public function log($level, string|\Stringable $message, array $context = []) : void
    {
        // ⬤
    }
}
