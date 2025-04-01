<x-app-layout>
    <div class="min-h-screen w-full bg-no-repeat bg-top" style="background-image: url('{{ asset('assets/images/background.jpg') }}'); background-size: 100% auto;">
        <div class="p-6">
            <div class="flex flex-wrap" style="flex-wrap: wrap;">
                @php
                    $totalDays = $months[$selected_month-1]['days'];
                @endphp
                
                <div class="w-full flex justify-end">
                    <div class="w-[80%]">
                        @for($week = 0; $week < ceil($totalDays / 7); $week++)
                            <div class="flex w-full bg-gray-700">
                                @for($day = 1; $day <= 7; $day++)
                                    @php
                                        $processingDay = $week * 7 + $day;
                                    @endphp
                                    
                                    @if($processingDay <= $totalDays)
                                        <div class="bg-gray-800 rounded-lg w-40 h-24 p-2 m-2 flex flex-col justify-between">
                                            <div class="flex justify-between">
                                                <span class="text-white text-xl font-bold">{{ $processingDay }}</span>
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