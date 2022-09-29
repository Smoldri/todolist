<html>
<head>
    <link href="{{asset('js/app.js')}}" rel="stylesheet">
    <title> To do app</title>
</head>
<h3>To Do App</h3>

    <div>
        <div>
            <div>
                <form  action="store" method="POST">
                    @csrf
                    <div>
                        <label for="description">Enter a task here</label>
                        <input id="description" name = "description" type="text" placeholder="New task" item="item"/>
                    </div>
                    <div>
                        <button type= "submit">Save</button>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 align-self-center">
                            <ul class="list-group">
                                <li class="list-group-item">Dummy todo here</li>
                                <li class="list-group-item">Dummy todo here</li>
                                <li class="list-group-item">Dummy todo here</li>

                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div>

        </div>
    </div>

</html>


