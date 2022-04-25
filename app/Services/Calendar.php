<?php

namespace App\Services;

use DateTime;
use Illuminate\Support\Carbon;

class Calendar
{
    public static function render($events = null,
                                  $view_year = null,
                                  $view_month = null,
                                  $view_day = null,
                                  $post_to = null,
                                  $class = null,
                                  $button_args = null)
    {
        $instance = new static;
        return $instance->getHtml($events,
            $view_year,
            $view_month,
            $view_day,
            $post_to,
            $class,
            $button_args);
    }

    protected function getHtml(
        $events = null,
        $view_year = null,
        $view_month = null,
        $view_day = null,
        $post_to = null,
        $class = null,
        $button_args = null
    ) {
        $result = '';

        // SETUP VALUES:
        $view_date_time = Carbon::createFromDate($view_year, $view_month, $view_day);

        $view_year = $view_year ?? self::Get_This_Year();
        $view_month = $view_month ?? self::Get_This_Month();
        $view_day = $view_day ?? self::Get_This_Day();

        $no_day_selected = is_null($view_day);

        $day = 1;
        $next = 1;

        // LOOP TO MAKE "WEEK" CALENDAR ROWS:
        for ($week = 0; $week < self::Get_Calendar_Rows($view_year, $view_month); $week++)
        {
            $row = '';

            if (0 == $week && self::Get_Month_Start_Weekday($view_year, $view_month) > 0)
            {
                for ($last = (self::Get_Days_In_Prior_Month($view_year, $view_month) - self::Get_Month_Start_Weekday($view_year, $view_month) + 1); $last <= self::Get_Days_In_Prior_Month($view_year, $view_month); $last++)
                {
                    $cellEvents = isset($events[$this->getEventISODate($view_year, $view_month, $last)]) ?
                        $events[$this->getEventISODate($view_year, $view_month, $last)] : [];

                    $row .= self::Build_Cell(
                        $post_to,
                        $this->getCellYear($view_year, $view_month),
                        $this->getCellMonth($view_month),
                        $last,
                        $cellEvents,
                        'bg-gray-100 text-gray-800 hover:bg-purple-100'
                    );
                }

                for ($day = 1; $day <= (7 - self::Get_Month_Start_Weekday($view_year, $view_month)); $day++)
                {
                    $row .= self::Build_Cell(
                        $post_to,
                        $view_year,
                        $view_month,
                        $day,
                        ((isset($events[self::Get_ISO_Date($view_year, $view_month, $day)])) ? $events[self::Get_ISO_Date($view_year, $view_month, $day)] : null),
                        (($this->isToday($view_year, $view_month, $view_day)) ? 'today' : (( ! $no_day_selected && $day == $view_day) ? 'selected' : ''))
                    );
                }
            }
            else
            {
                for ($i = 0; $i < 7; $i++)
                {
                    if (checkdate($view_month, $day, $view_year))
                    {
                        $row .= self::Build_Cell(
                            $post_to,
                            $view_year,
                            $view_month,
                            $day,
                            ((isset($events[self::Get_ISO_Date($view_year, $view_month, $day)])) ? $events[self::Get_ISO_Date($view_year, $view_month, $day)] : null),
                            (($this->isToday($view_year, $view_month, $view_day)) ? 'today' : (( ! $no_day_selected && $day == $view_day) ? 'selected' : ''))
                        );
                        $day++;
                    }
                    else
                    {
                        $row .= self::Build_Cell(
                            $post_to,
                            (($view_month < 12) ? $view_year : $view_year + 1),
                            (($view_month < 12) ? $view_month + 1 : 1),
                            $next,
                            ((isset($events[self::Get_ISO_Date((($view_month < 12) ? $view_year : $view_year + 1), (($view_month < 12) ? $view_month + 1 : 1), $next + 1)]) && isset($events[self::Get_ISO_Date((($view_month < 12) ? $view_year : $view_year + 1), (($view_month < 12) ? $view_month + 1 : 1), $next++)])) ? $events[self::Get_ISO_Date((($view_month < 12) ? $view_year : $view_year + 1), (($view_month < 12) ? $view_month + 1 : 1), $next++)] : null),
                            'bg-gray-100 text-gray-800 hover:bg-purple-100'
                        );
                        $next++;
                    }
                }
            }

            if (0 < strlen($row))
            {
                $result .= HTML_div::Get_HTML($row, ['class' => 'flex h-24']);
            }
        }

        // ADD CALENDAR TITLE (MONTH/YEAR), NAVIGATION & WEEKDAY LABELS:
        $headerClass = 'flex justify-between flex-col border';

        $result = HTML_div::Get_HTML(
            HTML_div::Get_HTML(
                self::Get_Calendar_Nav_Button($view_year, $view_month, 'back', $button_args) .
                self::Get_Calendar_Label_HTML($view_year, $view_month) .
                self::Get_Calendar_Nav_Button($view_year, $view_month, 'next', $button_args),
                ['class' => 'flex justify-between p-4 items-center']
            ) . self::Get_Weekday_Labels_HTML(), ['class' => $headerClass]) . $result;

        // RETURN WRAPPED CALENDAR:
        return HTML_div::Get_HTML($result, ['class' => '']);

    }

