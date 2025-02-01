<?php

namespace Tvup\LaravelFejlvarp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Tvup\LaravelFejlvarp\Incident;


/**
 * @extends Factory<Incident>
 */
class IncidentFactory extends Factory
{
    protected $model = Incident::class;

    public function definition(): array
    {
        $fixturePath = __DIR__ . '/../../tests/Fixtures/incident_data_command_not_found.json';
        $incidentData = file_get_contents($fixturePath);

        return [
            'hash' => $this->faker->uuid(),
            'subject' => $this->faker->sentence(),
            'data' => $this->faker->randomElements([$incidentData]),
            'occurrences' => $this->faker->numberBetween(1, 100),
            'last_seen_at' => Carbon::instance($this->faker->dateTime()),
            'resolved_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
