@extends('fejlvarp::layouts.captain')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <h1 class="flex items-center space-x-2 text-2xl font-bold">
                        <img src="{{ asset('vendor/fejlvarp/incidents.ico') }}" alt="Incidents" class="w-8 h-8">
                        <span>Incidents</span>
                    </h1>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900 bg-opacity-50 border border-gray-300 dark:border-gray-700 p-6 lg:p-8 grid grid-cols-1 gap-6">
                    <div>
                        @if($show_all)
                            <p class="text-gray-700 dark:text-gray-300">
                                Show
                                <a href="{{ route('incidents.index') }}" class="text-blue-600 hover:underline">just open incidents</a>
                                or
                                <span class="font-semibold">all incidents</span>
                            </p>
                        @else
                            <p class="text-gray-700 dark:text-gray-300">
                                Show
                                <span class="font-semibold">just open incidents</span>
                                or
                                <a href="{{ route('incidents.index', ['show_all'=>'true']) }}" class="text-blue-600 hover:underline">all incidents</a>
                            </p>
                        @endif
                    </div>

                    @if(!$incidents)
                        <p class="text-gray-500 dark:text-gray-400">There are no incidents to show.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto text-left text-sm text-gray-700 dark:text-gray-300">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2">State</th>
                                    <th class="px-4 py-2">Subject</th>
                                    <th class="px-4 py-2">Created</th>
                                    <th class="px-4 py-2">Last seen</th>
                                    <th class="px-4 py-2">Occurrences</th>
                                    <th class="px-4 py-2">Resolve?</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($incidents as $incident)
                                    <tr class="border-t border-gray-200 dark:border-gray-700">
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            @if($incident->resolved_at !== null)
                                                <span class="text-green-600 font-semibold">RESOLVED</span>
                                            @else
                                                <span class="text-red-600 font-semibold">OPEN</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="/incidents/{!! rawurlencode($incident->hash) !!}" class="text-blue-600 hover:underline">{!! $incident->subject !!}</a>
                                        </td>

                                        <x-fejlvarp-ago :hash="$incident->hash" />

                                        <td class="px-4 py-2 whitespace-nowrap">{{ $incident->occurrences }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            @if($incident->resolved_at === null)
                                                <form method="POST" action="{{ route('incident.delete', ['hash' => $incident->hash]) }}">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded-md text-xs">Mark Resolved</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div>
                        <form method="POST" action="{{ route('incidents.delete') }}">
                            @csrf
                            <button type="submit" class="mt-6 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md">
                                Prune old incidents
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
