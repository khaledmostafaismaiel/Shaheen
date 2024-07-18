@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        </ol>
                    </nav>

                    <div class="card-header">Jiras</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <ol class="list-group list-group-numbered">
                            @foreach($jiras as $jira)
                                <a href="/jiras/{{$jira->id}}">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div>{{$jira->name}}</div>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{$jira->teams()->count()}}</span>
                                    </li>
                                </a>
                            @endforeach
                        </ol>

                        {{ $jiras->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
