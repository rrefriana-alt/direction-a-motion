<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class JsonCmsService
{
    private $path = 'cms_content.json';

    public function getAll()
    {
        if (Storage::disk('local')->exists($this->path)) {
            return json_decode(Storage::disk('local')->get($this->path), true);
        }
        return $this->getDefaults();
    }

    public function get($key, $default = null)
    {
        $data = $this->getAll();
        return data_get($data, $key, $default);
    }

    public function update($key, $value)
    {
        $data = $this->getAll();
        data_set($data, $key, $value);
        Storage::disk('local')->put($this->path, json_encode($data, JSON_PRETTY_PRINT));
        return true;
    }

    public function getDefaults()
    {
        return [
            'home' => [
                'section_01' => [
                    'title' => 'Direction A: Motion',
                    'subtitle' => 'MANIFESTO',
                    'text' => 'We help brands move forward through strategic design and compelling narratives.'
                ],
                'section_02' => [
                    'title' => 'Our Expertise',
                    'text' => 'From brand identity to digital experiences.'
                ],
                'section_03' => [
                    'title' => 'Selected Works'
                ],
                'section_04' => [
                    'title' => 'Sectors We Serve'
                ],
                'section_05' => [
                    'title' => 'Our Process'
                ],
                'section_06' => [
                    'title' => 'Ready to move?',
                    'quote' => 'Let us build something great together.'
                ]
            ],
            'about' => [
                'founder' => [
                    'name' => 'Sona Lesmana',
                    'title' => 'Founder & CEO',
                    'quote' => 'To become a creative industry company with real, positive impact for every stakeholder - through solutions that are useful before they are beautiful.',
                    'image' => 'assets/img/team/founder.jpg'
                ],
                'studio' => [
                    'heading' => 'Fugo Creative Group',
                    'body' => 'Based in Bandung, serving globally.'
                ]
            ],
            'contact' => [
                'email' => 'hello@fugocreativegroup.com',
                'phone' => '+62-821-2100-0680',
                'address' => 'Jl. Permata Taman Sari Raya No.21, Bandung'
            ],
            'projects' => [
                [
                    'id' => '1',
                    'slug' => 'bri-virtual-debit',
                    'title' => 'BRI VIRTUAL DEBIT',
                    'category' => 'Campaign',
                    'image' => 'assets/img/work/bri.webp',
                    'description' => 'A campaign for BRI Virtual Debit.'
                ]
            ],
            'services' => [
                [
                    'id' => '1',
                    'name' => 'Brand Identity',
                    'description' => 'Crafting unique visual identities that stand out.'
                ]
            ]
        ];
    }
}
