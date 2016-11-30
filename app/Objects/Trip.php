<?php

namespace App\Objects;

use App\Response;
use App\Sorter;

class Trip
{

    /**
     * Tickets for the trip.
     *
     * @var array
     */
    private $tickets = [];

    /**
     * Array with tickets sorted from start to end.
     *
     * @var array
     */
    private $sortedTickets = [];

    public function __construct($json)
    {
        $jsonArray = json_decode($json);

        foreach ($jsonArray as $jsonTicket) {
            // Create a new ticket
            $ticket = new Ticket($jsonTicket);

            // If the ticket contains all the necessary data
            if ($ticket->isValid()) {
                // Add it to the trip
                $this->addTicket($ticket);
            }
        }
    }

    /**
     * Add a ticket.
     *
     * @param  Ticket $ticket
     * @return $this
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Get all the tickets.
     *
     * @return array
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Generate the sorted ticket list.
     */
    public function generate()
    {
        $this->sortedTickets[0] = $this->getFirstTicket();

        for ($i = 1; $i < sizeof($this->tickets); $i++) {
            $this->sortedTickets[] = $this->getNextTicket();
        }

        $jsonTickets = [];

        foreach ($this->sortedTickets as $ticket) {
            $jsonTickets[] = $ticket->toJson();
        }

        Response::success($jsonTickets);
    }

    /**
     * Get the first ticket.
     *
     * @return bool|mixed
     */
    private function getFirstTicket()
    {
        $from = [];
        $to = [];

        foreach ($this->tickets as $ticket) {
            $from[] = $ticket->getField('from');
            $to[] = $ticket->getField('to');
        }

        $start = array_values(array_diff($from, $to))[0];

        return $this->getTicketByField('from', $start);
    }

    /**
     * Get the next ticket.
     *
     * @return bool|mixed
     */
    private function getNextTicket()
    {
        $lastTicket = end($this->sortedTickets);

        return $this->getTicketByField('from', $lastTicket->getField('to'));
    }

    /*
     * Find a ticket by field.
     *
     * @param  string $field
     * @param  string $query
     * @return Ticket|false
     */
    private function getTicketByField($field, $query)
    {
        foreach ($this->tickets as $ticket) {
            if ($ticket->hasField($field)) {
                if (stristr($ticket->getField($field), $query)) {
                    return $ticket;
                }
            }
        }

        // This will only be reached if no matches were found
        return false;
    }
}
