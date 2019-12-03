<?php

namespace CLIFramework\IO;

/**
 * Console utilities using STDIN.
 */
class StandardConsole implements Console
{
    /**
     * @var Stty
     */
    private $stty;

    public function __construct(Stty $stty)
    {
        $this->stty = $stty;
    }

    public function readLine($prompt)
    {
        echo $prompt;

        return $this->read();
    }

    public function readPassword($prompt)
    {
        echo $prompt;

        $self = $this;

        return $this->noEcho(function () use ($self) {
            return $self->read();
        });
    }

    public function noEcho(\Closure $callback)
    {
        return $this->stty->withoutEcho($callback);
    }

    private function read()
    {
        return rtrim(fgets(STDIN), "\n");
    }
}
