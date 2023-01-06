<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($request->status == 0)
                {{ __('Viewing a request') }}
            @else
                {{ __('Viewing a order') }}
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 mt-4 mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $request->title }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Detailed information.
                        </p>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Client name
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ App\Models\User::where('id', $request->clientID )->value('name') }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Title
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $request->title }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Car model
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $request->model }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Proposed date
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ Carbon\Carbon::parse($request->date)->format('d-m-Y') }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Status
                                </dt>
                                @switch($request->status)
                                    @case(0)
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            Waiting
                                        </dd>
                                        @break
                                    @case(1)
                                        <dd class="mt-1 text-sm text-green-500 sm:mt-0 sm:col-span-2">
                                            Accepted
                                        </dd>
                                        @break
                                    @case(2)
                                        <dd class="mt-1 text-sm text-yellow-400 sm:mt-0 sm:col-span-2">
                                            Returned
                                        </dd>
                                        @break
                                    @case(3)
                                        <dd class="mt-1 text-sm text-red-600 sm:mt-0 sm:col-span-2">
                                            Rejected
                                        </dd>
                                        @break
                                    @case(4)
                                        <dd class="mt-1 text-sm text-blue-600 sm:mt-0 sm:col-span-2">
                                            Closed
                                        </dd>
                                        @break
                                @endswitch

                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Description
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @markdown($request->description)
                                </dd>
                            </div>
                            @if($request->status == 0)
                                <div class="bg-white px-4 pb-5 flex items-center justify-end mt-4">

                                    <form method="get" action="{{ route('requests.accept', $request) }}">
                                        <x-primary-button class="ml-4 mb-4">
                                            {{ __('Accept') }}
                                        </x-primary-button>
                                    </form>

                                    <form method="get" action="{{ route('requests.respond', $request) }}">
                                        <x-primary-button class="ml-4 mb-4">
                                            {{ __('Respond with new date') }}
                                        </x-primary-button>
                                    </form>

                                    <form method="post" action="{{ route('requests.reject', $request) }}">
                                        <x-primary-button class="ml-4 mb-4">
                                            {{ __('Reject') }}
                                        </x-primary-button>
                                    </form>
                                </div>
                            @endif
                            @if(isset($orderInfo))

                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Employee name
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ App\Models\User::where('id', $orderInfo->employeeID )->value('name') }}
                                    </dd>
                                </div>
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Cost
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                         {{ $orderInfo->cost }}
                                    </dd>
                                </div>
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Date and time of beginning
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ Carbon\Carbon::parse($orderInfo->startDatetime)->format('d-m-Y H:i') }}
                                    </dd>
                                </div>
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Estimated duration
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $orderInfo->estDuration }}
                                    </dd>
                                </div>
                                @if($request->status == 1)
                                    <div class="bg-white px-4 pb-5 flex items-center justify-end mt-4">
                                        <form method="get" action="">
                                            <x-primary-button class="ml-4 mb-4">
                                                {{ __('Add photos') }}
                                            </x-primary-button>
                                        </form>
                                        <form method="get" action="">
                                            <x-primary-button class="ml-4 mb-4">
                                                {{ __('Finish') }}
                                            </x-primary-button>
                                        </form>

                                    </div>
                                @endif
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
