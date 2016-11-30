<?php

namespace App\Objects;

/**
 * Class Ticket
 * @package App\Objects
 */
class Ticket
{

    /**
     * The start of the journey.
     *
     * @var string
     */
    private $from;

    /**
     * The end of the journey.
     *
     * @var string
     */
    private $to;

    /**
     * Transport type.
     *
     * @var string
     */
    private $transport;

    /**
     * The assigned seat.
     *
     * @var string|null
     */
    private $seat;

    /**
     * Extra data (optional).
     *
     * @var array
     */
    private $extra = [];

    /**
     * Ticket constructor.
     * @param  $json
     */
    public function __construct($json)
    {
        $this->from = $json->from;
        $this->to = $json->to;
        $this->transport = $json->transport;
        $this->seat = $json->seat;

        if (isset($json->extra)) {
            foreach ($json->extra as $key => $value) {
                $this->extra[$key] = $value;
            }
        }
    }

    /**
     * Check if the ticket is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        if (
            isset($this->to) &&
            isset($this->from) &&
            isset($this->transport)
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if a field exists.
     *
     * @param  string $field
     * @return bool
     */
    public function hasField($field)
    {
        return isset($this->$field);
    }

    /**
     * Get a field's value.
     *
     * @param  string $field
     * @return string|bool
     */
    public function getField($field)
    {
        return $this->$field ?: false;
    }

    /**
     * Turn the ticket into a json string.
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode([
            'from' => $this->from,
            'to' => $this->to,
            'seat' => $this->seat,
            'transport' => $this->transport,
            'extra' => $this->extra
        ]);
    }

}