    public function Get_Cal_Nav(array $args = null)
    {
        $prev_month = (1 == $args['view_month']) ? 12 : $args['view_month'] - 1;
        $next_month = (12 > $args['view_month']) ? $args['view_month'] + 1 : 1;

        $prev_year = (1 < $args['view_month']) ? $args['view_year'] : $args['view_year'] - 1;
        $next_year = (12 == $args['view_month']) ? $args['view_year'] + 1 : $args['view_year'];

        $args['data-ajax_target'] = (isset($args['data-ajax_target']) && strlen($args['data-ajax_target'])) ? $args['data-ajax_target'] : '';
        $args['data-ajax_call_before'] = (isset($args['data-ajax_call_before']) && strlen($args['data-ajax_call_before'])) ? $args['data-ajax_call_before'] : '';
        $args['data-ajax_call_after'] = (isset($args['data-ajax_call_after']) && strlen($args['data-ajax_call_after'])) ? $args['data-ajax_call_after'] : '';

        $nav_links[] = HTML_a::Get_HTML(self::Get_Month_As_String($prev_month) . ' ' . $prev_year, [
            'href'                  => $args['url'] . $prev_year . '/' . $prev_month . '/',
            'class'                 => 'prev_month' . (($args['class']) ? ' ' . $args['class'] : ''),
            'data-ajax_target'      => $args['data-ajax_target'],
            'data-ajax_call_before' => $args['data-ajax_call_before'],
            'data-ajax_call_after'  => $args['data-ajax_call_after'],
            'title'                 => 'Select to move back to ' . self::Get_Month_As_String($prev_month) . ' ' . $prev_year . '.',
        ]);

        $nav_links[] = HTML_a::Get_HTML('THIS MONTH', [
            'href'                  => $args['url'] . self::Get_This_Year() . '/' . self::Get_This_Month() . '/',
            'class'                 => 'this_month' . (($args['class']) ? ' ' . $args['class'] : ''),
            'data-ajax_target'      => $args['data-ajax_target'],
            'data-ajax_call_before' => $args['data-ajax_call_before'],
            'data-ajax_call_after'  => $args['data-ajax_call_after'],
            'title'                 => 'Select to jump to the current calendar month.',
        ]);

        $nav_links[] = HTML_a::Get_HTML(self::Get_Month_As_String($next_month) . ' ' . $next_year, [
            'href'                  => $args['url'] . $next_year . '/' . $next_month . '/',
            'class'                 => 'next_month' . (($args['class']) ? ' ' . $args['class'] : ''),
            'data-ajax_target'      => $args['data-ajax_target'],
            'data-ajax_call_before' => $args['data-ajax_call_before'],
            'data-ajax_call_after'  => $args['data-ajax_call_after'],
            'title'                 => 'Select to move ahead to ' . self::Get_Month_As_String($next_month) . ' ' . $next_year . '.',
        ]);

        return HTML_div::Get_HTML(HTML_List::Get_HTML('ul', $nav_links), ['class' => 'cal_nav']);
    }

    public function Get_Days_In_Month($year, $month)
    {
        for ($day = 31; $day > 0; $day--)
        {
            if (checkdate($month, $day, $year))
            {
                return $day;
            }
        }

        return false;
    }

