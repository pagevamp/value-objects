<?php

namespace Pvo\TimeOff;
use Carbon\Carbon;
use Pvo\TimeOff\Exceptions\InvalidDate;

class Date
{
    private $start;
    private $end;
    private $isHalfDay;
    private $half;

    /**
     * Date constructor.
     * @param string $start
     * @param string|null $end
     * @param string|null $half
     * @throws InvalidDate
     */
    function __construct(string $start, string $end = null, string $half = null)
    {
        $this->start = Carbon::parse($start);
        $this->isHalfDay = !empty($half);
        $this->half = $half;

        if(!empty($end)){
            $this->end = Carbon::parse($end);
            if($this->start->gt($this->end)){
                throw new InvalidDate('Start is greater than end');
            }
        }
    }

    public function isHalfDay(): bool
    {
        return $this->isSingleDay() && $this->isHalfDay;
    }

    public function isFirstHalf(): bool
    {
        return $this->isSingleDay() && $this->half === 'first';
    }

    public function isSingleDay() : bool
    {
        return !$this->hasEnd();
    }

    public function startsAt() : Carbon
    {
        return $this->start;
    }

    private function hasEnd(): bool
    {
        return !empty($this->end);
    }

    public function endsAt(): ?Carbon
    {
        if($this->hasEnd()){
            return Carbon::parse($this->end);
        }

        return null;
    }
}
