<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use function Pest\testDirectory;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotFalse;
use Tvup\LaravelFejlvarp\Incident;

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

it('can fetch info about useragent and return as a javascript-function', function () {
    // Arrange
    $ua = 'Mozilla%2F5.0%20%28X11%3B%20Linux%20x86_64%29%20AppleWebKit%2F537.36%20%28KHTML%2C%20like%20Gecko%29%20Chrome%2F132.0.0.0%20Safari%2F537.36';

    // Mock the useragentstring API response
    $useragentstringResult = file_get_contents(testDirectory('Fixtures/useragentstring.json'));
    assertIsString($useragentstringResult);
    $jsonDecodedUseragentstringResponse = json_decode($useragentstringResult, true);
    assertIsArray($jsonDecodedUseragentstringResponse);
    Http::fake([
        'www.useragentstring.com/?getJSON=all&uas=*' => Http::response($jsonDecodedUseragentstringResponse),
    ]);

    // Act
    $response = $this->get('/api/useragent?useragent=' . $ua . '&callback=useragentCallback');

    // Assert
    $response->assertHeader('Content-Type', 'application/javascript');
    $response->assertOk();
});
