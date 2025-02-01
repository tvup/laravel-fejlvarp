<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use function Pest\testDirectory;
use Tvup\LaravelFejlvarp\Incident;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotFalse;

uses(RefreshDatabase::class);

it('will include a javascript to lookup data about the ip-address', function () {
    // Arrange
    $incidentData = file_get_contents(testDirectory('Fixtures/incident_data_exception.json'));
    assertNotFalse($incidentData);
    $incident = Incident::factory()->create(['resolved_at' => null, 'data' => json_decode($incidentData, true)]);

    // Act
    $response = $this->get(route('incident.show', $incident->hash));

    // Assert
    $response->assertOk();
    $response->assertViewHas('incident', fn ($i) => $i->hash === $incident->hash);
    $response->assertSee('/api/geoip?ip=89.150.133.237&callback=geoipCallback', false);
});

it('can fetch info about an IP-address and return as a javascript-function', function () {
    // Arrange
    // Set the IPStack access key to a mock key - needed for controller to enter the if-statement that fetches the IP info
    config()->set('fejlvarp.ipstack.access_key', 'mock_key');

    // Mock the IPStack API response
    $ipStackResultOfIp = file_get_contents(testDirectory('Fixtures/ipstack_89-150-133-237.json'));
    assertIsString($ipStackResultOfIp);
    $jsonDecodedIpStackResponse = json_decode($ipStackResultOfIp, true);
    assertIsArray($jsonDecodedIpStackResponse);
    Http::fake([
        'api.ipstack.com/89.150.133.237?access_key=mock_key' => Http::response($jsonDecodedIpStackResponse),
    ]);

    // Act
    $response = $this->get('/api/geoip?ip=89.150.133.237&callback=geoipCallback');

    // Assert
    $response->assertHeader('Content-Type', 'application/javascript');
    $response->assertOk();
});
