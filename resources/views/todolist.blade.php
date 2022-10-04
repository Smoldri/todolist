<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To-do list') }}
        </h2>
    </x-slot>
    <body>
    <section>

        <div class="container-fluid py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-5 justify-content-center">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ 'New task field must be filled' }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{route('store')}}" method="post">
                                @csrf
                                <div>
                                    <label for="description">Enter a task here</label><br>
                                    <label>
                                        <input placeholder="New task" name="description" type="text"/>
                                    </label>
                                </div>
                                <div>
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>


                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                            @foreach($tasks as $task)
                                <ul>
                                    <li class="row @if ($task->completed) font-weight-bold @endif">{{$task->description}}
                                        @if($task->completed)
                                            <form class="col" action="{{route('todo', $task)}}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-warning">To-do</button>
                                            </form>
                                        @else
                                            <form class="col align-content-lg-center"
                                                  action="{{route('complete', $task)}}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-success" type="submit">Done</button>
                                            </form>
                                        @endif


                                        <div class="col align-content-lg-center">
                                            <form action="{{ route('add-image', $task->id) }}" method="POST"
                                                  class="shadow p-12"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="task_id" value="{{$task->id}}">
                                                <label class="block mb-4">
                                                    <span class="sr-only">Choose File</span>
                                                    <input type="file" name="image"
                                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                                                    @error('image')
                                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                                    @enderror
                                                </label>
                                                <button type="submit"
                                                        class="px-4 py-2 text-sm text-white bg-indigo-600 rounded">
                                                    Submit
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#exampleModalCenter" data-id="{{$task->id}}">
                                            Details
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal
                                                            title</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <td>Task description: {{$task->description}}</td>
                                                        <br>
                                                        <td>Task status:{{$task->completed}}</td>
                                                        <br>
                                                        <td>Task completed: {{$task->completed_at}}</td>
                                                        <br>
                                                        <td>Task created: {{$task->created_at}}</td>
                                                        <br>
                                                        <td>Task updated:{{$task->updated_at}}</td>

                                                            @foreach(\App\Models\Image::where('task_id', $task->id)->get() as $image)
                                                                <img src="{{\Illuminate\Support\Facades\Storage::url($image->image)}}" alt="test">

                                                            @endforeach

                                                        @if ($message = Session::get('success'))
                                                            <div class="alert alert-success alert-block">
                                                                <strong>{{$message}}</strong>
                                                            </div>
                                                        @endif

                                                        <form method="post" action="{{route('store-image')}}"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="file" class="form-control" required
                                                                   name="image">
                                                            <input type="hidden" name="task_id" value="{{$task->id}}">
                                                            <button type="submit" class="btn btn-success">Add image
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                        <button type="button" class="btn btn-primary">Save changes
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form class="col-6 align-content-lg-center"
                                              action="{{route('delete', $task)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">delete</button>
                                        </form>

                                    </li>

                                </ul>

                            @endforeach


                        </div>
                    </div>

                </div>
            </div>

            <div>
            </div>
        </div>


    </section>


    </body>

</x-app-layout>
