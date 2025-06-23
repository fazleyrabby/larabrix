<?php


if (!function_exists('setPaginationMetaData')) {
    function setPaginationMetaData($items)
    {
        return [
            'current_page' => $items->currentPage(),
            'last_page'    => $items->lastPage(),
            'per_page'     => $items->perPage(),
            'total'        => $items->total(),
            'links'        => [
                'first' => $items->url(1),
                'last'  => $items->url($items->lastPage()),
                'prev'  => $items->previousPageUrl(),
                'next'  => $items->nextPageUrl(),
            ]
        ];
    }
}



function getDummyProducts(){
    return [
        [
            "title" => "Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops",
            "price" => 109.95,
            "sku" => "quae_6721289c6e78f_1730226332",
            "category_id" => 3,
            "image" => "https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg",
            "description" => "Your perfect pack for everyday use and walks in the forest. Stash your laptop (up to 15 inches) in the padded sleeve, your everyday"
        ],
        [
            "title" => "Casual Cotton T-Shirt",
            "price" => 15.99,
            "sku" => "cotton_293847fhfjg_1939298393",
            "category_id" => 1,
            "image" => "https://fakestoreapi.com/img/71li-ujtlUL._AC_UX679_.jpg",
            "description" => "Comfortable and lightweight, perfect for daily wear. Made from soft, breathable cotton fabric."
        ],
        [
            "title" => "Stylish Leather Wallet",
            "price" => 45.50,
            "sku" => "leather_34983dkd92_8373920",
            "category_id" => 2,
            "image" => "https://fakestoreapi.com/img/61mtL65D4cL._AC_UL1024_.jpg",
            "description" => "A classic leather wallet to keep your cards and cash organized. Durable and timeless."
        ],
        [
            "title" => "Premium Wireless Headphones",
            "price" => 199.99,
            "sku" => "audio_ghsfjgh8282_020202020",
            "category_id" => 4,
            "image" => "https://fakestoreapi.com/img/71h3nB-lrML._AC_SL1500_.jpg",
            "description" => "Experience high-quality sound with noise cancellation. Perfect for immersive music sessions."
        ],
        [
            "title" => "Stainless Steel Water Bottle",
            "price" => 25.99,
            "sku" => "bottle_hff48ffh47_3938399293",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/71mGzENk8gL._AC_SL1500_.jpg",
            "description" => "Stay hydrated on the go with this durable, eco-friendly stainless steel bottle."
        ],
        [
            "title" => "Men's Casual Slim Fit Jacket",
            "price" => 49.99,
            "sku" => "jacket_m983jf928_28374",
            "category_id" => 1,
            "image" => "https://fakestoreapi.com/img/71X5RAf-eXL._AC_UY879_.jpg",
            "description" => "Lightweight and stylish jacket for everyday wear. Perfect for cooler days."
        ],
        [
            "title" => "Smart LED Desk Lamp",
            "price" => 39.95,
            "sku" => "lamp_827hfjd_28174",
            "category_id" => 6,
            "image" => "https://fakestoreapi.com/img/81Zt42ioCgL._AC_SL1500_.jpg",
            "description" => "Illuminate your workspace with adjustable brightness and a modern design."
        ],
        [
            "title" => "Wireless Bluetooth Speaker",
            "price" => 79.99,
            "sku" => "speaker_89hfh284_012345",
            "category_id" => 4,
            "image" => "https://fakestoreapi.com/img/81Zt42ioCgL._AC_SL1500_.jpg",
            "description" => "Portable speaker with deep bass and immersive sound for outdoor use."
        ],
        [
            "title" => "Ergonomic Office Chair",
            "price" => 150.00,
            "sku" => "chair_982hfjdhf_02993",
            "category_id" => 6,
            "image" => "https://fakestoreapi.com/img/81rFJffKhLL._AC_SL1500_.jpg",
            "description" => "Designed to provide support and comfort for long hours of work."
        ],
        [
            "title" => "Classic Wristwatch",
            "price" => 250.00,
            "sku" => "watch_98dfjfj92_123455",
            "category_id" => 3,
            "image" => "https://fakestoreapi.com/img/71li-ujtlUL._AC_UL1500_.jpg",
            "description" => "A timeless wristwatch with leather straps and water resistance."
        ],
        [
            "title" => "Portable Charger 10000mAh",
            "price" => 29.99,
            "sku" => "charger_2873jkdhf_1001",
            "category_id" => 4,
            "image" => "https://fakestoreapi.com/img/71+9d6y8dfL._AC_SL1500_.jpg",
            "description" => "High-capacity portable charger with fast charging technology for all your devices."
        ],
        [
            "title" => "Insulated Travel Mug",
            "price" => 18.50,
            "sku" => "mug_893kdjfh_2021",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/71-8+K3mAEL._AC_SL1500_.jpg",
            "description" => "Keeps beverages hot or cold for hours, perfect for on-the-go use."
        ],
        [
            "title" => "Canvas Duffel Bag",
            "price" => 65.75,
            "sku" => "duffel_873fhkjs_1938",
            "category_id" => 3,
            "image" => "https://fakestoreapi.com/img/71X5dF6ndKL._AC_SL1500_.jpg",
            "description" => "Spacious and durable duffel bag, ideal for weekend trips and gym use."
        ],
        [
            "title" => "HD Webcam 1080p",
            "price" => 45.99,
            "sku" => "webcam_287fhks_2023",
            "category_id" => 6,
            "image" => "https://fakestoreapi.com/img/71gXZUEY+DL._AC_SL1500_.jpg",
            "description" => "Crystal-clear HD webcam with a wide-angle lens and built-in microphone."
        ],
        [
            "title" => "Eco-Friendly Yoga Mat",
            "price" => 25.99,
            "sku" => "yogamat_9hd7sjs_0102",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/81hp-4JkTvL._AC_SL1500_.jpg",
            "description" => "Non-slip yoga mat made from eco-friendly materials. Ideal for yoga, Pilates, and workouts."
        ],
        [
            "title" => "Bluetooth Fitness Tracker",
            "price" => 39.95,
            "sku" => "fittrack_2930sjdk_1119",
            "category_id" => 4,
            "image" => "https://fakestoreapi.com/img/61tj5R1A0PL._AC_SL1500_.jpg",
            "description" => "Track your fitness and health metrics with this stylish and compact fitness tracker."
        ],
        [
            "title" => "Ceramic Coffee Grinder",
            "price" => 27.49,
            "sku" => "grinder_89sdkfj_2929",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/71+d+dQ6oYL._AC_SL1500_.jpg",
            "description" => "Compact, manual ceramic grinder for fresh coffee on the go or at home."
        ],
        [
            "title" => "Waterproof Smartwatch",
            "price" => 120.00,
            "sku" => "smartwatch_938jfhs_2233",
            "category_id" => 4,
            "image" => "https://fakestoreapi.com/img/81-g+9kI6yL._AC_SL1500_.jpg",
            "description" => "Waterproof smartwatch with heart rate monitor, GPS, and fitness tracking."
        ],
        [
            "title" => "Anti-Theft Laptop Backpack",
            "price" => 59.99,
            "sku" => "backpack_93hfjd7_3746",
            "category_id" => 3,
            "image" => "https://fakestoreapi.com/img/71f4aXA1b8L._AC_SL1500_.jpg",
            "description" => "Backpack with anti-theft features, USB charging port, and laptop compartment."
        ],
        [
            "title" => "Foldable Laptop Stand",
            "price" => 21.99,
            "sku" => "stand_92fjsdk_4847",
            "category_id" => 6,
            "image" => "https://fakestoreapi.com/img/71f4X45AJ+L._AC_SL1500_.jpg",
            "description" => "Adjustable and portable laptop stand to improve ergonomics at your desk.",
        ],
        [
            "title" => "Vintage Leather Messenger Bag",
            "price" => 89.99,
            "sku" => "messenger_73dhf_2830",
            "category_id" => 3,
            "image" => "https://fakestoreapi.com/img/71pLJg6WmfL._AC_SL1500_.jpg",
            "description" => "Stylish leather messenger bag with multiple compartments. Perfect for work or school.",
        ],
        [
            "title" => "Adjustable Dumbbells Set",
            "price" => 199.95,
            "sku" => "dumbbells_28hsj_2983",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/81Wpl52-BfL._AC_SL1500_.jpg",
            "description" => "High-quality adjustable dumbbells for versatile home workouts.",
        ],
        [
            "title" => "Wireless Earbuds",
            "price" => 49.99,
            "sku" => "earbuds_58hdh_0983",
            "category_id" => 4,
            "image" => "https://fakestoreapi.com/img/71T0aX1W-qL._AC_SL1500_.jpg",
            "description" => "Compact, high-quality wireless earbuds with a charging case and noise cancellation.",
        ],
        [
            "title" => "Digital Alarm Clock with LED Display",
            "price" => 24.99,
            "sku" => "alarm_97dhfj_1293",
            "category_id" => 6,
            "image" => "https://fakestoreapi.com/img/61xvLRp6xKL._AC_SL1500_.jpg",
            "description" => "Modern digital alarm clock with adjustable brightness and USB charging port.",
        ],
        [
            "title" => "Heavy-Duty Hiking Boots",
            "price" => 119.99,
            "sku" => "boots_29dfh_7383",
            "category_id" => 1,
            "image" => "https://fakestoreapi.com/img/81Z5tN3HH+L._AC_SL1500_.jpg",
            "description" => "Durable hiking boots with water resistance and excellent traction.",
        ],
        [
            "title" => "LED Desk Lamp with USB Charging Port",
            "price" => 34.50,
            "sku" => "lamp_283hfj_1092",
            "category_id" => 6,
            "image" => "https://fakestoreapi.com/img/71Z+Bse-gYL._AC_SL1500_.jpg",
            "description" => "Energy-saving desk lamp with adjustable brightness and USB charging.",
        ],
        [
            "title" => "Organic Cotton Throw Blanket",
            "price" => 29.99,
            "sku" => "blanket_78dfh_2910",
            "category_id" => 3,
            "image" => "https://fakestoreapi.com/img/61B9NKb-ABL._AC_SL1500_.jpg",
            "description" => "Soft, organic cotton throw blanket for cozy evenings at home.",
        ],
        [
            "title" => "Rechargeable Electric Toothbrush",
            "price" => 35.95,
            "sku" => "toothbrush_98fjs_2341",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/71n+QJ5n8oL._AC_SL1500_.jpg",
            "description" => "Advanced electric toothbrush with multiple brushing modes for optimal oral hygiene.",
        ],
        [
            "title" => "Insulated Stainless Steel Lunch Box",
            "price" => 24.50,
            "sku" => "lunchbox_89jsd_2948",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/71TQyMC2rxL._AC_SL1500_.jpg",
            "description" => "Keep your food warm or cold on the go with this durable insulated lunch box.",
        ],
        [
            "title" => "Silicone Baking Mat Set",
            "price" => 15.99,
            "sku" => "bakingmat_38hjd_8392",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/71lg9a9LZcL._AC_SL1500_.jpg",
            "description" => "Reusable, non-stick silicone baking mats for easy and mess-free baking.",
        ],
        [
            "title" => "Ultra-Thin Laptop Sleeve",
            "price" => 21.95,
            "sku" => "sleeve_28hsd_9201",
            "category_id" => 3,
            "image" => "https://fakestoreapi.com/img/71fth5JzE4L._AC_SL1500_.jpg",
            "description" => "Sleek and protective laptop sleeve with water-resistant material.",
        ],
        [
            "title" => "Multi-Purpose Travel Organizer",
            "price" => 12.99,
            "sku" => "organizer_28dkd_0192",
            "category_id" => 3,
            "image" => "https://fakestoreapi.com/img/71p0gXG3a5L._AC_SL1500_.jpg",
            "description" => "Compact and lightweight travel organizer for keeping your essentials neat.",
        ],
        [
            "title" => "Vintage Leather Belt",
            "price" => 15.95,
            "sku" => "belt_37jdk_2847",
            "category_id" => 1,
            "image" => "https://fakestoreapi.com/img/71t9uFTjKlL._AC_SL1500_.jpg",
            "description" => "Classic leather belt with a vintage finish, perfect for casual and formal wear.",
        ],
        [
            "title" => "Ceramic Dinnerware Set",
            "price" => 49.99,
            "sku" => "dinnerware_28sdj_0193",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/81msLBUK7HL._AC_SL1500_.jpg",
            "description" => "Beautifully crafted ceramic dinnerware set for any occasion.",
        ],
        [
            "title" => "Foldable Camping Chair",
            "price" => 45.00,
            "sku" => "campchair_19hdf_9371",
            "category_id" => 6,
            "image" => "https://fakestoreapi.com/img/71Uy-yX9VdL._AC_SL1500_.jpg",
            "description" => "Portable, foldable camping chair with a sturdy frame and carrying case.",
        ],
        [
            "title" => "Electric Hand Mixer",
            "price" => 29.99,
            "sku" => "mixer_29dfh_9482",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/61IJZMB+JTL._AC_SL1500_.jpg",
            "description" => "Powerful hand mixer for whipping, blending, and mixing. Perfect for bakers.",
        ],
        [
            "title" => "Outdoor Solar LED String Lights",
            "price" => 19.95,
            "sku" => "stringlights_82hdj_2837",
            "category_id" => 6,
            "image" => "https://fakestoreapi.com/img/81ZxkpMN0+L._AC_SL1500_.jpg",
            "description" => "Solar-powered string lights for decorating your outdoor spaces.",
        ],
        [
            "title" => "Smart Plug with Alexa Compatibility",
            "price" => 12.99,
            "sku" => "smartplug_92jdh_4937",
            "category_id" => 4,
            "image" => "https://fakestoreapi.com/img/61xlVjoE-tL._AC_SL1500_.jpg",
            "description" => "Control your appliances remotely with this Alexa-compatible smart plug.",
        ],
        [
            "title" => "Reusable Grocery Bags, Set of 5",
            "price" => 9.99,
            "sku" => "grocerybags_84hjd_2950",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/71+x9FzYeLL._AC_SL1500_.jpg",
            "description" => "Eco-friendly and durable grocery bags that you can use again and again.",
        ],
        [
            "title" => "Bluetooth Smart Scale",
            "price" => 35.00,
            "sku" => "smartscale_28fhd_8273",
            "category_id" => 5,
            "image" => "https://fakestoreapi.com/img/71sjIu7UWIL._AC_SL1500_.jpg",
            "description" => "Track your health metrics with this smart scale that syncs with your phone.",
        ]
    ];

    // return array_map(function($product){
    //     $product['purchase_price'] = $product['price'];
    //     $product['sale_price'] = $product['purchase_price'] + 2;
    //     unset($product['price']);
    //     return $product;
    // }, $data);
}

