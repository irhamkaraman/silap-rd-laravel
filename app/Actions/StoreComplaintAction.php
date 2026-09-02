<?php

namespace App\Actions;

use App\Http\Requests\StoreComplaintRequest;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use Illuminate\Support\Str;

class StoreComplaintAction
{
    /**
     * Execute the complaint submission:
     *   1. Generate a unique tracking code.
     *   2. Persist the complaint record.
     *   3. Store any uploaded file attachments.
     */
    public function execute(StoreComplaintRequest $request): Complaint
    {
        $complaint = Complaint::create([
            'tracking_code' => $this->generateTrackingCode(),
            'reporter_name' => $request->input('reporter_name'),
            'reporter_contact' => $request->input('reporter_contact'),
            'is_disability_friendly' => $request->boolean('is_disability_friendly'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'status' => 'pending',
        ]);

        $this->handleAttachments($request, $complaint);

        return $complaint;
    }

    /**
     * Generate a unique, human-readable tracking code.
     * Format: SILAP-YYYYMMDD-XXXXX (e.g. SILAP-20260902-A3K9F)
     */
    private function generateTrackingCode(): string
    {
        do {
            $code = 'SILAP-'.now()->format('Ymd').'-'.strtoupper(Str::random(5));
        } while (Complaint::where('tracking_code', $code)->exists());

        return $code;
    }

    /**
     * Store uploaded attachments and persist metadata to the database.
     */
    private function handleAttachments(StoreComplaintRequest $request, Complaint $complaint): void
    {
        if (! $request->hasFile('attachments')) {
            return;
        }

        foreach ($request->file('attachments') as $file) {
            $mimeType = $file->getMimeType() ?? '';
            $fileType = str_starts_with($mimeType, 'video/') ? 'video' : 'image';

            $path = $file->store('complaints/'.$complaint->id, 'public');

            ComplaintAttachment::create([
                'complaint_id' => $complaint->id,
                'file_path' => $path,
                'file_type' => $fileType,
            ]);
        }
    }
}
