<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To-do list') }}
        </h2>
    </x-slot>
    <body>
    <section>

        <div class="container-fluid py-10">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-5 justify-content-center tes">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg container-fluid">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="text-center">
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

                            <div class="container ">
                                <div class="form-check">
                                    <input name="completed" class="form-check-input" type="checkbox" value="">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Show completed
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Show WIP
                                    </label>
                                </div>



                            @foreach($tasks as $task)
                                <div>
                                    <table>
                                        <div class="border-b border-gray-200">
                                            <td class="col task-font @if ($task->completed) linethrough @endif">{{$task->description}}
                                            </td>
                                        </div>

                                        <td>
                                            @if($task->completed)
                                                <form class="col" action="{{route('todo', $task)}}" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success">Done</button>
                                                </form>
                                            @else
                                                <form class="col"
                                                      action="{{route('complete', $task)}}" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-warning" type="submit">To-do</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="col">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#exampleModalCenter{{$task}}">
                                                Details
                                            </button>
                                        </td>
                                        <td class="col">
                                            <form
                                                action="{{route('delete', $task)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">delete</button>
                                            </form>
                                        </td>
                                    </table>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalCenter{{$task}}" tabindex="-1"
                                     role="dialog"
                                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Task</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <td>Task description: {{$task->description}}</td>
                                                <br>
                                                @if($task->completed === 0)
                                                    <td>Task status: {{' Not done'}}</td>
                                                @else
                                                    <td>Task status: {{' Done'}}</td><br>
                                                    <td>Task completed: {{$task->completed_at}}</td>
                                                @endif
                                                <br>
                                                <td>Task created: {{$task->created_at}}</td>
                                                <br>
                                                <td>Task updated:{{$task->updated_at}}</td>

                                                @foreach(\App\Models\Image::where('task_id', $task->id)->get() as $image)
                                                    <img class="img-fluid"
                                                         src="{{\Illuminate\Support\Facades\Storage::url($image->image)}}"
                                                         alt="test">
                                                    <form class="col-6 align-content-lg-center"
                                                          action="{{route('delete-image', $image)}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit">delete</button>
                                                    </form><br>
                                                @endforeach

                                                @if ($message = Session::get('success'))
                                                    <div class="alert alert-success alert-block">
                                                        <strong>{{$message}}</strong>
                                                    </div>
                                                @endif

                                                <form action="{{ route('add-image', $task->id) }}" method="POST"
                                                      class="shadow p-12"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col">
                                                        <input type="hidden" name="task_id"
                                                               value="{{$task->id}}">
                                                        <label class="block mb-4">
                                                            <span class="sr-only">Choose File</span>
                                                            <input type="file" name="image"
                                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                                                    file:rounded-full file:border-0 file:text-sm file:font-semibold
                                                                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                                                            @error('image')
                                                            <span
                                                                class="text-red-600 text-sm">{{ $message }}</span>
                                                            @enderror
                                                        </label>
                                                    </div>


                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Save changes
                                                            </button>
                                                        </div>


                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
