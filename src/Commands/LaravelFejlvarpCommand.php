<?php

namespace Tvup\LaravelFejlvarp\Commands;

use Illuminate\Console\Command;

class LaravelFejlvarpCommand extends Command
{
    public $signature = 'laravel-fejlvarp:myobby';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
