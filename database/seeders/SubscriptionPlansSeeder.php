<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionPlansSeeder extends Seeder
{
    public function run()
    {

        $plans = [
            [
                'name' => 'Solo',
                'slug' => 'solo',
                'monthly_price' => 45,
                'annual_price' => 500, // optional
                'currency' => 'USD',
                'description' => 'Solo plan for individual use',
                'features' => [
                    ['name' => '1 Project', 'value' => '1'],
                    ['name' => 'Basic Support', 'value' => 'Email Only'],
                    ['name' => 'Limited Reports', 'value' => 'Yes'],
                ],
            ],
            [
                'name' => 'Standard',
                'slug' => 'standard',
                'monthly_price' => 200,
                'annual_price' => 2200,
                'currency' => 'USD',
                'description' => 'Team plan with advanced features',
                'features' => [
                    ['name' => '10 Projects', 'value' => '10'],
                    ['name' => 'Priority Support', 'value' => 'Email & Chat'],
                    ['name' => 'Full Reports', 'value' => 'Yes'],
                ],
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'monthly_price' => 500,
                'annual_price' => 5500,
                'currency' => 'USD',
                'description' => 'Enterprise plan with all features',
                'features' => [
                    ['name' => 'Unlimited Projects', 'value' => 'Unlimited'],
                    ['name' => '24/7 Support', 'value' => 'Phone, Chat & Email'],
                    ['name' => 'Advanced Analytics', 'value' => 'Yes'],
                ],
            ],
        ];

        foreach ($plans as $plan) {
            // Insert plan
            $planId = DB::table('subscription_plans')->insertGetId([
                'name' => $plan['name'],
                'slug' => $plan['slug'],
                'monthly_price' => $plan['monthly_price'],
                'annual_price' => $plan['annual_price'],
                'currency' => $plan['currency'],
                'description' => $plan['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Insert features and link to plan
            foreach ($plan['features'] as $feature) {
                $featureId = DB::table('subscription_features')->insertGetId([
                    'name' => $feature['name'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                // Pivot table
                DB::table('subscription_feature_plans')->insert([
                    'subscription_id' => $planId,
                    'Subscription_feature_id' => $featureId,
                    'value' => $feature['value'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        $this->command->info('Subscription plans seeded successfully!');
    }
}
