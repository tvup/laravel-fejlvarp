@extends('fejlvarp::layouts.captain')

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
        <p><a href="{{ route('incidents.index') }}"><span style="font-weight:bold;font-size:32px;line-height:8px;">&larr;</span>
                List all incidents</a></p>
        <h1> {!! $incident->subject !!}
            @if($incident->resolved_at)
                <span class="resolved">RESOLVED</span>
            @else
                <span class="open">OPEN</span>
            @endif
        </h1>
    </div>

    <div class="page-content">
        @if(!$incident->resolved_at)
            <form method="POST" action="{{ route('incident.delete' , ['hash' => $incident->hash]) }}">
                @csrf
                <div class="action">
                    <p>If the incident has been resolved, please mark it by pressing this button:</p>
                    <p><input type="submit" value="Mark Resolved"/></p>
                </div>
            </form>
        @endif

        <table class="definitionlist">
            <tbody>
            @foreach(['hash', 'occurrences', 'created_at', 'last_seen_at', 'resolved_at'] as $name)
                @if(isset($incident[$name]))
                    <tr>
                        <th>{!! $name !!}</th>
                        <td>{!! $incident[$name] !!}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        @if(isset($incident->data['error']['type']))
            <h2>Error Details</h2>
            <table class="definitionlist">
                <tbody>
                @foreach(['type', 'code', 'file', 'line'] as $name)
                    @if(isset($incident->data['error'][$name]))
                        <tr>
                            <th> {!! $name !!}</th>
                            <td>{!! $incident->data['error'][$name] !!}</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <h2>Trace</h2>
            <pre>{!! $incident->data['error']['trace'] !!}</pre>
        @endif

        @if(isset($incident->data['environment']['SERVER']) && isset($incident->data['environment']['SERVER']['HTTP_HOST']))
            <h2>Request Synopsis</h2>
            <table class="definitionlist">
                <tbody>
                @foreach(['HTTP_HOST', 'REQUEST_URI', 'SERVER_ADDR', 'HTTP_REFERER'] as $name)
                    @if(isset($incident->data['environment']['SERVER'][$name]))
                        <tr>
                            <th>{!! $name !!}</th>
                            <td>{!! $incident->data['environment']['SERVER'][$name] !!}</td>
                        </tr>
                    @endif
                @endforeach

                @if ($user_agent)
                    <tr>
                        <th>HTTP_USER_AGENT</th>
                        <td>{!! $user_agent !!}
                            <span id="useragent">Loading ...</span>
                        </td>
                    </tr>
                @endif
                @if ($geoip)
                    <tr>
                        <th>CLIENT_IP</th>
                        <td>{!! $geoip !!}<span id="geoip">Loading ...</span></td>
                    </tr>
                @endif
                </tbody>
            </table>
        @endif

        @if(isset($incident->data['application_data']) && isset($incident->data['application_data']['user']))
            <h2>Application data - user</h2>
            <table class="definitionlist">
                <tbody>
                @forelse($incident->data['application_data']['user'] as $key => $value)
                    <tr>
                        <th>{!! $key !!}</th>
                        <td>{!! \Illuminate\Support\Str::trim(json_encode($value, JSON_PRETTY_PRINT+JSON_UNESCAPED_SLASHES),'"') !!}</td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        @endif


        @if (isset($incident->data['environment']))
            <h2>Request Context</h2>
            <pre>{!! var_export($incident->data['environment'], true) !!}</pre>
        @endif

        @if (isset($incident->data['queries']) && count($incident->data['queries'])>0)
            <div class="py-3">
                <h2>Database Queries</h2>
                @forelse($incident->data['queries'] as $query)
                    <dl class="mt-1 border dark:border-gray-800">
                        <div class="flex items-center gap-2 dark:border-gray-800">
                            <div class="flex-none px-5 py-1 border-r dark:border-gray-800 lg:w-[12rem]">
                                <span>{{$query['connectionName']}}</span>
                                <span class="text-xs text-gray-500">({{$query['time']}} ms)</span>
                            </div>
                            <span class="min-w-0 flex-grow">
                            <pre class="overflow-y-hidden text-xs lg:text-sm"><code class="px-5">{{\Illuminate\Support\Str::replaceArray('?' , $query['bindings'], $query['sql'])}}</code></pre>
                        </span>
                        </div>
                    </dl>
                @empty
                @endforelse
            </div>
        @endif

        @if (!isset($incident->data['error']['type']) && !isset($incident->data['environment']))
            {
            <h2>Data</h2>
            <pre>{!! var_export($incident->data, true) !!}</pre>
        @endif

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
