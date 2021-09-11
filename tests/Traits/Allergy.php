<?php

namespace Tests\Traits;

use App\Http\Models\Allergy as AllergyModel;
use Illuminate\Foundation\Testing\WithFaker;

trait Allergy
{
    use WithFaker;

    public function pickAllergy($token = null)
    {
        $allergies = factory(AllergyModel::class, 3)->create();
        $allergies = $allergies->pluck('id')->toArray();
        return $this->req($token)->json('POST', $this->route("/allergies"), ["allergies" => $allergies]);
    }
}
