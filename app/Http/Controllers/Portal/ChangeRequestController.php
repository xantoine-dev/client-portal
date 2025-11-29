<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChangeRequestRequest;
use App\Models\ChangeRequest;
use App\Models\Project;
use App\Services\ChangeRequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChangeRequestController extends Controller
{
    public function __construct(private readonly ChangeRequestService $service)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', ChangeRequest::class);
        $changeRequests = $this->service->listForClient($request->user());

        return view('portal.change-requests.index', compact('changeRequests'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', ChangeRequest::class);
        $projects = Project::whereIn('client_id', $request->user()->clients()->pluck('clients.id'))
            ->orderBy('name')
            ->get();

        return view('portal.change-requests.create', compact('projects'));
    }

    public function store(StoreChangeRequestRequest $request): RedirectResponse
    {
        $this->service->createForClient($request->user(), $request->validated());

        return redirect()
            ->route('portal.change-requests.index')
            ->with('status', 'Change request submitted.');
    }
}
