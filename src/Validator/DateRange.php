<?php

namespace App\Validator;

class DateRange
{
    /**
     * @var \DateTime
     */
    protected $from;

    /**
     * @var \DateTime
     */
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from): void
    {
        $this->from = $from;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to): void
    {
        $this->to = $to;
    }

    /**
     * @return \DateTime
     */
    public function getFrom(): \DateTime
    {
        return $this->from;
    }

    /**
     * @return \DateTime
     */
    public function getTo(): \DateTime
    {
        return $this->to;
    }
}