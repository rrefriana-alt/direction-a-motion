<?php

namespace Database\Seeders;

use App\Models\Capability;
use Illuminate\Database\Seeder;

class CapabilitiesSeeder extends Seeder
{
    public function run(): void
    {
        if (Capability::count() > 0) {
            $this->command?->info('  Capabilities already seeded, skipping.');
            return;
        }

        $capabilities = [
            [
                'number' => 1,
                'title' => 'Design & Branding',
                'description' => 'Brand systems, visual identity, campaign POSM, and digital assets — built to survive print, LED, and social.',
                'tags' => json_encode(['Brand Identity', 'Logo Design', 'POSM', 'Packaging', 'Graphic Standards']),
                'sort_order' => 1,
            ],
            [
                'number' => 2,
                'title' => 'Production House',
                'description' => 'TVC, company profile, digital video, and event documentation — scripting, shoot, grade, and score in-house.',
                'tags' => json_encode(['TVC', 'Company Profile', 'Digital Video', 'Event Documentation', 'Post-Production']),
                'sort_order' => 2,
            ],
            [
                'number' => 3,
                'title' => 'Event Organizer',
                'description' => 'Conferences, exhibitions, incentive trips, and corporate gatherings — planned and run end to end.',
                'tags' => json_encode(['Conference', 'Exhibition', 'Incentive', 'Team Building', 'CSR Event']),
                'sort_order' => 3,
            ],
            [
                'number' => 4,
                'title' => 'Merch Production',
                'description' => 'Souvenirs, uniforms, and welcome kits produced at scale with materials we can stand behind.',
                'tags' => json_encode(['Souvenir', 'Uniform', 'Welcome Kit', 'Sourcing', 'Quality Control']),
                'sort_order' => 4,
            ],
            [
                'number' => 5,
                'title' => 'AI Agent',
                'description' => 'Custom AI agents and automations that take repetitive work off your team — briefed, built, and wired into the tools you already use.',
                'tags' => json_encode(['WhatsApp Bot', 'Workflow Automation', 'Content Ops', 'CRM Integration']),
                'sort_order' => 5,
            ],
        ];

        foreach ($capabilities as $data) {
            $data['is_active'] = true;
            $data['image'] = null;
            Capability::create($data);
        }

        $this->command?->info('  Created ' . count($capabilities) . ' capabilities');
    }
}
