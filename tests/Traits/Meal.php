<?php

namespace Tests\Traits;

use App\Http\Models\Allergy;
use App\Http\Models\MainItem;
use App\Http\Models\Meal as MealModel;
use App\Http\Models\MealToAllergy;
use App\Http\Models\MealToSideItem;
use App\Http\Models\SideItem;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

trait Meal
{
    use WithFaker;

    public function seedMeals()
    {
        $count = 1;
        $allergies = factory(Allergy::class, 3)->create();
        $meal = factory(MealModel::class, $count)->create();
        $meal = MealModel::find($meal[0]->id);
        $sideItems = factory(SideItem::class, 5)->create();

        DB::transaction(function () use ($meal, $allergies, $sideItems, $count) {
            factory(MainItem::class, $count)->create([
                'meal_id' => $meal->id
            ]);

            $sideItems = $sideItems->random(3);

            foreach ($sideItems as $sideItem) {
                factory(MealToSideItem::class, $count)->create([
                    'meal_id' => $meal->id,
                    'side_item_id' => $sideItem->id
                ]);
            }

            foreach ($allergies as $allergy) {
                factory(MealToAllergy::class, $count)->create([
                    'meal_id' => $meal->id,
                    'allergy_id' => $allergy->id
                ]);
            }
        });
    }
}