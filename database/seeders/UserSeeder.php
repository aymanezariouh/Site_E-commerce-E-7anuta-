<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin users
        $admin1 = User::firstOrCreate(
            ['email' => 'admin@e7anuta.com'],
            [
                'name' => 'Administrateur Principal',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        $admin1->syncRoles(['admin']);

        $admin2 = User::firstOrCreate(
            ['email' => 'admin2@e7anuta.com'],
            [
                'name' => 'Sarah Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        $admin2->syncRoles(['admin']);

        // Create moderator users
        $moderator1 = User::firstOrCreate(
            ['email' => 'moderator@e7anuta.com'],
            [
                'name' => 'Ahmed Modérateur',
                'password' => Hash::make('moderator123'),
                'email_verified_at' => now(),
            ]
        );
        $moderator1->syncRoles(['moderator']);

        $moderator2 = User::firstOrCreate(
            ['email' => 'moderator2@e7anuta.com'],
            [
                'name' => 'Fatima Modératrice',
                'password' => Hash::make('moderator123'),
                'email_verified_at' => now(),
            ]
        );
        $moderator2->syncRoles(['moderator']);

        // Create seller users
        $sellers = [
            ['name' => 'Mohammed Boutique', 'email' => 'mohammed.seller@e7anuta.com'],
            ['name' => 'Youssef Market', 'email' => 'youssef.seller@e7anuta.com'],
            ['name' => 'Aicha Shop', 'email' => 'aicha.seller@e7anuta.com'],
            ['name' => 'Omar Electronics', 'email' => 'omar.electronics@e7anuta.com'],
            ['name' => 'Khadija Fashion', 'email' => 'khadija.fashion@e7anuta.com'],
            ['name' => 'Hassan Tech Store', 'email' => 'hassan.tech@e7anuta.com'],
            ['name' => 'Nadia Home & Garden', 'email' => 'nadia.home@e7anuta.com'],
            ['name' => 'Khalid Sports', 'email' => 'khalid.sports@e7anuta.com'],
            ['name' => 'Laila Books', 'email' => 'laila.books@e7anuta.com'],
            ['name' => 'Rachid Auto Parts', 'email' => 'rachid.auto@e7anuta.com'],
        ];

        foreach ($sellers as $sellerData) {
            $seller = User::firstOrCreate(
                ['email' => $sellerData['email']],
                [
                    'name' => $sellerData['name'],
                    'password' => Hash::make('seller123'),
                    'email_verified_at' => now(),
                    'created_at' => now()->subDays(rand(30, 180)),
                ]
            );
            $seller->syncRoles(['seller']);
        }

        // Create buyer users
        $buyers = [
            ['name' => 'Ali Benali', 'email' => 'ali.benali@gmail.com'],
            ['name' => 'Meriem Tazi', 'email' => 'meriem.tazi@gmail.com'],
            ['name' => 'Yassine Idrissi', 'email' => 'yassine.idrissi@gmail.com'],
            ['name' => 'Sanae Alaoui', 'email' => 'sanae.alaoui@gmail.com'],
            ['name' => 'Hamza Benjelloun', 'email' => 'hamza.benjelloun@gmail.com'],
            ['name' => 'Imane Chraibi', 'email' => 'imane.chraibi@gmail.com'],
            ['name' => 'Abdelkader Filali', 'email' => 'abdelkader.filali@gmail.com'],
            ['name' => 'Houda Berrada', 'email' => 'houda.berrada@gmail.com'],
            ['name' => 'Soufiane Amrani', 'email' => 'soufiane.amrani@gmail.com'],
            ['name' => 'Zineb Kettani', 'email' => 'zineb.kettani@gmail.com'],
            ['name' => 'Karim Fassi', 'email' => 'karim.fassi@gmail.com'],
            ['name' => 'Najat Squalli', 'email' => 'najat.squalli@gmail.com'],
            ['name' => 'Othmane Alami', 'email' => 'othmane.alami@gmail.com'],
            ['name' => 'Salma Benkirane', 'email' => 'salma.benkirane@gmail.com'],
            ['name' => 'Jamal Hajji', 'email' => 'jamal.hajji@gmail.com'],
            ['name' => 'Amina Zouari', 'email' => 'amina.zouari@gmail.com'],
            ['name' => 'Rachida Kandil', 'email' => 'rachida.kandil@gmail.com'],
            ['name' => 'Mustapha Lahlou', 'email' => 'mustapha.lahlou@gmail.com'],
            ['name' => 'Samira Bennani', 'email' => 'samira.bennani@gmail.com'],
            ['name' => 'Driss Temsamani', 'email' => 'driss.temsamani@gmail.com'],
            ['name' => 'Leila Marrakchi', 'email' => 'leila.marrakchi@gmail.com'],
            ['name' => 'Samir Benomar', 'email' => 'samir.benomar@gmail.com'],
            ['name' => 'Hafida Sekkat', 'email' => 'hafida.sekkat@gmail.com'],
            ['name' => 'Noureddine Cherkaoui', 'email' => 'noureddine.cherkaoui@gmail.com'],
            ['name' => 'Malika Berrechid', 'email' => 'malika.berrechid@gmail.com'],
        ];

        foreach ($buyers as $buyerData) {
            $buyer = User::firstOrCreate(
                ['email' => $buyerData['email']],
                [
                    'name' => $buyerData['name'],
                    'password' => Hash::make('buyer123'),
                    'email_verified_at' => rand(0, 1) ? now() : null,
                    'created_at' => now()->subDays(rand(1, 365)),
                ]
            );
            $buyer->syncRoles(['buyer']);
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin users: ' . User::role('admin')->count());
        $this->command->info('Moderator users: ' . User::role('moderator')->count());
        $this->command->info('Seller users: ' . User::role('seller')->count());
        $this->command->info('Buyer users: ' . User::role('buyer')->count());
    }
}