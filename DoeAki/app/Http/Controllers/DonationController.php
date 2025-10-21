<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_category'  => 'required|string|max:100',
            'quantity'       => 'required|integer|min:1',
            'condition'      => 'nullable|string|max:100',
            'donor_name'     => 'required|string|max:120',
            'donor_email'    => 'nullable|email|max:150',
            'donor_phone'    => 'nullable|string|max:30',
            'needs_pickup'   => 'sometimes|boolean',
            'pickup_address' => 'nullable|string|max:500',
            'notes'          => 'nullable|string|max:2000',
        ]);

        // checkbox
        $data['needs_pickup'] = (bool) ($data['needs_pickup'] ?? false);

        Donation::create($data);

        return redirect()
            ->route('donations.thanks')
            ->with('success', 'Doação registrada com sucesso!');
    }
}
