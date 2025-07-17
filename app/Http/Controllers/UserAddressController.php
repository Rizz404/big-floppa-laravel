<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{
    public function index()
    {
        $userAddresses = Auth::user()->userAddresses()->latest()->get();
        return view('pages.user.profile.addresses.index', compact('userAddresses'));
    }

    public function create()
    {
        return view('pages.user.profile.addresses.create');
    }

    public function store(StoreUserAddressRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        DB::transaction(function () use ($user, $validated) {
            if (!empty($validated['is_primary'])) {
                $user->userAddresses()->update(['is_primary' => false]);
            }
            $user->userAddresses()->create($validated);
        });

        return redirect()->route('profile.addresses.index')->with('success', 'Address added successfully.');
    }

    public function edit(UserAddress $address)
    {
        // Todo: Nanti pelajari lagi tentang providers dan gate
        // $this->authorize('update', $address);
        return view('pages.user.profile.addresses.edit', compact('address'));
    }

    public function update(StoreUserAddressRequest $request, UserAddress $address)
    {
        // $this->authorize('update', $address);
        $validated = $request->validated();
        $user = Auth::user();

        DB::transaction(function () use ($user, $address, $validated) {
            if (!empty($validated['is_primary'])) {
                $user->userAddresses()->where('id', '!=', $address->id)->update(['is_primary' => false]);
            }
            $address->update($validated);
        });

        return redirect()->route('profile.addresses.index')->with('success', 'Address updated successfully.');
    }

    public function destroy(UserAddress $address)
    {
        // $this->authorize('delete', $address);

        if ($address->is_primary) {
            return back()->with('error', 'Cannot delete primary address. Please set another address as primary first.');
        }

        $address->delete();
        return back()->with('success', 'Address deleted successfully.');
    }



    public function setPrimary(UserAddress $address)
    {
        // $this->authorize('update', $address);
        $user = Auth::user();

        DB::transaction(function () use ($user, $address) {
            $user->userAddresses()->update(['is_primary' => false]);
            $address->update(['is_primary' => true]);
        });

        return back()->with('success', 'Primary address has been updated.');
    }
}
