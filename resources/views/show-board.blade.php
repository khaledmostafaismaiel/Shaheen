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
                            <li class="breadcrumb-item"><a href="/boards/{{$board->id}}">{{$board->name}}</a></li>
                        </ol>
                    </nav>

                    <div class="card-header">Sprints</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <ol class="list-group">
                            @foreach($sprints as $sprint)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <a
                                                href="/boards/{{$board->id}}/sprints/{{$sprint['id']}}"
                                                @if( ! isset($sprint["startDate"]))
                                                    onclick="return false;"
                                                    tabindex="-1"
                                                    data-toggle="tooltip"
                                                    title="Sprint isn't started yet"
                                                @endif
                                            >
                                                {{$sprint['name']}}
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                ({{$sprint['state']}})
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
