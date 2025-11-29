<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateChangeRequestStatusRequest;
use App\Models\ChangeRequest;
use App\Services\ChangeRequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ChangeRequestReviewController extends Controller
{
    public function __construct(private readonly ChangeRequestService $service)
    {
    }

    public function index(): View
    {
        $this->authorize('viewAny', ChangeRequest::class);
        $changeRequests = $this->service->listForStaff();

        return view('admin.change-requests.index', compact('changeRequests'));
    }

    public function update(UpdateChangeRequestStatusRequest $request, ChangeRequest $changeRequest): RedirectResponse
    {
        $this->authorize('update', $changeRequest);
        $this->service->updateStatus($changeRequest, $request->validated()['status']);

        return back()->with('status', 'Change request updated.');
    }
}
