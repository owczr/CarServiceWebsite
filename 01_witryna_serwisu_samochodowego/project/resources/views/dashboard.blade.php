<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome to Better than worst mechanics!") }}
                </div>
            </div>
        </div>
    </div>

    @switch(App\Models\User::where('id',Auth::id())->value('type'))
        @case(1)
            <div class="py-12" style="padding: 10px">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-10">

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-ev-front" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold" style="font-size: 1.5em"><a href="{{route('requests.index')}}" class="underline text-gray-900 dark:text-white">Requests & Orders</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @break
        @case(2)
            <div class="py-12" style="padding: 10px">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-10">

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-ev-front" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold" style="font-size: 1.5em"><a href="{{route('requests.index')}}" class="underline text-gray-900 dark:text-white">List of requests</a></div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-12" style="padding: 10px">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-10">

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-ev-front" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold" style="font-size: 1.5em"><a href="{{route('orders.index')}}" class="underline text-gray-900 dark:text-white">My orders</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @break
        @case(3)
            <div class="py-12" style="padding: 10px">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-10">

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-ev-front" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold" style="font-size: 1.5em"><a href="{{route('requests.index')}}" class="underline text-gray-900 dark:text-white">Requests & Orders</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @break
    @endswitch
</x-app-layout>
