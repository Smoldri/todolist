@dd($items)
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To-do list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div>
                            <div>
                                <form action="{{route('store')}}" method="post">
                                    @csrf
                                    <div>
                                        <label for="description">Enter a task here</label>
                                        <label>
                                            <input name="description" type="text"/>
                                        </label>

                                    </div>
                                    <div>
                                        <button type="submit">Save</button>
                                    </div>
                                </form>

                                <div>
                                    <div>
                                        <ul>
                                      @foreach($items as $item)
                                          <li> </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </div>


</x-app-layout>