    public function Get_Days_In_Prior_Month($year, $month)
    {
        $year = ($month == 1) ? $year - 1 : $year;
        $month = ($month == 1) ? 12 : $month - 1;

        return self::Get_Days_In_Month($year, $month);

    }

    public function Get_Month_As_String(int $month)
    {
        return Carbon::createFromDate(self::Get_This_Year(), $month, 1)->format('F');
    }

    public function Get_ISO_Date($year = null, $month = null, $day = null)
    {
        $currentYear = $year ?? self::Get_This_Year();
        $currentMonth = $month ?? self::Get_This_Month();
        $currentDay = $day ?? self::Get_This_Day();
        return Carbon::createFromDate($currentYear, $currentMonth, $currentDay)->toDateString();
    }

    public function Get_This_Year($format = 'Y')
    {
        return Carbon::now()->format($format);
    }

    public function Get_This_Month($format = 'n')
    {
        return Carbon::now()->format($format);
    }

    public function Get_This_Day($format = 'j')
    {
        return Carbon::now()->format($format);
    }

    public function Get_Now($format = 'Y-m-d H:i:s')
    {
        return Carbon::now()->format($format);
    }

    public function Get_DB_DateTime($time)
    {
        return date('Y-m-d H:i:s', $time);
    }

    public function Get_Calendar_Rows($year, $month)
    {
        return ceil(
            (self::Get_Month_Start_Weekday($year, $month) + self::Get_Days_In_Month($year, $month)) / 7
        );
    }

    public function Get_Calendar_Label_HTML($year, $month)
    {
        return HTML_div::Get_HTML(
            HTML_div::Get_HTML(
                HTML_span::Get_HTML(
                    self::Get_Month_As_String($month), ['id' => 'calendar_month_label']
                ), ['class' => 'month']) .
            ' ' .
            HTML_div::Get_HTML(
                HTML_span::Get_HTML($year), ['class' => 'year']
            ), ['class' => 'flex space-x-4 font-bold px-6']
        );
    }

    public function Get_Calendar_Nav_Button($year = 2012, $month = 1, $direction = 'back', array $button_args)
    {
        $prev_month = (1 == $month) ? 12 : $month - 1;
        $next_month = (12 > $month) ? $month + 1 : 1;

        $prev_year = (1 < $month) ? $year : $year - 1;
        $next_year = (12 == $month) ? $year + 1 : $year;

        $direction = (('back' == $direction || 'next' == $direction)) ? $direction : 'back';
        $button_label = (isset($button_args['label']) && strlen($button_args['label'])) ? $button_args['label'] : (('back' == $direction) ? '&#9668;' : '&#9658;');

        if (isset($button_args['href']) && strlen($button_args['href']))
        {
            $button_args['href'] .= ('back' == $direction) ? $prev_year . '/' . $prev_month . '/' : $next_year . '/' . $next_month . '/';
            $button_args['title'] = ('back' == $direction) ? 'Select to move back to ' . self::Get_Month_As_String($prev_month) . ' ' . $prev_year . '.' : 'Select to move ahead to ' . self::Get_Month_As_String($next_month) . ' ' . $next_year . '.';
            $button_args['data-ajax_target'] = (isset($button_args['data-ajax_target']) && strlen($button_args['data-ajax_target'])) ? $button_args['data-ajax_target'] : '';
            $button_args['data-ajax_call_before'] = (isset($button_args['data-ajax_call_before']) && strlen($button_args['data-ajax_call_before'])) ? $button_args['data-ajax_call_before'] : '';
            $button_args['data-ajax_call_after'] = (isset($button_args['data-ajax_call_after']) && strlen($button_args['data-ajax_call_after'])) ? $button_args['data-ajax_call_after'] : '';
        }

        $backIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
</svg>';
        $nextIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
</svg>';
        $icon = ($direction == 'back') ? $backIcon : $nextIcon;
        $result = HTML_span::Get_HTML($icon, ['class' => '' . $direction]);

        if (isset($button_args['href']))
        {
            $result = HTML_a::Get_HTML($result, $button_args);
        }

        return HTML_div::Get_HTML($result, ['class' => '']);
    }

