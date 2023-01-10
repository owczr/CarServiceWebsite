<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editing a book') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="post" action="{{ route('orders.update', $order) }}">

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

                        <div class="flex items-center justify-end mt-4">

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
