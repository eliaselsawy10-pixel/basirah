<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ColorLensesSeeder extends Seeder
{
    public function run(): void
    {
        $lenses = [
            [
                'name'           => 'Caribbean Blue',
                'description'    => 'Monthly color lens by Bella',
                'price'          => 34.50,
                'image'          => 'images/lens1.png',
                'category'       => 'Contact Lenses',
                'stock'          => 50,
                'brand'          => 'Bella',
                'color_family'   => 'Light Blue',
                'replacement'    => 'Monthly',
                'is_new_arrival' => false,
            ],
            [
                'name'           => 'Espresso',
                'description'    => 'Monthly color lens by Desio',
                'price'          => 42.00,
                'image'          => 'images/lens2.png',
                'category'       => 'Contact Lenses',
                'stock'          => 30,
                'brand'          => 'Desio',
                'color_family'   => 'Brown',
                'replacement'    => 'Monthly',
                'is_new_arrival' => true,
            ],
            [
                'name'           => 'Azure Grey',
                'description'    => 'Yearly color lens by Anesthesia',
                'price'          => 128.00,
                'image'          => 'images/lens3.png',
                'category'       => 'Contact Lenses',
                'stock'          => 20,
                'brand'          => 'Anesthesia',
                'color_family'   => 'Grey',
                'replacement'    => 'Yearly',
                'is_new_arrival' => false,
            ],
            [
                'name'           => 'Hidrocor Mel',
                'description'    => 'Yearly color lens by Solotica',
                'price'          => 145.00,
                'image'          => 'images/lens4.png',
                'category'       => 'Contact Lenses',
                'stock'          => 15,
                'brand'          => 'Solotica',
                'color_family'   => 'Amber',
                'replacement'    => 'Yearly',
                'is_new_arrival' => false,
            ],
            [
                'name'           => 'Sterling Grey',
                'description'    => 'Monthly color lens by FreshLook',
                'price'          => 28.90,
                'image'          => 'images/lens5.png',
                'category'       => 'Contact Lenses',
                'stock'          => 100,
                'brand'          => 'FreshLook',
                'color_family'   => 'Grey',
                'replacement'    => 'Monthly',
                'is_new_arrival' => false,
            ],
            [
                'name'           => 'Luminous Pearl',
                'description'    => 'Monthly color lens by Bella',
                'price'          => 34.75,
                'image'          => 'images/lens6.png',
                'category'       => 'Contact Lenses',
                'stock'          => 40,
                'brand'          => 'Bella',
                'color_family'   => 'Violet',
                'replacement'    => 'Monthly',
                'is_new_arrival' => false,
            ],
        ];

        foreach ($lenses as $data) {
            $product = Product::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
            
            // Assuming generic gallery images, or we can just leave main image 
            ProductImage::firstOrCreate([
                'product_id' => $product->id, 
                'image_path' => $data['image']
            ]);
        }

        $this->command->info('✅ Seeded: 6 Contact Lenses.');
    }
}
