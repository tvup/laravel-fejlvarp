<?php

namespace Tvup\LaravelFejlvarp\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Tvup\LaravelFejlvarp\Incident;

class IncidentController
{
    private string $server_name;

    public function __construct()
    {
        $config = config('app.url');
        assert(is_string($config));
        $this->server_name = $config . '/api/incidents';
    }

    public function index(Request $request) : View
    {
        $show_all = false;
        if ($request->boolean('show_all')) {
            $show_all = true;
        }
        $incidents = $this->fejlvarp_select_incidents($show_all);

        /** @var view-string $view */
        $view = 'fejlvarp::incidents.index';

        return view($view, ['show_all' => $show_all, 'incidents' => $incidents, 'user_agent' => '', 'geoip' => '']);
    }

    public function show(string $hash) : View
    {
        $incident = $this->fejlvarp_find_incident($hash);
        $geoip = null;
        if (null !== $incident->data && isset($incident->data['environment']['SERVER']['HTTP_X_FORWARDED_FOR'])) {
            $geoip = $incident->data['environment']['SERVER']['HTTP_X_FORWARDED_FOR'];
        } elseif (null !== $incident->data && isset($incident->data['environment']['SERVER']['REMOTE_ADDR'])) {
            $geoip = $incident->data['environment']['SERVER']['REMOTE_ADDR'];
        }

        $user_agent = $incident->data['environment']['SERVER']['HTTP_USER_AGENT'] ?? null;

        /** @var view-string $view */
        $view = 'fejlvarp::incidents.show';

        return view($view, ['incident' => $incident, 'server_name' => $this->server_name, 'user_agent' => $user_agent, 'geoip' => $geoip]);
    }

    public function destroy(string $hash) : RedirectResponse
    {
        /** @var Incident $incident */
        $incident = Incident::whereHash($hash)->firstOrFail();
        $incident->resolved_at = now();
        $incident->save();

        return back();
    }

    public function destroyAll() : RedirectResponse
    {
        $this->fejlvarp_prune_old();

        return redirect()->route('incidents.index');
    }

    private function fejlvarp_prune_old() : void
    {
        Incident::where('last_seen_at', '<', now()->subDay())->whereNull('resolved_at')->delete();
    }

    private function fejlvarp_find_incident(string $hash) : Incident
    {
        return Incident::whereHash($hash)->firstOrFail();
    }

    /**
     * @param bool $include_closed
     * @return Collection<int, Incident>|null
     */
    private function fejlvarp_select_incidents(bool $include_closed = false) : ?Collection
    {
        if ($include_closed) {
            return Incident::orderBy('last_seen_at', 'desc')->get();
        }
        $collection = Incident::whereNull('resolved_at')->orderBy('last_seen_at', 'desc')->get();

        return $collection->count() != 0 ? $collection : null;
    }
}
