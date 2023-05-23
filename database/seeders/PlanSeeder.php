<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Premium Subscription', 
                'slug' => 'premium', 
                'stripe_plan' => 'price_1NAyI3GE5CktRQJYrKZXafp5', 
                'price' => 9.99, 
                'description' => 'Premium Subscription'
            ]
        ];
   
        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
