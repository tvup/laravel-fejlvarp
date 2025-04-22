@extends('fejlvarp::layouts.captain')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <p class="mb-4">
                        <a href="{{ route('incidents.index') }}" class="flex items-center text-blue-600 hover:underline">
                            <span class="text-3xl font-bold leading-none mr-2">&larr;</span> List all incidents
                        </a>
                    </p>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        {!! $incident->subject !!}
                        @if($incident->resolved_at)
                            <span class="text-green-600 font-semibold text-sm">RESOLVED</span>
                        @else
                            <span class="text-red-600 font-semibold text-sm">OPEN</span>
                        @endif
                    </h1>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900 bg-opacity-50 border border-gray-300 dark:border-gray-700 p-6 lg:p-8 grid grid-cols-1 gap-6">

                    @if(!$incident->resolved_at)
                        <form method="POST" action="{{ route('incident.delete', ['hash' => $incident->hash]) }}">
                            @csrf
                            <div>
                                <p class="text-gray-700 dark:text-gray-300 mb-2">If the incident has been resolved, please mark it by pressing this button:</p>
                                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md">
                                    Mark Resolved
                                </button>
                            </div>
                        </form>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                            <tbody>
                            @foreach(['hash', 'occurrences', 'created_at', 'last_seen_at', 'resolved_at'] as $name)
                                @if(isset($incident[$name]))
                                    <tr class="border-t border-gray-200 dark:border-gray-700">
                                        <th class="px-4 py-2 font-semibold">{{ $name }}</th>
                                        <td class="px-4 py-2">{{ $incident[$name] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if(isset($incident->data['error']['type']))
                        <div>
                            <h2 class="text-xl font-bold mb-2">Error Details</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                                    <tbody>
                                    @foreach(['type', 'code', 'file', 'line'] as $name)
                                        @if(isset($incident->data['error'][$name]))
                                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                                <th class="px-4 py-2 font-semibold">{{ $name }}</th>
                                                <td class="px-4 py-2">{{ $incident->data['error'][$name] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <h2 class="text-xl font-bold mt-6 mb-2">Trace</h2>
                            <pre class="bg-gray-100 dark:bg-gray-700 p-4 rounded text-xs overflow-x-auto">{!! $incident->data['error']['trace'] !!}</pre>
                        </div>
                    @endif

                    @if(isset($incident->data['environment']['SERVER']) && isset($incident->data['environment']['SERVER']['HTTP_HOST']))
                        <div>
                            <h2 class="text-xl font-bold mb-2">Request Synopsis</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                                    <tbody>
                                    @foreach(['HTTP_HOST', 'REQUEST_URI', 'SERVER_ADDR', 'HTTP_REFERER'] as $name)
                                        @if(isset($incident->data['environment']['SERVER'][$name]))
                                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                                <th class="px-4 py-2 font-semibold">{{ $name }}</th>
                                                <td class="px-4 py-2">{{ $incident->data['environment']['SERVER'][$name] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    @if ($user_agent)
                                        <tr class="border-t border-gray-200 dark:border-gray-700">
                                            <th class="px-4 py-2 font-semibold">HTTP_USER_AGENT</th>
                                            <td class="px-4 py-2">
                                                {{ $user_agent }}
                                                <span id="useragent" class="ml-2 text-sm text-gray-500">Loading...</span>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($geoip)
                                        <tr class="border-t border-gray-200 dark:border-gray-700">
                                            <th class="px-4 py-2 font-semibold">CLIENT_IP</th>
                                            <td class="px-4 py-2">
                                                {{ $geoip }}
                                                <span id="geoip" class="ml-2 text-sm text-gray-500">Loading...</span>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if(isset($incident->data['application_data']['user']))
                        <div>
                            <h2 class="text-xl font-bold mb-2">Application data - user</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                                    <tbody>
                                    @forelse($incident->data['application_data']['user'] as $key => $value)
                                        <tr class="border-t border-gray-200 dark:border-gray-700">
                                            <th class="px-4 py-2 font-semibold">{{ $key }}</th>
                                            <td class="px-4 py-2">{{ \Illuminate\Support\Str::of(json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))->trim('"') }}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if (isset($incident->data['environment']))
                        <div>
                            <h2 class="text-xl font-bold mb-2">Request Context</h2>
                            <pre class="bg-gray-100 dark:bg-gray-700 p-4 rounded text-xs overflow-x-auto">{!! var_export($incident->data['environment'], true) !!}</pre>
                        </div>
                    @endif

                    @if (isset($incident->data['queries']) && count($incident->data['queries']) > 0)
                        <div>
                            <h2 class="text-xl font-bold mb-2">Database Queries</h2>
                            <div class="flex flex-col gap-4">
                                @foreach($incident->data['queries'] as $query)
                                    <dl class="flex flex-col lg:flex-row border border-gray-200 dark:border-gray-800 rounded-md overflow-hidden">
                                        <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700 lg:w-48 flex flex-col justify-center">
                                            <span class="font-semibold">{{ $query['connectionName'] }}</span>
                                            <span class="text-xs text-gray-500">{{ $query['time'] }} ms</span>
                                        </div>
                                        <div class="flex-1 p-4 overflow-x-auto">
                                            <pre class="text-xs">{{ \Illuminate\Support\Str::replaceArray('?', $query['bindings'], $query['sql']) }}</pre>
                                        </div>
                                    </dl>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (!isset($incident->data['error']['type']) && !isset($incident->data['environment']))
                        <div>
                            <h2 class="text-xl font-bold mb-2">Data</h2>
                            <pre class="bg-gray-100 dark:bg-gray-700 p-4 rounded text-xs overflow-x-auto">{!! var_export($incident->data, true) !!}</pre>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($user_agent)
        <script>
            function useragentCallback(data) {
                document.getElementById("useragent").innerHTML = data.name ? ("[" + data.type + " - " + data.info + "]") : "";
            }
        </script>
        <script src="/api/useragent/?useragent={{ $user_agent }}&callback=useragentCallback"></script>
    @endif

    @if ($geoip)
        <script>
            function geoipCallback(data) {
                document.getElementById("geoip").innerHTML = data.country_name ? ("[" + data.country_flag_emoji + data.country_name + (data.region_name ? (" - " + data.region_name) : "") + "]") : "";
            }
        </script>
        <script src="/api/geoip?ip={{ $geoip }}&callback=geoipCallback"></script>
    @endif
@endsection
