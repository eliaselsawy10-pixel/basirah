<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    /**
     * Seed site-level reviews (home page) and product reviews (show page).
     */
    public function run(): void
    {
        // ===========================
        // SITE-LEVEL REVIEWS (home page "Feedbacks" section)
        // product_id = null → shown on home page
        // ===========================
        $siteReviews = [
            [
                'reviewer_name' => 'Ahmed Hassan',
                'rating'        => 4,
                'comment'       => 'The website is easy to use and I liked the variety of frames available.',
            ],
            [
                'reviewer_name' => 'Mona Ali',
                'rating'        => 5,
                'comment'       => 'Good selection of lenses and frames and the product descriptions are clear.',
            ],
            [
                'reviewer_name' => 'Omar Khaled',
                'rating'        => 5,
                'comment'       => 'I like the idea of consulting a doctor through the website. It makes the platform more trustworthy and helpful.',
            ],
            [
                'reviewer_name' => 'Sara Mohamed',
                'rating'        => 5,
                'comment'       => 'The design is clean and navigation is simple. I found what I needed quickly without any confusion. The customer service is excellent and the delivery was fast.',
            ],
            [
                'reviewer_name' => 'Youssef Ibrahim',
                'rating'        => 5,
                'comment'       => 'Nice range of eyewear products and reasonable pricing. The checkout process could be a bit faster.',
            ],
            [
                'reviewer_name' => 'Nour El-Din',
                'rating'        => 5,
                'comment'       => 'The online consultation feature is very useful, especially for people who are not sure about their prescription.',
            ],
        ];

        foreach ($siteReviews as $review) {
            Review::create(array_merge($review, [
                'user_id'    => null,
                'product_id' => null,
            ]));
        }

        // ===========================
        // PRODUCT REVIEWS (product show page)
        // product_id = X → shown on that product's page
        // ===========================
        $products = Product::take(6)->get();

        $productReviews = [
            [
                'reviewer_name' => 'Sophia Rossi',
                'rating'        => 5,
                'comment'       => 'The frames are lightweight and comfortable for all-day wear. The prescription was perfectly matched — great quality for the price!',
            ],
            [
                'reviewer_name' => 'Marco Bianchi',
                'rating'        => 5,
                'comment'       => 'Ordered online and received within 3 days. The glasses fit perfectly and the anti-reflective coating is excellent. Will definitely order again!',
            ],
            [
                'reviewer_name' => 'Isabella Conti',
                'rating'        => 4,
                'comment'       => 'Very stylish frames and the lenses are crystal clear. The virtual try-on feature helped me pick the perfect shape for my face. Highly recommend Basirah!',
            ],
            [
                'reviewer_name' => 'Layla Ahmed',
                'rating'        => 5,
                'comment'       => 'Excellent build quality. These glasses feel premium and look amazing. Got many compliments already!',
            ],
            [
                'reviewer_name' => 'Karim Mostafa',
                'rating'        => 4,
                'comment'       => 'Good quality for the price. The frame is sturdy and the lenses are clear. Shipping was fast too.',
            ],
            [
                'reviewer_name' => 'Dina Farouk',
                'rating'        => 5,
                'comment'       => 'Love these glasses! They are super comfortable and look great. The packaging was also very nice.',
            ],
        ];

        // Distribute reviews across products
        foreach ($products as $index => $product) {
            // Each product gets 3 reviews (cycling through all 6)
            for ($i = 0; $i < 3; $i++) {
                $reviewData = $productReviews[($index + $i) % count($productReviews)];
                Review::create(array_merge($reviewData, [
                    'user_id'    => null,
                    'product_id' => $product->id,
                ]));
            }
        }
    }
}
