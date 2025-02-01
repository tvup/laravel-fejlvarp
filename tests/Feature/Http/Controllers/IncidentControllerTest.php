<?php
namespace Tests\Feature\Http\Controllers;

use Tvup\LaravelFejlvarp\Incident;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can retrieve all unresolved incidents', function () {
    Incident::factory()->count(2)->create(['resolved_at' => null]);
    Incident::factory()->create(['resolved_at' => now()]);

    $response = $this->get(route('incidents.index'));

    $response->assertOk();
    $response->assertViewHas('incidents', fn($incidents) => $incidents->count() === 2);
});

it('can show a single incident', function () {
    $incident = Incident::factory()->create();

    $response = $this->get(route('incident.show', $incident->hash));

    $response->assertOk();
    $response->assertViewHas('incident', fn($i) => $i->hash === $incident->hash);
});

it('can mark an incident as resolved', function () {
    $incident = Incident::factory()->create(['resolved_at' => null]);

    $this->post(route('incident.delete', $incident->hash));

    expect($incident->fresh()->resolved_at)->not->toBeNull();
});