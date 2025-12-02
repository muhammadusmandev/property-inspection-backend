<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Traits\Loggable;
use Carbon\Carbon;

class SubscriptionPlansSeeder extends Seeder
{
    use Loggable;

    public function run()
    {
        DB::beginTransaction();

        try{
            $plans = [
                [
                    'name' => 'Solo',
                    'slug' => 'solo',
                    'monthly_price' => 39,
                    'annual_price' => 468,
                    'currency' => 'USD',
                    'description' => 'Solo plan for individual use',
                    'features' => [
                        ['name' => 'Properties / Units', 'value' => '100'],
                        ['name' => 'Reports', 'value' => 'Unlimited'],
                        ['name' => 'Photos / Attachements', 'value' => 'Unlimited'],
                        ['name' => 'Clients', 'value' => 'Unlimited'],
                        ['name' => '24/7 Customer Support', 'value' => 'Chat & Email'],
                    ],
                ],
                [
                    'name' => 'Standard',
                    'slug' => 'standard',
                    'monthly_price' => 200,
                    'annual_price' => 2400,
                    'currency' => 'USD',
                    'description' => 'Standard plan with advanced features',
                    'features' => [
                        ['name' => 'Properties / Units', 'value' => '500'],
                        ['name' => 'Reports', 'value' => 'Unlimited'],
                        ['name' => 'Photos / Attachements', 'value' => 'Unlimited'],
                        ['name' => 'Clients', 'value' => 'Unlimited'],
                        ['name' => '24/7 Customer Support', 'value' => 'Phone, Chat & Email'],
                    ],
                ],
                [
                    'name' => 'Pro',
                    'slug' => 'pro',
                    'monthly_price' => 500,
                    'annual_price' => 6000,
                    'currency' => 'USD',
                    'description' => 'Pro plan with all features',
                    'features' => [
                        ['name' => 'Properties / Units', 'value' => '1000'],
                        ['name' => 'Reports', 'value' => 'Unlimited'],
                        ['name' => 'Photos / Attachements', 'value' => 'Unlimited'],
                        ['name' => 'Clients', 'value' => 'Unlimited'],
                        ['name' => '24/7 Customer Support', 'value' => 'Chat & Email'],
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

                $this->command->info("Plan created successfully: {$plan['name']} (USD {$plan['monthly_price']}/month)");

                // Insert features and link to plan
                foreach ($plan['features'] as $feature) {
                    $featureId = DB::table('subscription_features')->insertGetId([
                        'name' => $feature['name'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    // Pivot table
                    DB::table('subscription_feature_plans')->insert([
                        'plan_id' => $planId,
                        'Subscription_feature_id' => $featureId,
                        'value' => $feature['value'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }

            DB::commit();
            $this->command->info('Subscription plans seeded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            $this->logException($e, 'Unexpected error in SubscriptionPlanSeeder');
            $this->command->error('SubscriptionPlanSeeder seed failed: '.$e->getMessage());
        }
    }

   
}
