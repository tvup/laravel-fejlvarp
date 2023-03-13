<?php

namespace Tvup\LaravelFejlVarp\Commands;

use Illuminate\Console\Command;

class LaravelFejlVarpCommand extends Command
{
    public $signature = 'laravelfejlvarp';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
