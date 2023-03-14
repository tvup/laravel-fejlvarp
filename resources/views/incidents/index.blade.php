@extends('laravelfejlvarp::layouts.captain')

@push('styles')
    <style>
        * {
            font-family: "Monaco", "Courier New", monospace;
            font-size: 12px;
        }

        input[type=submit] {
            border-width: 1px;
            border-color: rgb(118, 118, 118);
            border-radius: 2px;
            line-height: normal;
            padding: 1px 6px;
            color: rgb(0,0,0);
            font-family: "Monaco", "Courier New", monospace;
            font-size: 12px;
        }

        body {
            -webkit-text-size-adjust: none;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, h4 {
            font-family: "Lucida Grande", Helvetica, Arial, Freesans, Clean, sans-serif;
        }

        h1 {
            font-size: 200%;
        }

        h2 {
            font-size: 150%;
        }

        h3 {
            font-size: 125%;
        }

        h4 {
            font-size: 110%;
        }

        .resolved, .open {
            padding: 2px;
            border-radius: 2px;
            color: white;
        }

        .resolved {
            background-color: green;
        }

        .open {
            background-color: red;
        }

        h1 .resolved, h1 .open {
            vertical-align: middle;
        }

        h1 img {
            margin-right: 8px;
            vertical-align: middle;
        }

        a:hover {
            text-decoration: none;
        }

        table.list {
            width: 100%;
            margin: 0;
            padding: 0;
            border-collapse: collapse;
            border-spacing: 0;
            border: 1px solid #d8d8d8;
            -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
            -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
        }

        table.list td, table.list th {
            padding: 5px;
        }

        table.list td.nobreak {
            white-space: nowrap;
        }

        table.list th {
            color: #afafaf;
            font-weight: normal;
        }

        table.list tr {
            background-color: #eaeaea;
            height: 2.5em;
            border-bottom: 1px solid #e1e1e1;
            text-align: left;
        }

        table.list tbody tr {
            background: #F9F9F9; /* old browsers */
            background: -moz-linear-gradient(top, #F9F9F9 0%, #EFEFEF 100%); /* firefox */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #F9F9F9), color-stop(100%, #EFEFEF)); /* webkit */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#F9F9F9', endColorstr='#EFEFEF', GradientType=0); /* ie */
            color: #545454;
        }

        #page-header {
            padding: 0 27px;
            margin-bottom: 20px;
            padding-top: 8px;
            background: #FFFFFF; /* old browsers */
            background: -moz-linear-gradient(top, #FFFFFF 0%, #F5F5F5 100%); /* firefox */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #FFFFFF), color-stop(100%, #F5F5F5)); /* webkit */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFF', endColorstr='#F5F5F5', GradientType=0); /* ie */
            border-bottom: 1px solid #dfdfdf;
        }

        .page-content {
            padding: 0 27px;
        }

        .action {
            margin: 0 auto 15px auto;
            background: #eaf2f5;
            border: 1px solid #bedce7;
            padding: 5px;
        }

        .action span {
            padding: 2px;
            border-radius: 2px;
            color: white;
            background-color: #333;
        }

        pre {
            border: 1px solid #fadd87;
            background-color: #fbecc5;
            padding: 4px;
            overflow-y: auto;
        }

        table.definitionlist th {
            min-width: 12em;
            text-align: left;
            font-weight: bold;
        }

        table.definitionlist th,
        table.definitionlist td {
            padding: 5px;
        }
    </style>
@endpush

@section('content')

    <div id="page-header">
        <h1><img src="incidents.ico" height="32px" width="32px"/>Incidents</h1>
    </div>
    <div class="page-content">

        <div class="action">
            @if($show_all)
                <p>Show <a href="{{ route('incidents.index') }}">just open incidents</a> or <span>all incidents</span></p>
            @else
                <p>Show <span>just open incidents</span> or <a href="{{ route('incidents.index', ['show_all'=>'true']) }}">all incidents</a></p>
            @endif
        </div>

        @if(!$incidents)
            <p>There are no incidents to show</p>
        @else
            <table class="list">
                <thead>
                <tr>
                    <th>State</th>
                    <th>Subject</th>
                    <th>Created</th>
                    <th>Last seen</th>
                    <th>Occurrences</th>
                    <th>Resolve?</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($incidents as $incident)
                    <tr>
                        <td class="nobreak">
                            @if($incident['resolved_at'])
                                <span class="resolved">RESOLVED</span>
                            @else
                                <span class="open">OPEN</span>
                            @endif
                        </td>
                        <td>
                            <a href="/incidents/{!! rawurlencode($incident['hash']) !!}">{!! $incident['subject'] !!}</a>
                        </td>
                        <x-laravelfejlvarp-ago :hash="$incident['hash']" class="mt-4"/>
                        <td class="nobreak">{{ $incident['occurrences'] }}</td>

                        <td class="nobreak">
                            <form method="POST" action="{{ route('incident.delete' , ['hash' => $incident['hash']]) }}">
                                @csrf
                                <input type="submit" value="Mark Resolved"/>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <br/>
        <div class="action">
            <form method="post" action="{{ route('incidents.delete') }}">
                @csrf
                <p><input type="submit" value="Prune old incidents"/></p>
            </form>
        </div>

    </div>

    @if ($user_agent)
        <script type="text/javascript">
            function useragentCallback(data) {
                document.getElementById("useragent").innerHTML = data.name ? ("[" + data.type + " - " + data.info + "]") : "";
            }
        </script>
        <script type="text/javascript"
                src="/api/useragent/?useragent={{ $user_agent }}&callback=useragentCallback"></script>
    @endif
    @if ($geoip)
        <script type="text/javascript">
            function geoipCallback(data) {
                document.getElementById("geoip").innerHTML = data.country_name ? ("[" + data.country_name + (data.region_name && (" - " + data.region_name)) + "]") : "";
            }
        </script>
        <script type="text/javascript"
                src="/api/geoip?ip={{ $geoip }}&callback=geoipCallback"></script>
    @endif

@endsection
