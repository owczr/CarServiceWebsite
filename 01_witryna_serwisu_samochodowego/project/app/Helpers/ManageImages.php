<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * Provides helpers static analysers.
 */
trait ManageImages
{
    public function storeImages(Request $request, string $images): string
    {
        if (is_array($request->file('image'))) {
            foreach ($request->file('image') as $key => $file) {
                $path = $file->store('images');
                if ($path) {
                    $images = $images.$path.'|';
                }
            }
        }
        return $images;
    }
}
