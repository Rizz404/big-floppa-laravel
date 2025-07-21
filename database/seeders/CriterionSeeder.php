<?php

namespace Database\Seeders;

use App\Models\Criterion;
use Illuminate\Database\Seeder;

class CriterionSeeder extends Seeder
{
    public function run(): void
    {
        $criteria = [
            // * Existing translated criteria
            ['name' => 'Grooming Needs', 'type' => 'cost', 'description' => 'How often the cat needs brushing, bathing, and special grooming.'],
            ['name' => 'Maintenance Cost', 'type' => 'cost', 'description' => 'Estimated monthly cost for food, litter, and routine health care.'],
            ['name' => 'Activity Level', 'type' => 'benefit', 'description' => 'How playful the cat is and how much exercise it requires.'],
            ['name' => 'Friendliness (Kids & Pets)', 'type' => 'benefit', 'description' => 'How well the cat gets along with children and other pets.'],
            ['name' => 'Space Requirement', 'type' => 'cost', 'description' => 'A higher score means the cat requires a larger living space.'],
            ['name' => 'Intelligence', 'type' => 'benefit', 'description' => 'How easy the cat is to train and how well it adapts to new situations.'],

            // * New criteria
            ['name' => 'Affection Level', 'type' => 'benefit', 'description' => 'How much the cat enjoys cuddling, being held, and human interaction.'],
            ['name' => 'Shedding Level', 'type' => 'cost', 'description' => 'The amount of fur the cat sheds, impacting cleaning and allergies.'],
            ['name' => 'Health & Longevity', 'type' => 'benefit', 'description' => 'General healthiness of the breed and its average lifespan.'],
            ['name' => 'Vocalization Level', 'type' => 'cost', 'description' => 'How talkative or noisy the cat breed tends to be.'],
        ];

        foreach ($criteria as $criterion) {
            Criterion::updateOrCreate(['name' => $criterion['name']], $criterion);
        }
    }
}
