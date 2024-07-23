@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/jiras/{{$jira->id}}">{{$jira->name}}</a></li>
                            <li class="breadcrumb-item"><a href="/teams/{{$team->id}}">{{$team->name}}</a></li>
                        </ol>
                    </nav>

                    <div class="card-header">Boards</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <ol class="list-group list-group-numbered">
                            @foreach($boards as $board)
                                <a href="/boards/{{$board->id}}">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div>{{$board->name}}</div>
                                        </div>
                                    </li>
                                </a>
                            @endforeach
                        </ol>

                        {{ $boards->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
