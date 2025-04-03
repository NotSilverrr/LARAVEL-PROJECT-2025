<x-app-layout>
    <div class="min-h-screen w-full bg-no-repeat bg-top" style="background-image: url('{{ asset('assets/images/background.jpg') }}'); background-size: 100% auto;">
        <div class="p-6">
            <div class="flex flex-wrap" style="flex-wrap: wrap;">
                @php
                    $totalDays = $months[$selected_month-1]['days'];
                    $monthName = $months[$selected_month-1]['name'];
                    
                    $prevMonth = $selected_month - 1;
                    $prevYear = $selected_year;
                    if ($prevMonth < 1) {
                        $prevMonth = 12;
                        $prevYear--;
                    }
                    
                    $nextMonth = $selected_month + 1;
                    $nextYear = $selected_year;
                    if ($nextMonth > 12) {
                        $nextMonth = 1;
                        $nextYear++;
                    }
                    
                    // Calculate total number of cells needed (days + empty cells at start)
                    $totalCells = $totalDays + $first_day_of_month;
                    // Calculate number of weeks needed
                    $totalWeeks = ceil($totalCells / 7);
                @endphp
                
                <div class="w-full flex justify-end">
                    <div class="w-[80%] bg-gray-700 rounded-lg p-4">
                        <!-- Month title and navigation centered at the top -->
                        <div class="flex justify-center items-center space-x-6 mb-6">
                            <a href="{{ route('calendar.index', ['month' => $prevMonth, 'year' => $prevYear]) }}" class="text-white hover:text-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </a>
                            
                            <h2 class="text-3xl font-bold text-white">{{ $monthName }} {{ $selected_year }}</h2>
                            
                            <a href="{{ route('calendar.index', ['month' => $nextMonth, 'year' => $nextYear]) }}" class="text-white hover:text-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                        
                        <!-- Calendar grid -->
                        @for($week = 0; $week < $totalWeeks; $week++)
                            <div class="flex w-full">
                                @for($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++)
                                    @php
                                        $dayIndex = $week * 7 + $dayOfWeek;
                                        $dayNumber = $dayIndex - $first_day_of_month + 1;
                                    @endphp
                                    
                                    @if($dayNumber > 0 && $dayNumber <= $totalDays)
                                        <div class="bg-gray-800 rounded-lg w-40 h-24 p-2 m-2 flex flex-col justify-between">
                                            <div class="flex justify-between">
                                                <span class="text-white text-xl font-bold">{{ $dayNumber }}</span>
                                                <div class="w-4 h-4"></div>
                                            </div>

                                            <div class="w-full h-[1px] bg-gray-400 my-1"></div>

                                            <div class="flex flex-1 items-end justify-between space-x-1">
                                                <div class="w-1/3 h-12 bg-transparent"></div>
                                                <div class="w-1/3 h-12 bg-transparent"></div>
                                                <div class="w-1/3 h-12 bg-transparent"></div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="w-40 h-24 m-2 bg-transparent rounded-lg"></div>
                                    @endif
                                @endfor
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>