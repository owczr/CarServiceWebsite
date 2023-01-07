<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accepting a request') }}
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
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        Waiting
                                    </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Description
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @markdown($request->description)
                                </dd>
                            </div>
                            <div class="p-6 bg-white border-b border-gray-200">
                                <form method="post" action="{{ route('orders.store') }}">

                                    @csrf

                                    <div>
                                        <x-input-label for="startDatetime" :value="__('Date and time of start (dd-mm-yyyy hh:mm)')" />
                                        <x-text-input id="startDatetime" class="block mt-1 w-full" type="datetime-local" name="startDatetime" :value="old('startDatetime')" autofocus />

                                        <x-input-error :messages="$errors->get('startDatetime')" class="mt-2" />
                                    </div>

                                    <div class="mt-4">
                                        <x-input-label for="title" :value="__('Estimated duration')" />
                                        <x-text-input id="estDuration" class="block mt-1 w-full" type="number" name="estDuration" :value="old('estDuration')" />

                                        <x-input-error :messages="$errors->get('estDuration')" class="mt-2" />
                                    </div>

                                    <div class="mt-4">
                                        <x-input-label for="title" :value="__('Cost')" />
                                        <x-text-input id="cost" class="block mt-1 w-full" type="number" name="cost" :value="old('cost')" />

                                        <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                                    </div>
                                    <input type="hidden" name="requestID" value="{{$request->id}}" />
                                    <input type="hidden" name="employeeID" value="{{Auth::id()}}" />
                                    <div class="flex items-center justify-end mt-4">
                                        <x-primary-button class="ml-4 mb-4">
                                            {{ __('Accept') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
