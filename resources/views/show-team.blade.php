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

                        <ol class="list-group">
                            @foreach($boards as $board)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <a href="/boards/{{$board->id}}">
                                            {{$board->name}}
                                        </a>
                                    </div>
                                    <form action="/boards/{{$board->id}}/issues/reset" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger text-dark">
                                            Reset
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ol>

                        {{ $boards->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
