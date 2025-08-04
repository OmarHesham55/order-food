<?php

namespace App\Services;

use App\Models\Meal;
use Illuminate\Support\Facades\File;

class MealService
{
    public function create(array $data): Meal
    {
        $imageName = null;
        if(isset($data['image']) && $data['image'])
        {
            $imageName = ImageUploadService::handleImageUpload($data['image'],'assets/meals/uploads/');
        }
        return Meal::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $imageName,
            'restaurant_id' => $data['restaurant_id']
        ]);
    }

    public function update(array $data,Meal $meal): bool
    {
        $imageName = $meal->image;
        if(isset($data['image']) && $data['image']) {
            $imageName = ImageUploadService::handleImageUpload($data['image'],'assets/meals/uploads/',$meal->image);
        }
        return $meal->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $imageName,
        ]);
    }

    public function delete(Meal $meal): bool
    {
        if ($meal->image && File::exists(public_path('assets/meals/uploads/' . $meal->image))) {
            File::delete(public_path('assets/meals/uploads/' . $meal->image));
        }

        return $meal->delete();
    }

}
