
<x-app-layout>
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
</x-app-layout>
