<?php

namespace App\Http\Controllers\Api;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonationResource;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new DonationResource(true, "Donation list", Donation::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // from chatGPT
        $validator = Validator::make($request->all(), [
            'donation_name' => 'required|string|max:255',
            'donation_amount_plus' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value == 0 && $request->donation_amount_minus == 0) {
                        $fail("{$attribute} harus diisi dengan selain 0, jika donation_amount_minus diisi dengan 0.");
                    }
                },
            ],
            'donation_amount_minus' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value == 0 && $request->donation_amount_plus == 0) {
                        $fail("{$attribute} harus diisi dengan selain 0, jika donation_amount_plus diisi dengan 0.");
                    }
                },
            ],
            'donation_date' => 'nullable|date',
        ]);
        // end from chatGPT
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $donation = Donation::create([
            'donation_name' => $request->donation_name,
            'donation_amount_plus' => $request->donation_amount_plus,
            'donation_amount_minus' => $request->donation_amount_minus,
            'donation_date' => $request->donation_date
        ]);

        return new DonationResource(true, "Donation created", $donation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        return new DonationResource(true, "Donation detail", $donation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        $validator = Validator::make($request->all(), [
            'donation_name' => 'required|string|max:255',
            'donation_amount_plus' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value == 0 && $request->donation_amount_minus == 0) {
                        $fail("{$attribute} harus diisi dengan selain 0, jika donation_amount_minus diisi dengan 0.");
                    }
                },
            ],
            'donation_amount_minus' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value == 0 && $request->donation_amount_plus == 0) {
                        $fail("{$attribute} harus diisi dengan selain 0, jika donation_amount_plus diisi dengan 0.");
                    }
                },
            ],
            'donation_date' => 'nullable|date',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $donation->update([
            'donation_name' => $request->donation_name,
            'donation_amount_plus' => $request->donation_amount_plus,
            'donation_amount_minus' => $request->donation_amount_minus,
            'donation_date' => $request->donation_date
        ]);

        return new DonationResource(true, "Donation updated", $donation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();
        return new DonationResource(true, "Donation deleted", $donation);
    }
}
