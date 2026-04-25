<?php

namespace Tvup\LaravelFejlvarp\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AssetController
{
    public function css(): BinaryFileResponse
    {
        return response()->file(
            dirname(__DIR__, 3) . '/public/app.css',
            ['Content-Type' => 'text/css']
        );
    }

    public function favicon(): BinaryFileResponse
    {
        return response()->file(
            dirname(__DIR__, 3) . '/public/incidents.ico',
            ['Content-Type' => 'image/x-icon']
        );
    }
}
