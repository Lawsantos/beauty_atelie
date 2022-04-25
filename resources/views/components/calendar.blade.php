<div>
    <div class="flex justify-between flex-col border">
        <div class="flex justify-between p-4 items-center">
            <div>
                <a href="{{ url('/calendar?date=' . $baseDate->copy()->subMonth()->toDateString()) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
            </div>
            <div class="flex space-x-4 font-bold px-6">
                <div>
                    <span>{{ $getMonthName() }}</span>
                </div>
                <div>
                    <span>{{ $currentYear }}</span>
                </div>
            </div>
            <div>
                <a href="{{ url('/calendar?date=' . $baseDate->copy()->addMonth()->toDateString()) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div class="flex justify-between">

        </div>
    </div>
    @php
        $currentRow = 0;
    @endphp
    @while($currentRow < $calendarRows)
        <div class="flex h-24">
            @for($weekDay = 0; $weekDay < 7; $weekDay++)
                @php
                    $extraClass = $startOfCalendar->format('m') != $baseDate->format('m') ? 'bg-gray-100' : '';
                @endphp
                <a href="" class="border p-2 flex-1 hover:bg-purple-100 {{ $extraClass }}" data-ajax_target="">
                    <span class="text-gray-800">{{ $startOfCalendar->format('j') }}</span>
                    <span class=""></span>
                </a>
                @php
                    $startOfCalendar->addDay();
                @endphp
            @endfor
        </div>
        @php
            $currentRow++;
        @endphp
    @endwhile
</div>

