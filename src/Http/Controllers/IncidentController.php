<?php

namespace Tvup\LaravelFejlVarp\Http\Controllers;

use Tvup\LaravelFejlVarp\Incident;
use Illuminate\Http\Request;
use PDO;

class IncidentController extends \App\Http\Controllers\Controller
{
    private pdo $db;

    private mixed $config;

    private string $server_name;

    public function __construct()
    {
        $this->config = config('laravelfejlvarp');
        $this->server_name = ('app.url') . '/api/incidents';
        $dsn = 'mysql:host=' . config('database.connections.app_api_no_prefix.host') . (config('database.connections.app_api_no_prefix.port') ? ':' . config('database.connections.app_api_no_prefix.port') : '') . ';dbname=' . config('database.connections.app_api_no_prefix.database');
        $this->db = new PDO($dsn, config('database.connections.app_api_no_prefix.username'), config('database.connections.app_api_no_prefix.password'));
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        $q = $this->db->prepare('UPDATE incidents SET resolved_at = NOW() WHERE hash = :hash');
        $q->execute(
            [
                ':hash' => $hash]
        );

        return back();
    }

    public function destroyAll()
    {
        $this->fejlvarp_prune_old();

        return redirect()->route('incidents.index');
    }

    public function fejlvarp_prune_old()
    {
        $this->db->exec('UPDATE incidents SET resolved_at = NOW() WHERE last_seen_at < DATE_ADD(NOW(), INTERVAL -1 DAY) and resolved_at is null');
    }

    public function fejlvarp_find_incident($hash)
    {
        Incident::whereHash($hash)->firstOrFail();
        $q = $this->db->prepare('SELECT * FROM incidents WHERE hash = :hash');
        $q->execute([':hash' => $hash]);
        $row = $q->fetch(PDO::FETCH_ASSOC);
        $decoded = json_decode($row['data'], true);
        if ($decoded) {
            $row['data'] = $decoded;
        }

        return $row;
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
