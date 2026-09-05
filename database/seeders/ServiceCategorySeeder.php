<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\ServiceDetail;
use App\Models\ServiceItem;
use App\Models\EngagementModel;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fugo Design',
                'slug' => 'fugo-design',
                'title' => 'Fugo Design',
                'description' => 'Brand systems, campaign POSM, corporate reporting and digital assets — built to survive print, LED and social.',
                'icon' => 'bi-palette',
                'sort_order' => 1,
                'details' => [
                    ['category_name' => 'Creative Campaign (POSM)', 'content' => 'Poster, flyer, banner, billboard, print ad, LED, newsletter, welcome kit', 'sort_order' => 1],
                    ['category_name' => 'Branding', 'content' => 'Naming, logo, packaging, graphic standards manual', 'sort_order' => 2],
                    ['category_name' => 'Corporate', 'content' => 'Annual report, company profile, calendar, stationery', 'sort_order' => 3],
                    ['category_name' => 'Digital Campaign', 'content' => '2D/3D filters, motion graphics, bumpers, presentation design', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Production House',
                'slug' => 'production-house',
                'title' => 'Production House',
                'description' => 'TVC, company profile, digital video and event documentation — scripting, shoot, grade and score in-house.',
                'icon' => 'bi-camera-reels',
                'sort_order' => 2,
                'details' => [
                    ['category_name' => 'Commercial — TVC', 'content' => 'Concept, script, casting, shoot, post-production', 'sort_order' => 1],
                    ['category_name' => 'Company Profile', 'content' => 'Full production from scripting through original music', 'sort_order' => 2],
                    ['category_name' => 'Digital Video', 'content' => 'Social-first cutdowns, vertical formats, ad variants', 'sort_order' => 3],
                    ['category_name' => 'Coverage', 'content' => 'Event documentation, product photography and videography', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Event Organizer',
                'slug' => 'event-organizer',
                'title' => 'Event Organizer',
                'description' => 'Conferences, exhibitions, incentive trips and corporate gatherings — run end to end.',
                'icon' => 'bi-calendar-event',
                'sort_order' => 3,
                'details' => [
                    ['category_name' => 'Meeting — Conference', 'content' => 'Training, workshop, staff meeting, industry conference', 'sort_order' => 1],
                    ['category_name' => 'Exhibition', 'content' => 'Trade show, job fair, art and wedding exhibitions', 'sort_order' => 2],
                    ['category_name' => 'Incentive', 'content' => 'Gathering, business trip, holiday trip, team building', 'sort_order' => 3],
                    ['category_name' => 'Special', 'content' => 'CSR, cultural, political and celebration events', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Merch Production',
                'slug' => 'merch-production',
                'title' => 'Merch Production',
                'description' => 'Souvenirs, uniforms and welcome kits produced at scale with materials we can stand behind.',
                'icon' => 'bi-box-seam',
                'sort_order' => 4,
                'details' => [
                    ['category_name' => 'Souvenir', 'content' => 'Mug, notebook, pen, umbrella, USB, bag, calendar, keychain', 'sort_order' => 1],
                    ['category_name' => 'Uniform', 'content' => 'Shirt, polo, vest, sweater, jacket, trousers, footwear', 'sort_order' => 2],
                    ['category_name' => 'Welcome Kit', 'content' => 'Curated boxes with packaging design and fulfilment', 'sort_order' => 3],
                    ['category_name' => 'Sourcing — QC', 'content' => 'Material selection, sampling, quality control, delivery', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'AI Agent',
                'slug' => 'ai-agent',
                'title' => 'AI Agent',
                'description' => 'Custom AI agents and automations that take repetitive work off your team — briefed, built, and wired into the tools you already use.',
                'icon' => 'bi-robot',
                'sort_order' => 5,
                'details' => [
                    ['category_name' => 'Customer Agents', 'content' => 'WhatsApp and web agents that answer, qualify and hand over cleanly', 'sort_order' => 1],
                    ['category_name' => 'Workflow Automation', 'content' => 'Briefs, approvals, reporting and handovers, run without chasing', 'sort_order' => 2],
                    ['category_name' => 'Content Ops', 'content' => 'Bulk copy, translation and asset variants at campaign scale', 'sort_order' => 3],
                    ['category_name' => 'Integrations', 'content' => 'Connected to the CRM, sheets and channels the team already lives in', 'sort_order' => 4],
                ],
            ],
        ];

        $totalItems = 0;

        foreach ($categories as $i => $catData) {
            $details = $catData['details'];
            unset($catData['details']);

            $catData['is_active'] = true;
            $category = ServiceCategory::updateOrCreate(['slug' => $catData['slug']], $catData);

            foreach ($details as $detailData) {
                $content = $detailData['content'];
                $detailData['service_category_id'] = $category->id;
                $detailData['is_active'] = true;
                $detail = ServiceDetail::create($detailData);

                $items = array_map('trim', explode(',', $content));
                foreach ($items as $idx => $itemName) {
                    if (empty($itemName)) continue;
                    ServiceItem::create([
                        'service_detail_id' => $detail->id,
                        'item_name' => $itemName,
                        'description' => '',
                        'sort_order' => $idx + 1,
                        'is_active' => true,
                    ]);
                    $totalItems++;
                }
            }

            $this->command?->info("  Created category: {$category->name} with " . count($details) . " details");
        }

        $this->command?->info("  Total ServiceItem records created: {$totalItems}");

        if (EngagementModel::count() === 0) {
            $engagements = [
                ['letter' => 'A', 'title' => 'Project', 'description' => '<p>One brief, one deliverable, fixed scope and fixed price. Best for launches and one-off films.</p>', 'sort_order' => 1],
                ['letter' => 'B', 'title' => 'Retainer', 'description' => '<p>A monthly design and content allocation — the subscription model, with a named team and a real SLA.</p>', 'sort_order' => 2],
                ['letter' => 'C', 'title' => 'Embedded', 'description' => '<p>We sit inside your marketing team for a campaign cycle: strategy, production and on-site delivery.</p>', 'sort_order' => 3],
            ];

            foreach ($engagements as $eng) {
                $eng['is_active'] = true;
                EngagementModel::create($eng);
            }
            $this->command?->info("  Created 3 engagement models");
        }
    }
}
