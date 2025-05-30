<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Http\Controllers\UserDetailsController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserDetails;

class UpdateUserProfileInformation extends Component
{

    public $state = [];

    public function mount()
    {
        $this->state = UserDetails::where('user_id', Auth::id())
        ->first()
        ->only([
            'address',
            'phone_number',
            'gender',
            'date_of_birth'
        ]);
    }

    public function saveProfile()
    {
        $this->validate([
            'state.address' => 'required|string|max:255',
            'state.phone_number' => 'required|string',
            'state.gender' => 'required|in:male,female,other',
            'state.date_of_birth' => 'required|date'
        ]);

        $request = Request::create('/dummy-url', 'POST', $this->state);

        (new UserDetailsController)->update($request);

        $this->dispatch('saved'); // for success message
    }
    
    public function render()
    {
        return view('livewire.profile.update-user-profile-information');
    }

}
