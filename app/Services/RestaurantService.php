<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Support\Str;

class RestaurantService
{
    public function create(array $data)
    {
        $imageName = null;
        if(isset($data['image']) && $data['image']) {
            $imageName = ImageUploadService::handleImageUpload($data['image'],'assets/restaurants/uploads/');
        }

        return Restaurant::create([
           'name' => $data['name'],
            'slug' => $data['slug'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'image' => $imageName,
            'categories_id' => $data['categories_id']
        ]);
    }

    public function update(Restaurant $restaurant,array $data): bool
    {
        $imageName = $restaurant->image;

        if(isset($data['image']) && $data['image']) {
            $imageName = ImageUploadService::handleImageUpload($data['image'],'assets/restaurants/uploads/',$restaurant->image);
        }
        return $restaurant->update([
           'name' => $data['name'],
            'slug' => Str::slug($data['slug']),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'image' => $imageName,
            'categories_id' => $data['categories_id']
        ]);
    }

}
