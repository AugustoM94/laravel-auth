<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $formData = $request->validated();
        // CREATE SLUG
        $slug = Str::slug($formData['title'], '-');
        // add slug to formData
        $formData['slug'] = $slug;
        // prendiamo l'id dell'utente loggato
        $userId = Auth::id();
        // dd($userId);
        // aggiungiamo l'id dell'utente
        $formData['user_id'] = $userId;
        if ($request->hasFile('image')) {
            $path = Storage::put('images', $request->image);
            $formData['image'] = $path;
        }
        $project = Project::create($formData);

        return redirect()->route('admin.projects.show', $project->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

  
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $formData = $request->validated();
        // CREATE SLUG
        $slug = Str::slug($formData['title'], '-');
        // add slug to formData
        $formData['slug'] = $slug;
        // prendiamo l'id dell'utente loggato
        $userId = Auth::id();
        // dd($userId);
        // aggiungiamo l'id dell'utente
        $formData['user_id'] = $userId;
        if ($request->hasFile('image')) {
            $path = Storage::put('images', $request->image);
            $formData['image'] = $path;
        }
        $post = Project::create($formData);

        return redirect()->route('admin.projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')->with('message', "$project->title eliminato con successo");
    }
}
