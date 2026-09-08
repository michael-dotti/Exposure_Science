<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatusType;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $selectedStatus = $request->query('status');

        $projects = Project::with('users')
            ->filterByStatus($selectedStatus)
            ->paginate(9)
            ->withQueryString();

        $statuses = ProjectStatusType::cases();

        $currentFilters = [];

        if ($selectedStatus) {
            $status = collect($statuses)->first(function ($status) use ($selectedStatus) {
                return (string) $status->value === (string) $selectedStatus;
            });

            if ($status) {
                $currentFilters[] = [
                    'label' => 'Stato',
                    'value' => $status->label(),
                ];
            }
        }

        return view('public.projects.index', compact(
            'projects',
            'statuses',
            'currentFilters'
        ));
    }

    public function show(Project $project)
    {
        $project->load('users');

        return view('public.projects.show', compact('project'));
    }
}