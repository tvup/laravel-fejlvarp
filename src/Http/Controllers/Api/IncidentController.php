<?php

namespace Tvup\LaravelFejlVarp\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tvup\LaravelFejlVarp\Http\Requests\IncidentStoreRequest;
use Tvup\LaravelFejlVarp\Incident;

class IncidentController
{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private mixed $config;

    private mixed $pushover_apitoken;

    private mixed $pushover_userkey;

    private mixed $slack_webhook_url;

    private $ipStackAccessKey;

    private string $server_name;

    public function __construct()
    {
        $this->config = config('laravelfejlvarp');
        $this->server_name = config('app.url') . '/incidents';
        $this->pushover_apitoken = $this->config['pushover']['apitoken'];
        $this->pushover_userkey = $this->config['pushover']['userkey'];
        $this->slack_webhook_url = $this->config['slack']['webhook_url'];
        $this->ipStackAccessKey = $this->config['ipstack']['access_key'];
    }

    public function store(IncidentStoreRequest $request)
    {
        ['hash' => $hash, 'subject' => $subject, 'data' => $data] = $request->validated();
        $this->fejlvarp_log($hash, Str::substr($subject, 0, 255), $data);

        return response('OK', 200);
    }

    public function geoip(Request $request)
    {
        $ip = $request->query('ip');
        $callback = $request->query('callback');
        $parts = explode(',', $ip);
        $ip = $parts[0];

        $data = null;
        if (!$this->ip_in_range($ip, '10.0.0.0/8') && !$this->ip_in_range($ip, '172.16.0.0/12') && !$this->ip_in_range($ip, '192.168.0.0/16')) {
            $seconds = 60 * 60 * 24 * 30;
            $data = cache()->remember('ip-' . $ip, $seconds, function () use ($ip) {
                $url = 'http://api.ipstack.com/' . rawurlencode($ip) . '?access_key=' . $this->ipStackAccessKey;
                $json = file_get_contents($url);

                return json_decode($json, true);
            });
        }
        $response = $data ? [
            'country_name' => $data['country_name'],
            'region_name' => $data['region_name'],
        ] : null;

        header('Content-Type: text/javascript');
        $content = !empty($response) ? json_encode($response) : null;
        if (isset($callback)) {
            echo $callback . '(' . ($content ?: '{}') . ');';
        } else {
            echo $content ?: '{}';
        }
    }

    public function useragent(Request $request)
    {
        $useragent = $request->query('useragent');
        $callback = $request->query('callback');
        $url = 'http://www.useragentstring.com/?getJSON=all&uas=' . rawurlencode($useragent);
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => "Accept: application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5\r\n" .
                    "User-Agent: BrobizzApp\r\n" .
                    "Accept-Language: en-US,en;q=0.8\r\n" .
                    "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3\r\n",
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];
        $context = stream_context_create($opts);
        $raw = file_get_contents($url, false, $context);
        $data = json_decode($raw, true);
        $response = [];
        $response['name'] = $data['agent_name'];
        $response['type'] = $data['agent_type'];
        $response['info'] = implode(' / ', array_filter(array_values($data)));
        header('Content-Type: text/javascript');
        $content = json_encode($response);
        if (isset($callback)) {
            echo $callback . '(' . $content . ');';
        } else {
            echo $content;
        }
    }

    private function fejlvarp_log($hash, $subject, $data)
    {
        $notification = null;
        $incident = null;

        DB::transaction(function () use (&$notification, &$incident, $hash, $subject, $data) {
            /** @var Incident $incident */
            $incident = Incident::firstOrNew(['hash' => $hash]);

            if ($incident->exists && $incident->resolved_at) {
                $notification = 'REOPEN';
            } else {
                $notification = 'NEW';
            }

            $incident->last_seen_at = Carbon::now('Europe/Copenhagen');
            $incident->subject = $subject;
            $incident->data = json_decode($data, true);
            $incident->occurrences = $incident->exists ? $incident->occurrences + 1 : 1;
            $incident->save();
        });

        if ($notification) {
            $this->fejlvarp_notify($notification, $incident);
        }
    }

    private function fejlvarp_notify($notification, $incident)
    {
        $title = "[$notification] " . $incident->subject;
        $msg = var_export($incident, true);
        $uri = $this->server_name . '/' . rawurlencode($incident->hash);
        $this->notify_mail($title, $msg, $uri);
        $this->notify_pushover($title, $msg, $uri);
        $this->notify_slack($title, $msg, $uri);
    }

    private function notify_mail($title, $msg, $uri)
    {
        if (isset($this->mail_recipient) && $this->mail_recipient) {
            mail($this->mail_recipient, $title, "An incident has occurred. Once you have resolved the issue, please visit the following link and mark it as such:\n\n" . $uri . "\n\n------------\n\n" . $msg);
        }
    }

    private function notify_pushover($title, $msg, $uri)
    {
        // https://pushover.net/api
        if (isset($this->pushover_apitoken) && $this->pushover_apitoken) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.pushover.net/1/messages.json');
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, [
                'token' => $this->pushover_apitoken,
                'user' => $this->pushover_userkey,
                'title' => $title,
                'message' => $msg,
                'url' => $uri,
                'url_title' => 'See incident',
            ]);
            curl_exec($curl);
        }
    }

    private function notify_slack($title, $msg, $uri)
    {
        if (isset($this->slack_webhook_url) && $this->slack_webhook_url) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->slack_webhook_url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, [
                'payload' => json_encode(['text' => $title . ' <' . $uri . '|See more>']),
            ]);
            curl_exec($curl);
        }
    }

    /**
     * Check if a given ip is in a network.
     * @param string $ip IP to check in IPV4 format eg. 127.0.0.1
     * @param string $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
     * @return bool true if the ip is in this range / false if not.
     */
    private function ip_in_range($ip, $range)
    {
        if (strpos($range, '/') == false) {
            $range .= '/32';
        }
        // $range is in IP/CIDR format eg 127.0.0.1/24
        list($range, $netmask) = explode('/', $range, 2);
        $range_decimal = ip2long($range);
        $ip_decimal = ip2long($ip);
        $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
        $netmask_decimal = ~$wildcard_decimal;

        return ($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal);
    }
}
