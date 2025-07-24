<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index(){
        $json = '[{"type":"hero","label":"Hero Section","description":"Big title, subtitle and call-to-action button","props":{"title":"Welcome to Larabrix!","subtitle":"Build pages visually with ease.","button_text":"Get Started","button_url":"#","background_image":null}},{"type":"intro","label":"Intro Section","description":"Short text-based introduction","props":{"heading":"About Us","content":"We provide scalable Laravel components for developers."}},{"type":"features","label":"Feature Grid","description":"Highlight key features in grid format","props":{"heading":"Our Features","items":[{"title":"Modular","description":"Use only what you need"},{"title":"Blade-based","description":"Lightweight and fast"},{"title":"Open Source","description":"MIT licensed"}]}},{"type":"call_to_action","label":"Call to Action","description":"Centered CTA block with button","props":{"text":"Ready to build your next project?","button_text":"Explore Larabrix","button_url":"/docs"}},{"type":"testimonial","label":"Testimonials","description":"Customer feedback carousel or grid","props":{"heading":"What People Say","testimonials":[{"name":"John Doe","quote":"Best modular toolkit ever!"},{"name":"Jane Smith","quote":"I love how simple it is."}]}},{"type":"blog_list","label":"Latest Blog Posts","description":"Display recent blog entries","props":{"heading":"From the Blog","limit":3}},{"type":"form","label":"Custom Form","description":"Embed a form builder form","props":{"form_id":null,"title":"Contact Us"}},{"type":"faq","label":"FAQ","description":"Frequently asked questions","props":{"heading":"Common Questions","items":[{"question":"Is Larabrix open source?","answer":"Yes! MIT licensed."},{"question":"Does it support Livewire?","answer":"Absolutely."}]}}]';


        dd(json_encode($json));
        $response = app()->handle(
            Request::create('/admin/media/browse?folder=media', 'GET')
        );
        $data = $response->getContent();
        return $data;


        // "[{\"type\":\"hero\",\"label\":\"Hero Section\",\"description\":\"Big title, subtitle and call-to-action button\",\"props\":{\"title\":\"Welcome to Larabrix!\",\"subtitle\":\"Build pages visually with ease.\",\"button_text\":\"Get Started\",\"button_url\":\"#\",\"background_image\":null}},{\"type\":\"intro\",\"label\":\"Intro Section\",\"description\":\"Short text-based introduction\",\"props\":{\"heading\":\"About Us\",\"content\":\"We provide scalable Laravel components for developers.\"}},{\"type\":\"features\",\"label\":\"Feature Grid\",\"description\":\"Highlight key features in grid format\",\"props\":{\"heading\":\"Our Features\",\"items\":[{\"title\":\"Modular\",\"description\":\"Use only what you need\"},{\"title\":\"Blade-based\",\"description\":\"Lightweight and fast\"},{\"title\":\"Open Source\",\"description\":\"MIT licensed\"}]}},{\"type\":\"call_to_action\",\"label\":\"Call to Action\",\"description\":\"Centered CTA block with button\",\"props\":{\"text\":\"Ready to build your next project?\",\"button_text\":\"Explore Larabrix\",\"button_url\":\"/docs\"}},{\"type\":\"testimonial\",\"label\":\"Testimonials\",\"description\":\"Customer feedback carousel or grid\",\"props\":{\"heading\":\"What People Say\",\"testimonials\":[{\"name\":\"John Doe\",\"quote\":\"Best modular toolkit ever!\"},{\"name\":\"Jane Smith\",\"quote\":\"I love how simple it is.\"}]}},{\"type\":\"blogs\",\"label\":\"Latest Blog Posts\",\"description\":\"Display recent blog entries\",\"props\":{\"heading\":\"From the Blog\",\"limit\":3}},{\"type\":\"form\",\"label\":\"Custom Form\",\"description\":\"Embed a form builder form\",\"props\":{\"form_id\":null,\"title\":\"Contact Us\"}},{\"type\":\"faq\",\"label\":\"FAQ\",\"description\":\"Frequently asked questions\",\"props\":{\"heading\":\"Common Questions\",\"items\":[{\"question\":\"Is Larabrix open source?\",\"answer\":\"Yes! MIT licensed.\"},{\"question\":\"Does it support Livewire?\",\"answer\":\"Absolutely.\"}]}}]"
    }
}
