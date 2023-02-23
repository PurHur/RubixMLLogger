<?php

namespace Rubix\ML\Loggers;

use function trim;
use function date;
use function strtoupper;

/**
 * Screen
 *
 * A logger that displays log messages to the standard output.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class Network extends Logger
{
    /**
     * Host
     *
     * @var string
     */
    protected string $host;

    /**
     * ID
     *
     * @var string
     */
    protected string $id;

    /**
     * The channel name that appears on each line.
     *
     * @var string
     */
    protected string $channel;

    /**
     * The format of the timestamp.
     *
     * @var string
     */
    protected string $timestampFormat;

    /**
     * @param string $channel
     * @param string $timestampFormat
     */
    public function __construct(string $host, string $id, string $channel = '', string $timestampFormat = 'Y-m-d H:i:s')
    {
        $this->host = $host;
        $this->id = $id;
        $this->channel = trim($channel);
        $this->timestampFormat = $timestampFormat;

        $this->sendData([
            'type' => 'init',
            'id' => $this->id,
        ]);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string|\Stringable $message
     * @param mixed[] $context
     */
    public function log($level, string|\Stringable $message, array $context = []) : void
    {
        $prefix = '';

        if ($this->timestampFormat) {
            $prefix .= '[' . date($this->timestampFormat) . '] ';
        }

        if ($this->channel) {
            $prefix .= $this->channel . '.';
        }

        $prefix .= strtoupper((string) $level);


        $data = [
            'id' => $this->id,
            'prefix' => $prefix,
            'message' => (string)$message,
        ];

        $this->sendData($data);

        echo $prefix . ': ' . trim($message) . PHP_EOL;
    }

    /**
     * @return void
     */
    private function sendData($data): void
    {

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = @file_get_contents($this->host, false, $context);
    }
}
