<?php

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $s1 = new Subscription;
		$s1->name = 'Free';
		$s1->properties = '{"MeasurementProfiles" : 1,"ProjectManagement" : 1}';
		$s1->save();
		
		$s2 = new Subscription;
		$s2->name = 'Basic';
		$s2->properties = '{"MeasurementProfiles" : 5,"ProjectManagement" : "unlimited"}';
		$s2->save();
		
		$s3 = new Subscription;
		$s3->name = 'Premium';
		$s3->properties = '{"MeasurementProfiles" : 5,"ProjectManagement" : "unlimited"}';
		$s3->save();
    }
}
