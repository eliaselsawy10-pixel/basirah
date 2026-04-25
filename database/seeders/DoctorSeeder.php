<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Seed doctor users matching the consultation page UI.
     */
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Dr. Sarah Ahmed',
                'email' => 'sarah@basirah.com',
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'title' => 'Senior Optometrist',
                'bio' => 'Specializes in pediatric optometry and contact lens fitting. Over 12 years of experience in clinical practice.',
                'price' => 45.00,
                'rating' => 4.9,
                'review_count' => 124,
                'image' => 'images/doctor-sarah.png',
                'specializations' => ['Vision Therapy', 'Dry Eye Specialist'],
            ],
            [
                'name' => 'Dr. Hossam Ali',
                'email' => 'hossam@basirah.com',
                'password' => '2972004',
                'role' => 'doctor',
                'title' => 'Ophthalmologist',
                'bio' => 'Expert in refractive surgery consultations and glaucoma management. Board-certified surgical specialist.',
                'price' => 79.00,
                'rating' => 5.0,
                'review_count' => 89,
                'image' => 'images/doctor-hossam.png',
                'specializations' => ['LASIK Expert'],
            ],
        ];

        foreach ($doctors as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        $this->command->info('✅  Seeded: 2 doctors (Dr. Sarah Ahmed — sarah@basirah.com, Dr. Hossam Ali — hossam@basirah.com)');
    }
}
