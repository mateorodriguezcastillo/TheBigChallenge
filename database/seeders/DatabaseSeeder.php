<?php

namespace Database\Seeders;

use App\Models\Submission;
use Database\Factories\SubmissionFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // SubmissionFactory::new()->pending()->create(10);
        // SubmissionFactory::new()->inProgress()->create(10);
        // SubmissionFactory::new()->done()->create(10);
        Submission::factory()->pending()->count(10)->create();
    }
}
