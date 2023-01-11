<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editing order no #{{ $request->id }}: {{ $request->title }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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
                                Client phone number
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ App\Models\User::where('id', $request->clientID )->value('phone') }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Title
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $request->title }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Car model
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $request->model }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Proposed date
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ Carbon\Carbon::parse($request->date)->format('d-m-Y') }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Status
                            </dt>
                                <dd class="mt-1 text-sm text-green-500 sm:mt-0 sm:col-span-2">
                                    Accepted
                                </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Description
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @markdown($request->description)
                            </dd>
                        </div>
                        @if($request->images != null)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Client images
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @foreach(explode('|',$request->images) as $image)
                                        @if($image != "")
                                            <img src="{{ asset( "$image")  }}" style="width: 400px; margin-left: auto; margin-right: auto; display: block;" alt="{{ explode('/',$image)[1] }}"/>
                                        @endif
                                    @endforeach
                                </dd>
                            </div>
                        @endif
                    </dl>
                    <form method="post" action="{{ route('orders.update', $order) }}" enctype="multipart/form-data">

                        @csrf
                        @method("PUT")

                        <div>
                            <x-input-label for="startDatetime" :value="__('Start date and time')" />
                            <x-text-input id="startDatetime" class="block mt-1 w-full" type="datetime-local" name="startDatetime" :value="$order->startDatetime" />

                            <x-input-error :messages="$errors->get('startDatetime')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="estDuration" :value="__('Estimated duration')" />
                            <x-text-input id="estDuration" class="block mt-1 w-full" type="text" name="estDuration" :value="$order->estDuration" />

                            <x-input-error :messages="$errors->get('estDuration')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="cost" :value="__('Cost')" />
                            <x-text-input id="cost" class="block mt-1 w-full" type="text" name="cost" :value="$order->cost" />

                            <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                        </div>
                        @if($order->images != null || $order->images != "")
                            <input type="hidden" name="existingImages" value="{{$order->images}}" />
                            @foreach(explode('|',$order->images) as $image)
                                @if($image != "")
                                    <div class="p-4 bg-white border-b border-gray-200">
                                        <img src="{{ asset( "$image")  }}" style="width: 500px; margin-left: auto; margin-right: auto; display: block;" alt="{{ explode('/',$image)[1] }}"/>
                                    </div>
                                @endif
                            @endforeach
                        @endif


                        <div class="flex items-center justify-end mt-4">
                            <input type="hidden" name="requestID" value="{{$order->requestID}}" />
                            <input type="hidden" name="employeeID" value="{{$order->employeeID}}" />
                            <input type="file" id="image" name="image[]" accept="image/png, image/jpeg" multiple>
                            <x-primary-button class="ml-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