    // REFACTORED
    public function Get_Weekday_Labels_HTML()
    {
        $endWeekClass = 'p-2 bg-gray-600 text-gray-100 flex-1';
        $weekClass = 'p-2 bg-gray-200 text-gray-900 flex-1';

        return HTML_div::Get_HTML(
            HTML_div::Get_HTML(HTML_span::Get_HTML('SUN'), ['class' => $endWeekClass]) .
            HTML_div::Get_HTML(HTML_span::Get_HTML('MON'), ['class' => $weekClass]) .
            HTML_div::Get_HTML(HTML_span::Get_HTML('TUE'), ['class' => $weekClass]) .
            HTML_div::Get_HTML(HTML_span::Get_HTML('WED'), ['class' => $weekClass]) .
            HTML_div::Get_HTML(HTML_span::Get_HTML('THU'), ['class' => $weekClass]) .
            HTML_div::Get_HTML(HTML_span::Get_HTML('FRI'), ['class' => $weekClass]) .
            HTML_div::Get_HTML(HTML_span::Get_HTML('SAT'), ['class' => $endWeekClass]),
            ['class' => 'flex justify-between']
        );
    }

    public function Past_Date($day, $month, $year)
    {
        return ($year < self::Get_This_Year() || ($year == self::Get_This_Year() && ($month < self::Get_This_Month() || ($month == self::Get_This_Month() && $day < self::Get_This_Day()))));
    }

    public function Valid_Date($day, $month, $year)
    {
        return checkdate($month, $day, $year);
    }

    public function Get_Month_Start_Weekday($year, $month)
    {
        if (1 == strlen($month))
        {
            $month = '0' . $month;
        }

        $target = new DateTime();
        $target->setDate($year, $month, 1);

        return date_format($target, 'w');
    }

    public function Get_Month_End_Weekday($year, $month)
    {
        if (1 == strlen($month))
        {
            $month = '0' . $month;
        }

        $target = new DateTime();
        $target->setDate($year, $month, self::Get_Days_In_Month($year, $month));

        return date_format($target, 'w');
    }

    private function Build_Cell($post_to, $year = null, $month = null, $day = null, $events = null, $class = null)
    {
        $content = '';


        if ($events && count($events))
        {
            $content .= CalendarElement::render("span",
                CalendarElement::render("span", count($events), ['class' => 'count']) . ' class' . ((count($events) > 1) ? 'es' : ''), ['class' => 'event']);
        }

        $class = ((strlen($class)) ? $class . ' ' : '') . ((self::Past_Date($day, $month, $year)) ? '' : '');

        $today_HTML = (stristr($class, 'today ')) ? HTML_span::Get_HTML(HTML_span::Get_HTML(''), ['class' => 'bg-green-600 text-white font-bold']) : '';

        $GLOBALS['ajax_on'] = $GLOBALS['ajax_on'] ?? '';

        return CalendarElement::render("a",
            CalendarElement::render("span", $day, ['class' => 'label']) .
            CalendarElement::render("span", $content, ['class' => 'content']) . $today_HTML, [
            'href'             => ((0 < count($events ?? [])) ? $post_to . $year . '/' . $month . '/' . $day . '/' : '#'),
            'class'            => 'border p-2 flex-1 hover:bg-purple-100' . ((0 < strlen($content)) ? ' has_content' : '') . (($GLOBALS['ajax_on']) ? ' ajax' : '') . ((strlen($class)) ? ' ' . $class : ''),
            'data-ajax_target' => (($GLOBALS['ajax_on']) ? 'popup_content_0' : ''),
        ]);
    }

    protected function getEventISODate($view_year, $view_month, $last)
    {
        return self::Get_ISO_Date(
            $this->getCellYear($view_year, $view_month),
            $this->getCellMonth($view_month),
            $last
        );
    }

    protected function getCellYear($view_year, $view_month)
    {
        return ($view_month > 1) ? $view_year : $view_year - 1;
    }

    protected function getCellMonth($view_month)
    {
        return ($view_month > 1) ? $view_month - 1 : 12;
    }

    protected function isToday($view_year, $view_month, $view_day)
    {
        return ($view_year == self::Get_This_Year()) &&
            ($view_month == self::Get_This_Month()) &&
            ($view_day == self::Get_This_Day());
    }
}
