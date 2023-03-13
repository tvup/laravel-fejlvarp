<?php

namespace Tvup\LaravelFejlVarp\View\Components;

use Illuminate\View\Component;
use Tvup\LaravelFejlVarp\Incident;

class Ago extends Component
{
    public $created;

    public $last_seen_at;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($hash)
    {
        $incident = Incident::whereHash($hash)->firstOrFail();

        $now = time();

        $this->created = $this->getStr($now, $incident->created_at);
        $this->last_seen_at = $this->getStr($now, $incident->last_seen_at);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('laravelfejlvarp::components.ago');
    }

    /**
     * @param int $now
     * @param $input
     * @return string
     */
    public function getStr(int $now, $input): string
    {
        $periods = ['second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade'];
        $lengths = ['60', '60', '24', '7', '4.35', '12', '10'];

        $difference = $now - strtotime($input);
        $tense = 'ago';

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        if ($difference != 1) {
            $periods[$j] .= 's';
        }

        $output = $difference . ' ' . $periods[$j] . ' ' . $tense;

        return $output;
    }
}
