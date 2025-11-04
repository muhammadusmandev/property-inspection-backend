<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\ApiErrorException;
use App\Traits\Loggable;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Carbon\Carbon;

class SubscriptionPlansSeeder extends Seeder
{
    use Loggable;

    public function __construct()
    {
        Stripe::setApiKey(config('cashier.secret'));
    }

    public function run()
    {
        DB::beginTransaction();

        try{
            $productName = config('app.name') ?? 'PropertInspection';

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

            $product = $this->findOrCreateProduct($productName);

            foreach ($plans as $plan) {
                $price = $this->findOrCreatePrice($product->id, $this->convertStripeAmount($plan['monthly_price']));

                // Insert plan
                $planId = DB::table('subscription_plans')->insertGetId([
                    'name' => $plan['name'],
                    'slug' => $plan['slug'],
                    'monthly_price' => $plan['monthly_price'],
                    'annual_price' => $plan['annual_price'],
                    'stripe_monthly_price_id' => $price->id,
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
        } catch (ApiErrorException $e) {
            DB::rollBack();
            report($e);
            $this->logException($e, 'Stripe API error in SubscriptionPlanSeeder');
            $this->command->error('Stripe API error in Subscription seeder: '.$e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            $this->logException($e, 'Unexpected error in SubscriptionPlanSeeder');
            $this->command->error('SubscriptionPlanSeeder seed failed: '.$e->getMessage());
        }
    }

    /**
     * Create Stripe product if not exist otherwise get existing.
     */
    protected function findOrCreateProduct(string $name)
    {
        try {
            $products = Product::all(['limit' => 20]);

            foreach ($products->data as $product) {
                if ($product->name === $name) {
                    $this->command->info("Product already exist: {$name}");
                    return $product;
                }
            }

            $product = Product::create(['name' => $name]);
            $this->command->info("Product created successfully: {$name}");
            return $product;
        } catch (ApiErrorException $e) {
            throw $e;
        }
    }

    /**
     * Create Stripe price for plan (but according to amount)
     */
    protected function findOrCreatePrice(string $productId, int $amount)
    {
        try {
            $prices = Price::all(['product' => $productId, 'limit' => 50]);

            foreach ($prices->data as $price) {
                if ($price->unit_amount === $amount && $price->currency === 'usd') {
                    $this->command->info("Price/Plan already exist: USD {$amount}/month");
                    return $price;
                }
            }

            $price = Price::create([
                'product' => $productId,
                'unit_amount' => $amount,
                'currency' => 'usd',
                'recurring' => ['interval' => 'day' , 'interval_count' => 1],    // 1 day for testing otherwise ['interval' => 'month']
            ]);

            $this->command->info("Price/Plan created successfully on stripe: USD {$amount}/month");
            return $price;
        } catch (ApiErrorException $e) {
            throw $e;
        }
    }

    /**
     * Convert into stripe amount
     * Todo: write global helper for this
     */
    protected function convertStripeAmount($amount){
        return (int) round($amount * 100); 
    }
}
