<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;




class ProfilesController extends Controller
{
    public function index(\App\Models\User $user)
    {
        
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postCount = $user->posts->count();

        $followersCount = $user->profile->followers->count();

        $followingCount = $user->following->count();
        
        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));

    }

    public function edit(\App\Models\User $user) {

        $this->authorize('update', $user->profile);


        return view('profiles.edit', compact('user'));
    }

    public function update(\App\Models\User $user) {

        $this->authorize('update', $user->profile);

        $data = request()->validate([
            
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        if (request('image')) {

            $ImagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$ImagePath}"))->fit(1000, 1000);
            $image->save();

            $ImageArray = ['image' => $ImagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $ImageArray ?? []
        ));

        return redirect("/profile/{$user->id}");
    }
}
