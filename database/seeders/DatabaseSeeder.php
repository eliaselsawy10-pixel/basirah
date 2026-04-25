<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================
        //  USERS  (1 admin + 2 demo customers)
        // =====================================================
        $admin = User::updateOrCreate(
            ['email' => 'admin@basirah.com'],
            [
                'name'     => 'Basirah Admin',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        $user1 = User::updateOrCreate(
            ['email' => 'ahmed@example.com'],
            [
                'name'     => 'Ahmed Hassan',
                'password' => Hash::make('password'),
                'role'     => 'patient',
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'sara@example.com'],
            [
                'name'     => 'Sara Mohamed',
                'password' => Hash::make('password'),
                'role'     => 'patient',
            ]
        );

        // =====================================================
        //  DOCTORS  (via dedicated seeder — creates users with role=doctor)
        // =====================================================
        $this->call(DoctorSeeder::class);
        $this->call(ColorLensesSeeder::class);

        // Get doctor IDs for demo appointments
        $doctorSarah = User::where('email', 'sarah@basirah.com')->first();
        $doctorHossam = User::where('email', 'hossam@basirah.com')->first();

        // =====================================================
        //  PRODUCTS  (Men, Women, Kids — with best sellers)
        // =====================================================
        $products = [

            // ---- MEN ----
            [
                'name'           => 'Classic Aviators',
                'description'    => 'Premium titanium finish with polarised UV400 lenses. Timeless style for everyday wear.',
                'price'          => 189.00,
                'image'          => 'images/glass1.png',
                'category'       => 'Men',
                'stock'          => 12,
                'is_best_seller' => true,
                'frame_materials' => ['Titanium Alloy', 'Premium Acetate'],
                'frame_colors'    => [['name' => 'Silver', 'hex' => '#e8e4df'], ['name' => 'Black', 'hex' => '#1a1a2e'], ['name' => 'Gunmetal', 'hex' => '#b0b8c4']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (48-18)'], ['value' => 'standard', 'label' => 'Standard (51-19)'], ['value' => 'large', 'label' => 'Large (54-20)']],
            ],
            [
                'name'           => 'David Beckham Classic',
                'description'    => 'Signature slim acetate frame. Lightweight and durable for all-day comfort.',
                'price'          => 215.00,
                'image'          => 'images/glass2.png',
                'category'       => 'Men',
                'stock'          => 8,
                'is_best_seller' => true,
                'frame_materials' => ['Premium Acetate', 'Lightweight Metal'],
                'frame_colors'    => [['name' => 'Black', 'hex' => '#1a1a2e'], ['name' => 'Tortoise', 'hex' => '#8B5E3C'], ['name' => 'Navy', 'hex' => '#1D3557']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (48-18)'], ['value' => 'standard', 'label' => 'Standard (51-19)'], ['value' => 'large', 'label' => 'Large (54-20)']],
            ],
            [
                'name'           => 'Ray-Ban Wayfarer',
                'description'    => 'Iconic square frame with scratch-resistant lenses. A wardrobe staple.',
                'price'          => 179.00,
                'image'          => 'images/show3.png',
                'category'       => 'Men',
                'stock'          => 20,
                'is_best_seller' => true,
                'frame_materials' => ['Eco-Acetate', 'Bio-Based Nylon'],
                'frame_colors'    => [['name' => 'Black', 'hex' => '#1a1a2e'], ['name' => 'Havana', 'hex' => '#6B3A2A'], ['name' => 'Green', 'hex' => '#2D5A27']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (50-18)'], ['value' => 'standard', 'label' => 'Standard (52-20)'], ['value' => 'large', 'label' => 'Large (54-22)']],
            ],
            [
                'name'           => 'Urban Tortoise',
                'description'    => 'Bold tortoise-shell acetate inspired by retro design. Perfect for round and oval faces.',
                'price'          => 159.00,
                'image'          => 'images/glass1.png',
                'category'       => 'Men',
                'stock'          => 6,
                'is_best_seller' => false,
                'frame_materials' => ['Premium Acetate'],
                'frame_colors'    => [['name' => 'Tortoise', 'hex' => '#8B5E3C'], ['name' => 'Dark Tortoise', 'hex' => '#5C3D2E'], ['name' => 'Honey', 'hex' => '#D4A76A']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (48-18)'], ['value' => 'standard', 'label' => 'Standard (51-19)'], ['value' => 'large', 'label' => 'Large (54-20)']],
            ],
            [
                'name'           => 'Sport Shield',
                'description'    => 'Wrap-around frame with rubberised grip temples. Designed for active lifestyles.',
                'price'          => 139.00,
                'image'          => 'images/glass2.png',
                'category'       => 'Men',
                'stock'          => 15,
                'is_best_seller' => false,
                'frame_materials' => ['Lightweight Metal', 'Rubberised Nylon'],
                'frame_colors'    => [['name' => 'Matte Black', 'hex' => '#2C2C2C'], ['name' => 'Silver', 'hex' => '#C0C0C0'], ['name' => 'Red', 'hex' => '#B22222']],
                'frame_sizes'     => [['value' => 'standard', 'label' => 'Standard (56-18)'], ['value' => 'large', 'label' => 'Large (60-20)'], ['value' => 'xlarge', 'label' => 'X-Large (64-22)']],
            ],

            // ---- WOMEN ----
            [
                'name'           => 'Modern Cat-Eye',
                'description'    => 'Elegant Eco-Acetate frame with a subtle cat-eye lift. Available in 4 colours.',
                'price'          => 150.00,
                'image'          => 'images/glass2.png',
                'category'       => 'Women',
                'stock'          => 9,
                'is_best_seller' => false,
                'frame_materials' => ['Eco-Acetate', 'Titanium Alloy'],
                'frame_colors'    => [['name' => 'Rose', 'hex' => '#E8B4B8'], ['name' => 'Black', 'hex' => '#1a1a2e'], ['name' => 'Crystal', 'hex' => '#E8E4DF']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (47-17)'], ['value' => 'standard', 'label' => 'Standard (50-18)'], ['value' => 'large', 'label' => 'Large (53-19)']],
            ],
            [
                'name'           => 'Versace VE3254B',
                'description'    => 'Glamorous oversized frame with signature Versace Greca detail along the temples.',
                'price'          => 249.00,
                'image'          => 'images/show2.png',
                'category'       => 'Women',
                'stock'          => 4,
                'is_best_seller' => true,
                'frame_materials' => ['Premium Acetate'],
                'frame_colors'    => [['name' => 'Black', 'hex' => '#1a1a2e'], ['name' => 'Bordeaux', 'hex' => '#6B2737'], ['name' => 'Havana', 'hex' => '#6B3A2A']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (50-18)'], ['value' => 'standard', 'label' => 'Standard (54-20)'], ['value' => 'large', 'label' => 'Large (56-21)']],
            ],
            [
                'name'           => 'Gucci GG0096S',
                'description'    => 'Luxurious round frame with Web stripe detail. A bold statement piece.',
                'price'          => 299.00,
                'image'          => 'images/show4.png',
                'category'       => 'Women',
                'stock'          => 3,
                'is_best_seller' => false,
                'frame_materials' => ['Premium Acetate', 'Gold Metal'],
                'frame_colors'    => [['name' => 'Gold/Black', 'hex' => '#CFB53B'], ['name' => 'Ivory', 'hex' => '#FFFFF0'], ['name' => 'Tortoise', 'hex' => '#8B5E3C']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (48-22)'], ['value' => 'standard', 'label' => 'Standard (51-24)'], ['value' => 'large', 'label' => 'Large (54-25)']],
            ],
            [
                'name'           => 'Rose Gold Rimless',
                'description'    => 'Ultra-lightweight rimless design with rose-gold titanium bridge. Barely-there look.',
                'price'          => 195.00,
                'image'          => 'images/glass1.png',
                'category'       => 'Women',
                'stock'          => 7,
                'is_best_seller' => false,
                'frame_materials' => ['Titanium'],
                'frame_colors'    => [['name' => 'Rose Gold', 'hex' => '#B76E79'], ['name' => 'Silver', 'hex' => '#C0C0C0'], ['name' => 'Gold', 'hex' => '#CFB53B']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (49-17)'], ['value' => 'standard', 'label' => 'Standard (52-18)'], ['value' => 'large', 'label' => 'Large (55-19)']],
            ],
            [
                'name'           => 'Butterfly Bold',
                'description'    => 'Oversized butterfly silhouette in rich burgundy acetate. Feminine and fashion-forward.',
                'price'          => 165.00,
                'image'          => 'images/glass2.png',
                'category'       => 'Women',
                'stock'          => 11,
                'is_best_seller' => false,
                'frame_materials' => ['Premium Acetate'],
                'frame_colors'    => [['name' => 'Burgundy', 'hex' => '#722F37'], ['name' => 'Black', 'hex' => '#1a1a2e'], ['name' => 'Plum', 'hex' => '#8E4585']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (50-18)'], ['value' => 'standard', 'label' => 'Standard (53-19)'], ['value' => 'large', 'label' => 'Large (56-20)']],
            ],

            // ---- KIDS ----
            [
                'name'           => 'Junior Square',
                'description'    => 'Flexible TR90 frame with spring hinges — virtually unbreakable for active kids.',
                'price'          => 89.00,
                'image'          => 'images/glass1.png',
                'category'       => 'Kids',
                'stock'          => 25,
                'is_best_seller' => false,
                'frame_materials' => ['Flexible TR90'],
                'frame_colors'    => [['name' => 'Blue', 'hex' => '#4169E1'], ['name' => 'Red', 'hex' => '#DC143C'], ['name' => 'Black', 'hex' => '#1a1a2e']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (42-15)'], ['value' => 'standard', 'label' => 'Standard (45-16)'], ['value' => 'large', 'label' => 'Large (48-17)']],
            ],
            [
                'name'           => 'Mini Oval',
                'description'    => 'Soft oval frame in pastel colours. Hypoallergenic silicone nose pads for comfort.',
                'price'          => 79.00,
                'image'          => 'images/glass2.png',
                'category'       => 'Kids',
                'stock'          => 18,
                'is_best_seller' => false,
                'frame_materials' => ['Flexible TR90', 'Silicone'],
                'frame_colors'    => [['name' => 'Pink', 'hex' => '#FFB6C1'], ['name' => 'Lavender', 'hex' => '#B57EDC'], ['name' => 'Sky Blue', 'hex' => '#87CEEB']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (40-14)'], ['value' => 'standard', 'label' => 'Standard (43-15)'], ['value' => 'large', 'label' => 'Large (46-16)']],
            ],
            [
                'name'           => 'Sporty Flex Blue',
                'description'    => 'Impact-resistant polycarbonate lens with a grippy rubber frame. Blue light filter included.',
                'price'          => 95.00,
                'image'          => 'images/glass1.png',
                'category'       => 'Kids',
                'stock'          => 14,
                'is_best_seller' => false,
                'frame_materials' => ['Rubberised Nylon'],
                'frame_colors'    => [['name' => 'Navy Blue', 'hex' => '#1D3557'], ['name' => 'Green', 'hex' => '#228B22'], ['name' => 'Orange', 'hex' => '#FF6347']],
                'frame_sizes'     => [['value' => 'small', 'label' => 'Small (43-15)'], ['value' => 'standard', 'label' => 'Standard (46-16)'], ['value' => 'large', 'label' => 'Large (49-17)']],
            ],
        ];

        foreach ($products as $data) {
            $product = Product::updateOrCreate(
                ['name' => $data['name']],
                $data
            );

            // Add two gallery images per product
            ProductImage::firstOrCreate(
                ['product_id' => $product->id, 'image_path' => 'images/glass1.png']
            );
            ProductImage::firstOrCreate(
                ['product_id' => $product->id, 'image_path' => 'images/glass2.png']
            );
        }

        // =====================================================
        //  APPOINTMENTS  (2 demo bookings with meeting links)
        // =====================================================
        if ($doctorSarah && $doctorHossam) {
            $token1 = Str::random(32);
            $token2 = Str::random(32);

            \DB::table('appointments')->insertOrIgnore([
                [
                    'user_id'           => $user1->id,
                    'doctor_id'         => $doctorSarah->id,
                    'patient_name'      => 'Ahmed Hassan',
                    'patient_email'     => 'ahmed@example.com',
                    'patient_phone'     => '+966-512-345678',
                    'appointment_date'  => now()->addDays(3)->toDateString(),
                    'appointment_time'  => '10:00:00',
                    'time_slot'         => '09:00 AM',
                    'consultation_type' => 'Eye Exam',
                    'notes'             => 'First visit. Mild headaches when reading.',
                    'price_paid'        => 45.00,
                    'status'            => 'confirmed',
                    'meeting_token'     => $token1,
                    'meeting_url'       => 'https://meet.jit.si/basirah-' . $token1,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ],
                [
                    'user_id'           => $user2->id,
                    'doctor_id'         => $doctorHossam->id,
                    'patient_name'      => 'Sara Mohamed',
                    'patient_email'     => 'sara@example.com',
                    'patient_phone'     => '+966-598-765432',
                    'appointment_date'  => now()->addDays(7)->toDateString(),
                    'appointment_time'  => '14:30:00',
                    'time_slot'         => '01:30 PM',
                    'consultation_type' => 'Prescription Review',
                    'notes'             => 'Needs update to existing prescription.',
                    'price_paid'        => 79.00,
                    'status'            => 'pending',
                    'meeting_token'     => $token2,
                    'meeting_url'       => 'https://meet.jit.si/basirah-' . $token2,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ],
            ]);
        }

        $this->command->info('✅  Seeded: ' . count($products) . ' products, 3 users, 2 doctors, 2 appointments.');
        $this->command->info('   Patient Login →  ahmed@example.com / password');
        $this->command->info('                    sara@example.com  / password');
        $this->command->info('   Doctor Login  →  sarah@basirah.com / password');
        $this->command->info('                    hossam@basirah.com / password');
    }
}
