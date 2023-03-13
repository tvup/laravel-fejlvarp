<?php

namespace Tvup\LaravelFejlVarp\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Tvup\LaravelFejlVarp\Incident;

class IncidentController extends \App\Http\Controllers\Controller
{
    private mixed $config;

    private string $server_name;

    public function __construct()
    {
        $this->config = config('laravelfejlvarp');
        $this->server_name = ('app.url') . '/api/incidents';
    }

    public function index(Request $request)
    {
        $show_all = false;
        if ($request->boolean('show_all')) {
            $show_all = true;
        }
        $incidents = $this->fejlvarp_select_incidents($show_all);

        return view('laravelfejlvarp::incidents.index', ['show_all' => $show_all, 'incidents' => $incidents, 'user_agent' => '', 'geoip' => '']);
    }

    public function show($hash)
    {
        $incident = $this->fejlvarp_find_incident($hash);
        $geoip = null;
        if (isset($incident['data']['environment']['SERVER']['HTTP_X_FORWARDED_FOR'])) {
            $geoip = $incident['data']['environment']['SERVER']['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($incident['data']['environment']['SERVER']['REMOTE_ADDR'])) {
            $geoip = $incident['data']['environment']['SERVER']['REMOTE_ADDR'];
        }

        $user_agent = $incident['data']['environment']['SERVER']['HTTP_USER_AGENT'] ?? null;

        return view('laravelfejlvarp::incidents.show', ['incident' => $incident, 'server_name' => $this->server_name, 'user_agent' => $user_agent, 'geoip' => $geoip]);
    }

    public function destroy($hash)
    {
        /** @var Incident $incident */
        $incident = Incident::whereHash($hash)->firstOrFail();
        $incident->resolved_at = Carbon::now('Europe/Copenhagen');
        $incident->save();
        return back();
    }

    public function destroyAll()
    {
        $this->fejlvarp_prune_old();

        return redirect()->route('incidents.index');
    }

    public function fejlvarp_prune_old()
    {
        Incident::where('last_seen_at', '<', Carbon::now('Europe/Copenhagen')->subDay())->whereNull('resolved_at')->delete();
    }

    public function fejlvarp_find_incident($hash)
    {
        return Incident::whereHash($hash)->firstOrFail();
    }

    public function fejlvarp_select_incidents($include_closed = false)
    {
        if ($include_closed) {
            return Incident::orderBy('last_seen_at', 'desc')->get();
        }
        $collection = Incident::whereNull('resolved_at')->orderBy('last_seen_at', 'desc')->get();

        return $collection->count() != 0 ? $collection : null;
    }
}
