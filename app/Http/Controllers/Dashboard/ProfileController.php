<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit(){
        $user=Auth::user();
        return view('dashboard.profile.edit',[
        'user'=>$user,
        'countries'=>Countries::getNames(),
        'locales'=>Languages::getNames(),

        ]);
    }

    public function update(Request $request){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required', 'string', 'max:2']
        ]);
        $user=Auth::user();
        //fill جملة بتعمل ابديت للبروفايل ولو مفيش بروفايل بتخليك تنشا بروفايل
        $user->profile->fill($request->all())->save();
        return redirect()->route('profile.edit')->with('success','profile update!');

        // $user->profile->update($request->all());
    }
}
