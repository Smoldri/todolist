<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users table') }}
        </h2>
    </x-slot>
    <body>
    <section>
        <div class="container-fluid py-10">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-5 justify-content-center tes">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg container-fluid">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Registration date</th>
                            </tr>
                            </thead>
                            @foreach($users as $count=>$user)
                                <tbody>
                                <tr>
                                    <th scope="row">{{++$count}}</th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->created_at}}</td>
                                </tr>
                                </tbody>

                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
    </body>


</x-app-layout>
