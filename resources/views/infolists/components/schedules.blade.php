<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div class="flex flex-col text-sm leading-6 text-gray-950 dark:text-white">
        @if($getState())
            @foreach($getState() as $schedule)
                <div class="flex">
                    <p class="font-bold"> {{ $schedule->day}}</p>
                    @if($schedule->start_time)
                        <p>{{ date(': g:i A - ', strtotime($schedule->start_time)) . date('g:i A', strtotime($schedule->end_time))}}</p>
                    @else
                        <p class="italic">: By Appointment</p>
                    @endif
                </div>
            @endforeach
        @else
            <p class="italic">No schedules found.</p>
        @endif
        {{--        {{ $getState() }}--}}
        {{--        {{ $getRecord()}}--}}
    </div>


</x-dynamic-component>
