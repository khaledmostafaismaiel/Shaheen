@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/jiras/{{$jira->id}}">{{$jira->name}}</a></li>
                            <li class="breadcrumb-item"><a href="/teams/{{$team->id}}">{{$team->name}}</a></li>
                            <li class="breadcrumb-item"><a href="/boards/{{$board->id}}">{{$board->name}}</a></li>
                            <li class="breadcrumb-item"><a href="/boards/{{$board->id}}/sprints/{{$sprint['id']}}">{{$sprint['name']}}</a></li>
                        </ol>
                    </nav>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>
    <div id="gantt_here" style='width:100%; height:1000px;'></div>

    @php
        $sprintStartDate = \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $sprint['startDate'])->format('Y-m-d');
        $sprintEndDate = \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $sprint['endDate'])->format('Y-m-d');
    @endphp

    <script type="text/javascript">
        gantt.config.start_date = "{{$sprintStartDate}}";
        gantt.config.end_date = "{{$sprintEndDate}}";
        gantt.config.xml_date = "%Y-%m-%d";
        gantt.config.columns = [
            { name: "name", label: "Task", tree: true },
            { name: "original_estimates", label: "Original" },
            { name: "remaining_estimates", label: "Remaining" },
            { name: "assignee", label: "Assignee" }
        ];
        gantt.config.readonly = '{{$readOnly}}';

        gantt.config.work_time = true;

        gantt.init("gantt_here");

        gantt.load("/api/boards/{{$board->id}}/sprints/{{$sprint['id']}}/issues?sprintStartDate={{$sprintStartDate}}&sprintEndDate={{$sprintEndDate}}")
    </script>
@endsection
