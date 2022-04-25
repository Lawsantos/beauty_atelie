<?php

namespace App\View\Components;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

class Calendar extends Component
{
    public int $currentMonth;
    public int $currentYear;
    public int $currentDay;
    public Carbon $baseDate;

    public Carbon $startOfCalendar;
    public Carbon $endOfCalendar;

    public array $events;
    public string $date;

    public function __construct(array $events = [], string $date = '')
    {
        Carbon::setLocale('pt-BR');

        $this->date = $date;
        $this->events = $events;
        $this->baseDate = empty($date) ? Carbon::now() : Carbon::createFromFormat('Y-m-d', $date);
        $this->startOfCalendar = $this->baseDate->copy()->firstOfMonth()->startOfWeek(CarbonInterface::SUNDAY);
        $this->endOfCalendar = $this->baseDate->copy()->lastOfMonth()->endOfWeek(CarbonInterface::SATURDAY);

        $this->currentMonth = $this->baseDate->month;
        $this->currentYear = $this->baseDate->year;
        $this->currentDay = $this->baseDate->day;
    }

    public function render()
    {
        return view('components.calendar', [
            'calendarRows' => $this->getCalendarRows(),
        ]);
    }

    public function getMonthName()
    {
        return $this->baseDate->monthName;
    }

    protected function getCalendarRows(): int
    {
        $weekDay = $this->baseDate;
        $weekStart = intval($weekDay->setDay(1)->format('w'));
        $daysInMonth = $this->baseDate->daysInMonth;
        return ceil(($weekStart + $daysInMonth) / 7);
    }

    protected function getCalendarWeek(int $week): string
    {

    }
}
