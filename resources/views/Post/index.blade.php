<html>

    <head>
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>


<body>

    <div class="alert alert-danger">
        <h1>Post Management</h1>
    </div>

    <div>
        <h2 class='alert alert-info'>
            User Name : {{$user->name}}
        </h2>
    </div>

    {{-- if Auth user have ability of create post than show only --}}
    @can('create')
    <div>
        <h2 class='alert alert-success'>
        <a class='btn btn-success' href="{{route('post.create') }}">Add New Post</a>
        </h2>
    </div>
    @endcan

    <table class='table alert alert-warning'>
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Body</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($posts)

            @foreach($posts as $post)

                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->name }}</td>
                    <td>{{ $post->body }}</td>
                    <td>{{ $post->created_at->diffForHumans() }}</td>
                    <td>{{ $post->updated_at->diffForHumans() }}</td>
                    <td>
                        {{-- if Auth user have ability of edit post than show only --}}
                        @can('edit')
                        <a class ='btn btn-info' href="{{ route('post.edit',$post->id) }}">Edit</a>
                        @endcan

                        {{-- if Auth user have ability of delete post than show only --}}
                        @can('destroy')
                        <a class ='btn btn-danger' href="{{ route('post.destroy',$post->id) }}">Delete</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>

    </table>
    {{-- Logout Functionality --}}
    <div class="alert alert-danger">
        <div>
            <a class="btn btn-danger" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
    </div>
    </body>
</html>
