<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BrandRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('brand.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'brand_name' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'proposal_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'agree_terms' => 'required|accepted',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'brand_owner',
        ]);

        // Handle file upload
        $proposalPath = null;
        if ($request->hasFile('proposal_file')) {
            $proposalPath = $request->file('proposal_file')->store('brand-proposals', 'public');
        }

        // Create brand
        Brand::create([
            'owner_id' => $user->id,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'proposal_file' => $proposalPath,
            'verified' => false,
            'status' => 'pending',
        ]);

        // Log in the user
        Auth::login($user);

        return redirect()->route('brand.pending');
    }

    public function pending()
    {
        return view('brand.pending');
    }

    public function rejected()
    {
        return view('brand.rejected');
    }
}
