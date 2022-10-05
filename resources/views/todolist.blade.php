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
                            @if(session()->has('success'))
                                <div class="alert alert-success alert-block">
                                    <p>{{session('success')}}</p>
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
                                <form method="get" action="#" id="filter">
                                    <input

                                        name="status"
                                        id="status"
                                        type="radio"
                                        value="1"
                                        onclick="this.form.submit()"


                                    >
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Show completed tasks
                                    </label><br>
                                    <input

                                        name="status"
                                        id="status"
                                        type="radio"
                                        value="2"
                                        onclick="this.form.submit()"


                                    >
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Show todo tasks
                                    </label><br>
                                    <input
                                        name="status"
                                        id="status"
                                        type="radio"
                                        value=""
                                        onclick="this.form.submit()"

                                    >
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Show all tasks
                                    </label><br>
                                </form>
                                <br>
                            </div>


                            <div class="container ">
                                <div class="form-check">
                                    <form method="get" action="#">
                                        <input
                                            name="search-description"
                                            id="search-description"
                                            type="text"
                                            placeholder="Find tasks by name"
                                        >
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </form>
                                    <br>
                                </div>


                                @foreach($tasks as $task)
                                    <div>
                                        <table>
                                            <div class="border-b border-gray-200">
                                                <td class="col task-font @if ($task->completed === 1) linethrough @endif">{{$task->description}}
                                                </td>
                                            </div>

                                            <td>
                                                @if($task->completed === 2)
                                                    <form class="col" action="{{route('complete', $task)}}"
                                                          method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-warning">To-do</button>
                                                    </form>
                                                @else
                                                    <form class="col"
                                                          action="{{route('todo', $task)}}" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-success" type="submit">Done</button>
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

                                                    @forelse(\App\Models\Image::where('task_id', $task->id)->get() as $image)
                                                        <img class="img-fluid"
                                                             src="{{\Illuminate\Support\Facades\Storage::url($image->image)}}"
                                                             alt="">

                                                        <form class="col-6 align-content-lg-center"
                                                              action="{{route('delete-image', $image)}}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger" type="submit">delete</button>
                                                        </form><br>
                                                    @empty

                                                    @endforelse

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
        </div>

    </section>


    <script>
        $('input[type=radio]').click(function () {
            $("filter").submit();
        });
        $(document).ready(function () {
            $("input:radio:checked").data("chk", true);
            $("input:radio").click(function () {
                $("input[name='status" + $(this).attr("status") + "']:radio").not(this).removeData("chk");
                $(this).data("chk", !$(this).data("chk"));
                $(this).prop("checked", $(this).data("chk"));
                $(this).button('refresh'); // in case you change the radio elements dynamically
            });
        });

    </script>

    </body>

</x-app-layout>
