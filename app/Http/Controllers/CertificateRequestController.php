<?php

namespace App\Http\Controllers;

use App\Models\CertificateRequest;
use App\Models\Income;
use Illuminate\Http\Request;

class CertificateRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all certificate requests
        $certificateRequests = CertificateRequest::latest()->paginate(10);

        // Return a view with the data
        return view('certificate-requests.index', compact('certificateRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view for creating a certificate request
        return view('certificate-requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'clearanceNo' => 'required|string',
            'residentid' => 'required|integer',
            'findings' => 'nullable|string',
            'purpose' => 'required|string',
            'orNo' => 'required|string',
            'samount' => 'required|numeric',
            'dateRecorded' => 'required|date',
            'recordedBy' => 'required|string',
            'status' => 'required|string',
        ]);

        // Create certificate request
        $certificateRequest = CertificateRequest::create($validated);

        // Log corresponding income
        Income::create([
            'source' => "Certificate Request: {$certificateRequest->purpose}",
            'amount' => $validated['samount'],
            'date' => $validated['dateRecorded'],
            'certificate_request_id' => $certificateRequest->id,
        ]);

        return redirect()->route('certificate-requests.index')->with('success', 'Certificate request and income logged successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CertificateRequest $certificateRequest)
    {
        // Return a view showing the details of the certificate request
        return view('certificate-requests.show', compact('certificateRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CertificateRequest $certificateRequest)
    {
        // Return a view for editing the certificate request
        return view('certificate-requests.edit', compact('certificateRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CertificateRequest $certificateRequest)
    {
        $validated = $request->validate([
            'clearanceNo' => 'required|string',
            'residentid' => 'required|integer',
            'findings' => 'nullable|string',
            'purpose' => 'required|string',
            'orNo' => 'required|string',
            'samount' => 'required|numeric',
            'dateRecorded' => 'required|date',
            'recordedBy' => 'required|string',
            'status' => 'required|string',
        ]);

        // Update certificate request
        $certificateRequest->update($validated);

        return redirect()->route('certificate-requests.index')->with('success', 'Certificate request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CertificateRequest $certificateRequest)
    {
        // Delete the certificate request
        $certificateRequest->delete();

        return redirect()->route('certificate-requests.index')->with('success', 'Certificate request deleted successfully.');
    }
}
