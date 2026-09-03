<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        if (News::count() > 0) {
            $this->command?->info('  News already seeded, skipping.');
            return;
        }

        $posts = [
            [
                'title' => 'How we take a brief from deck to stage',
                'excerpt' => 'A look inside our end-to-end process — strategy, design, film, stage and physical product under one roof.',
                'content' => "Every project at Fugo starts the same way: a brief, a deadline, and a room full of people who refuse to do the obvious thing.\n\nOur process has five moves. First, strategy — we interrogate the brief until the real problem shows up. Second, design — brand systems, key visuals and environments sketched against real constraints like print, LED and social crops. Third, film — TVC, company profile or documentation shot and finished in-house. Fourth, stage — events and expos engineered down to the load-in schedule. Fifth, merch — the physical product that lands in people's hands.\n\nThe reason it works is that one team owns the whole chain. There is no agency handoff tax: the designer who drew the key visual sits next to the producer who builds the stage version of it.\n\nIf you are briefing us soon, bring the problem, not the solution. The deck can come later.",
                'author' => 'Sona Lesmana',
                'category' => 'insights',
                'read_time' => 5,
                'published_date' => '2026-08-20',
                'is_featured' => true,
            ],
            [
                'title' => 'What it takes to run a three-day expo',
                'excerpt' => 'Checklists, war-room rhythms and the on-site calls that keep a high-visibility event landing on time.',
                'content' => "A three-day national expo looks effortless from the aisle. From the war room, it is a hundred small decisions an hour.\n\nOur expo playbook starts months earlier with zoning: traffic flow first, spectacle second. Every booth, stage and photospot is placed on a circulation map before a single visual is drawn. Then comes the production bible — a minute-by-minute rundown covering load-in, rehearsals, showcall and teardown.\n\nOn site, rhythm beats heroics. We run three standups a day: morning alignment, midday punchlist, evening reset. Every issue gets an owner and a deadline measured in hours, not days.\n\nThe unglamorous truth: great events are won in the warehouse, not on the stage. Labelled crates, tested backups and a crew that has rehearsed the worst case — that is what the audience experiences as magic.",
                'author' => 'Fugo Events Team',
                'category' => 'events',
                'read_time' => 4,
                'published_date' => '2026-08-02',
                'is_featured' => false,
            ],
            [
                'title' => '65+ brands later: what we keep learning',
                'excerpt' => 'Patterns from a decade of client work — and how they shape the way we brief every new project.',
                'content' => "Ten years, three cities and more than sixty-five brands. A few patterns keep repeating, so we wrote them down.\n\nFirst, the brief is never the brief. The real objective usually surfaces in the second meeting, once trust exists. We plan for that now instead of being surprised by it.\n\nSecond, consistency beats novelty. Brands do not need a new idea every quarter; they need one strong idea executed relentlessly across film, stage, print and product.\n\nThird, regulated industries reward preparation. Banking, automotive and government work moves fast only when the compliance homework is done early.\n\nThese lessons are now baked into our first-week checklist for every engagement. Experience is only useful if it changes what you do on Monday morning.",
                'author' => 'Sona Lesmana',
                'category' => 'company',
                'read_time' => 3,
                'published_date' => '2026-07-14',
                'is_featured' => false,
            ],
            [
                'title' => 'Why annual reports still matter in the age of social',
                'excerpt' => 'A 200-page book remains the most trusted brand artefact a company can publish. Here is how we build one.',
                'content' => "In a feed-driven world, the annual report looks like a relic. It is not. For investors, regulators and partners, it is still the document that counts.\n\nOur approach treats the report as a brand system, not a layout job. Theme first: one narrative spine that carries financials, governance and sustainability without feeling like three books stapled together. Then an information architecture that survives translation from spreadsheet to spread.\n\nPhotography and infographics do the heavy lifting. A reader should grasp the year's story in a five-minute skim, then find the depth when they need it.\n\nPrint discipline matters too — paper stock, binding and finishing are brand decisions. When the report lands on a stakeholder's desk, it should feel like the company it represents.",
                'author' => 'Fugo Design Team',
                'category' => 'industry',
                'read_time' => 4,
                'published_date' => '2026-06-28',
                'is_featured' => false,
            ],
            [
                'title' => '12,000 kits shipped on time: notes from merch season',
                'excerpt' => 'Sourcing, QC and logistics lessons from our busiest merchandise production run to date.',
                'content' => "Twelve thousand welcome kits. Multiple cities. One immovable deadline. Merch season is our favourite kind of stress test.\n\nIt starts with sourcing honesty: we sample everything, reject fast and lock suppliers before design freeze. A beautiful render means nothing if the material cannot be secured at volume.\n\nQuality control happens in three passes — pre-production sample, mid-run inspection and final pack-out audit. Each kit is counted, weighed and spot-checked before it seals.\n\nLogistics is the final mile that decides everything. Staggered dispatch, city-by-city manifests and a buffer day we protect like sacred ground.\n\nThe kits arrived on time. The client's team thought it was easy. That is the whole point.",
                'author' => 'Fugo Merch Team',
                'category' => 'updates',
                'read_time' => 3,
                'published_date' => '2026-06-05',
                'is_featured' => false,
            ],
            [
                'title' => 'Scouting venues in Bali: what we look for',
                'excerpt' => 'Power, access, acoustics and the sunset — our field checklist for island events.',
                'content' => "Bali makes every event look good and logistics look hard. Our Gianyar studio exists largely to make the second part easier.\n\nVenue scouting starts with the boring stuff: load-in access for trucks, three-phase power capacity, and a wet-weather plan that is a plan, not a hope. Then acoustics — open-air venues punish bad sound design, so we map speaker hangs before we promise anything.\n\nOnly after that do we talk about the view. And Bali always delivers: a well-placed stage at golden hour does half the show's emotional work for free.\n\nOur rule of thumb: if the venue cannot handle rain, trucks and toilets elegantly, the sunset does not save it.",
                'author' => 'Fugo Events Team',
                'category' => 'events',
                'read_time' => 3,
                'published_date' => '2026-05-18',
                'is_featured' => false,
            ],
        ];

        foreach ($posts as $i => $data) {
            News::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
                'featured_image' => '',
                'author' => $data['author'],
                'category' => $data['category'],
                'read_time' => $data['read_time'],
                'published_date' => $data['published_date'],
                'is_featured' => $data['is_featured'],
                'is_published' => true,
                'view_count' => ($i + 1) * 17,
            ]);
        }

        $this->command?->info('  Created ' . count($posts) . ' sample news articles');
    }
}
