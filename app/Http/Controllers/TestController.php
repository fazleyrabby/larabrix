<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\PaymentGatewayService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function index(PaymentGatewayService $paymentGatewayService){
        // dd(session()->get('cart'));
        // $this->pc();
        dd('✌🏻');
        $gateway = $paymentGatewayService->driver('stripe');
        $charge = $gateway->charge(100, 'usd', ['order_id' => 1]);
        dd([
            'order_id'       => $charge['meta']['order_id'] ?? null,
            'gateway'        => 'stripe',
            'transaction_id' => $charge['transaction_id'],
            'amount'         => $charge['amount'],
            'currency'       => $charge['currency'],
            'meta'           => $charge['meta'],
            'status'         => $charge['status'],
        ]);
        $json = '[{"type":"hero","label":"Hero Section","description":"Big title, subtitle and call-to-action button","props":{"title":"Welcome to Larabrix!","subtitle":"Build pages visually with ease.","button_text":"Get Started","button_url":"#","background_image":null}},{"type":"intro","label":"Intro Section","description":"Short text-based introduction","props":{"heading":"About Us","content":"We provide scalable Laravel components for developers."}},{"type":"features","label":"Feature Grid","description":"Highlight key features in grid format","props":{"heading":"Our Features","items":[{"title":"Modular","description":"Use only what you need"},{"title":"Blade-based","description":"Lightweight and fast"},{"title":"Open Source","description":"MIT licensed"}]}},{"type":"call_to_action","label":"Call to Action","description":"Centered CTA block with button","props":{"text":"Ready to build your next project?","button_text":"Explore Larabrix","button_url":"/docs"}},{"type":"testimonial","label":"Testimonials","description":"Customer feedback carousel or grid","props":{"heading":"What People Say","testimonials":[{"name":"John Doe","quote":"Best modular toolkit ever!"},{"name":"Jane Smith","quote":"I love how simple it is."}]}},{"type":"blog_list","label":"Latest Blog Posts","description":"Display recent blog entries","props":{"heading":"From the Blog","limit":3}},{"type":"form","label":"Custom Form","description":"Embed a form builder form","props":{"form_id":null,"title":"Contact Us"}},{"type":"faq","label":"FAQ","description":"Frequently asked questions","props":{"heading":"Common Questions","items":[{"question":"Is Larabrix open source?","answer":"Yes! MIT licensed."},{"question":"Does it support Livewire?","answer":"Absolutely."}]}}]';


        dd(json_encode($json));
        $response = app()->handle(
            Request::create('/admin/media/browse?folder=media', 'GET')
        );
        $data = $response->getContent();
        return $data;


        // "[{\"type\":\"hero\",\"label\":\"Hero Section\",\"description\":\"Big title, subtitle and call-to-action button\",\"props\":{\"title\":\"Welcome to Larabrix!\",\"subtitle\":\"Build pages visually with ease.\",\"button_text\":\"Get Started\",\"button_url\":\"#\",\"background_image\":null}},{\"type\":\"intro\",\"label\":\"Intro Section\",\"description\":\"Short text-based introduction\",\"props\":{\"heading\":\"About Us\",\"content\":\"We provide scalable Laravel components for developers.\"}},{\"type\":\"features\",\"label\":\"Feature Grid\",\"description\":\"Highlight key features in grid format\",\"props\":{\"heading\":\"Our Features\",\"items\":[{\"title\":\"Modular\",\"description\":\"Use only what you need\"},{\"title\":\"Blade-based\",\"description\":\"Lightweight and fast\"},{\"title\":\"Open Source\",\"description\":\"MIT licensed\"}]}},{\"type\":\"call_to_action\",\"label\":\"Call to Action\",\"description\":\"Centered CTA block with button\",\"props\":{\"text\":\"Ready to build your next project?\",\"button_text\":\"Explore Larabrix\",\"button_url\":\"/docs\"}},{\"type\":\"testimonial\",\"label\":\"Testimonials\",\"description\":\"Customer feedback carousel or grid\",\"props\":{\"heading\":\"What People Say\",\"testimonials\":[{\"name\":\"John Doe\",\"quote\":\"Best modular toolkit ever!\"},{\"name\":\"Jane Smith\",\"quote\":\"I love how simple it is.\"}]}},{\"type\":\"blogs\",\"label\":\"Latest Blog Posts\",\"description\":\"Display recent blog entries\",\"props\":{\"heading\":\"From the Blog\",\"limit\":3}},{\"type\":\"form\",\"label\":\"Custom Form\",\"description\":\"Embed a form builder form\",\"props\":{\"form_id\":null,\"title\":\"Contact Us\"}},{\"type\":\"faq\",\"label\":\"FAQ\",\"description\":\"Frequently asked questions\",\"props\":{\"heading\":\"Common Questions\",\"items\":[{\"question\":\"Is Larabrix open source?\",\"answer\":\"Yes! MIT licensed.\"},{\"question\":\"Does it support Livewire?\",\"answer\":\"Absolutely.\"}]}}]"
    }

    public function pc(){

        dd(1);
        Category::create(['title' => 'Motherboard', 'is_pc_part' => true]);
        Category::create(['title' => 'Processor', 'is_pc_part' => true]);
        Category::create(['title' => 'RAM', 'is_pc_part' => true]);
        Category::create(['title' => 'Power Supply', 'is_pc_part' => true]);
        Category::create(['title' => 'Monitor', 'is_pc_part' => true]);
        Category::create(['title' => 'Keyboard', 'is_pc_part' => true]);
        Category::create(['title' => 'Mouse', 'is_pc_part' => true]);
        Category::create(['title' => 'SSD', 'is_pc_part' => true]);
        Category::create(['title' => 'HDD', 'is_pc_part' => true]);
        Category::create(['title' => 'PC Case', 'is_pc_part' => true]);
        Category::create(['title' => 'Cpu Cooler', 'is_pc_part' => true]);

        DB::table('products')->insert([
        // Existing Products Updated with New Category IDs
        // AMD Ryzen 5 5600X Processor
            [
                'title' => 'AMD Ryzen 5 5600X',
                'sku' => 'CPU-AMD-5600X',
                'slug' => Str::slug('AMD Ryzen 5 5600X'),
                'price' => 299.00,
                'image' => 'https://placehold.co/400x400/FF0000/FFFFFF?text=AMD+5600X',
                'description' => 'A high-performance 6-core processor for gamers and creators.',
                'short_description' => '6-core, 12-thread desktop processor with a base clock speed of 3.7GHz.',
                'additional_info' => json_encode(['Socket' => 'AM4', 'Cores' => 6, 'Threads' => 12]),
                'category_id' => 27, // New Category ID: Processor
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => 'AM4',
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Gigabyte B550 AORUS Elite Motherboard
            [
                'title' => 'Gigabyte B550 AORUS Elite',
                'sku' => 'MB-GIGA-B550',
                'slug' => Str::slug('Gigabyte B550 AORUS Elite'),
                'price' => 159.99,
                'image' => 'https://placehold.co/400x400/0000FF/FFFFFF?text=B550+AORUS',
                'description' => 'An ATX motherboard with a robust power design for AMD Ryzen processors.',
                'short_description' => 'AM4 socket, PCIe 4.0 support, and dual NVMe M.2 slots.',
                'additional_info' => json_encode(['Form Factor' => 'ATX', 'Chipset' => 'B550']),
                'category_id' => 26, // New Category ID: Motherboard
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 2,
                'compatibility_key' => 'AM4',
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Corsair Vengeance RGB Pro 16GB RAM
            [
                'title' => 'Corsair Vengeance RGB Pro 16GB',
                'sku' => 'RAM-CORS-16GB',
                'slug' => Str::slug('Corsair Vengeance RGB Pro 16GB'),
                'price' => 79.99,
                'image' => 'https://placehold.co/400x400/FFFF00/000000?text=Vengeance+RAM',
                'description' => 'High-performance DDR4 RAM with dynamic multi-zone RGB lighting.',
                'short_description' => 'DDR4, 3200MHz speed, with a capacity of 16GB (2 x 8GB).',
                'additional_info' => json_encode(['Speed' => '3200MHz', 'Capacity' => '16GB']),
                'category_id' => 28, // New Category ID: RAM
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => 'DDR4',
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Samsung 970 EVO Plus 1TB SSD
            [
                'title' => 'Samsung 970 EVO Plus 1TB SSD',
                'sku' => 'SSD-SAMS-1TB',
                'slug' => Str::slug('Samsung 970 EVO Plus 1TB SSD'),
                'price' => 99.99,
                'image' => 'https://placehold.co/400x400/FF00FF/FFFFFF?text=Samsung+SSD',
                'description' => 'A fast NVMe SSD for blazing-fast load times and data transfers.',
                'short_description' => '1TB capacity, M.2 form factor, with sequential read speeds up to 3,500 MB/s.',
                'additional_info' => json_encode(['Form Factor' => 'M.2', 'Capacity' => '1TB']),
                'category_id' => 33, // New Category ID: SSD
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => 'M.2',
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // New Products added based on your new categories
            // Corsair RM850e Power Supply
            [
                'title' => 'Corsair RM850e Power Supply',
                'sku' => 'PSU-CORS-RM850e',
                'slug' => Str::slug('Corsair RM850e Power Supply'),
                'price' => 129.99,
                'image' => 'https://placehold.co/400x400/000000/FFFFFF?text=Corsair+PSU',
                'description' => 'A fully modular 850W power supply with 80 PLUS Gold efficiency.',
                'short_description' => '850W, 80 Plus Gold certified, fully modular.',
                'additional_info' => json_encode(['Wattage' => '850W', 'Efficiency' => '80 PLUS Gold']),
                'category_id' => 29, // New Category ID: Power Supply
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => 'ATX',
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // LG 27GL83A-B Monitor
            [
                'title' => 'LG 27GL83A-B Monitor',
                'sku' => 'MON-LG-27GL83A',
                'slug' => Str::slug('LG 27GL83A-B Monitor'),
                'price' => 379.99,
                'image' => 'https://placehold.co/400x400/808080/FFFFFF?text=LG+Monitor',
                'description' => 'A 27-inch gaming monitor with a fast refresh rate and IPS panel.',
                'short_description' => '27-inch QHD (2560x1440), 144Hz refresh rate, IPS.',
                'additional_info' => json_encode(['Size' => '27 inch', 'Resolution' => 'QHD']),
                'category_id' => 30, // New Category ID: Monitor
                'type' => 'simple',
                'is_pc_component' => false,
                'brand_id' => 1,
                'compatibility_key' => null,
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Logitech G Pro Mechanical Keyboard
            [
                'title' => 'Logitech G Pro Mechanical Keyboard',
                'sku' => 'KB-LOGI-GPRO',
                'slug' => Str::slug('Logitech G Pro Mechanical Keyboard'),
                'price' => 129.99,
                'image' => 'https://placehold.co/400x400/A0A0A0/000000?text=Logitech+Keyboard',
                'description' => 'A tenkeyless mechanical keyboard with swappable switches for pro-level gaming.',
                'short_description' => 'Tenkeyless design, RGB backlighting, GX Blue switches.',
                'additional_info' => json_encode(['Layout' => 'Tenkeyless', 'Switches' => 'GX Blue']),
                'category_id' => 31, // New Category ID: Keyboard
                'type' => 'simple',
                'is_pc_component' => false,
                'brand_id' => 1,
                'compatibility_key' => null,
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Razer DeathAdder V2 Mouse
            [
                'title' => 'Razer DeathAdder V2 Mouse',
                'sku' => 'M-RAZER-V2',
                'slug' => Str::slug('Razer DeathAdder V2 Mouse'),
                'price' => 69.99,
                'image' => 'https://placehold.co/400x400/708090/FFFFFF?text=Razer+Mouse',
                'description' => 'An ergonomic gaming mouse with a high-precision optical sensor.',
                'short_description' => '20,000 DPI optical sensor, 8 programmable buttons, 82g weight.',
                'additional_info' => json_encode(['DPI' => '20000', 'Weight' => '82g']),
                'category_id' => 32, // New Category ID: Mouse
                'type' => 'simple',
                'is_pc_component' => false,
                'brand_id' => 1,
                'compatibility_key' => null,
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Seagate Barracuda 2TB HDD
            [
                'title' => 'Seagate Barracuda 2TB HDD',
                'sku' => 'HDD-SEAG-2TB',
                'slug' => Str::slug('Seagate Barracuda 2TB HDD'),
                'price' => 54.99,
                'image' => 'https://placehold.co/400x400/00FF7F/FFFFFF?text=Seagate+HDD',
                'description' => 'A reliable internal hard drive for general-purpose storage.',
                'short_description' => '2TB capacity, 7200 RPM, SATA 6Gb/s interface.',
                'additional_info' => json_encode(['Capacity' => '2TB', 'Speed' => '7200 RPM']),
                'category_id' => 34, // New Category ID: HDD
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => 'SATA',
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'NZXT H510 Compact Mid-Tower',
                'sku' => 'CASE-NZXT-H510',
                'slug' => Str::slug('NZXT H510 Compact Mid-Tower'),
                'price' => 89.99,
                'image' => 'https://placehold.co/400x400/0000FF/FFFFFF?text=NZXT+H510',
                'description' => 'A sleek and modern mid-tower PC case with excellent cable management and airflow.',
                'short_description' => 'Mid-tower case with tempered glass side panel and streamlined design.',
                'additional_info' => json_encode([
                    'Form Factor' => 'ATX, Micro-ATX, Mini-ITX',
                    'Material' => 'Steel, Tempered Glass',
                    'Color' => 'Matte Black',
                ]),
                'category_id' => 35, // PC Case
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => 'ATX',
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Cooler Master Hyper 212 Black Edition',
                'sku' => 'COOLER-CM-212-BE',
                'slug' => Str::slug('Cooler Master Hyper 212 Black Edition'),
                'price' => 44.99,
                'image' => 'https://placehold.co/400x400/00FF00/FFFFFF?text=Hyper+212+BE',
                'description' => 'High-performance air CPU cooler with sleek black finish and quiet operation.',
                'short_description' => 'Tower-style CPU cooler with a 120mm PWM fan for optimal cooling.',
                'additional_info' => json_encode([
                    'Socket Support' => 'Intel LGA1200/115x/2066/2011, AMD AM4/AM3+/FM2+',
                    'Fan Size' => '120mm',
                    'Noise Level' => '26 dBA',
                ]),
                'category_id' => 36, // CPU Cooler
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => 'AM4, LGA1200',
                'configurable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}
