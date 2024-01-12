<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
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

        return view('admin.projects.index', compact('project'));
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
        $img_path = Storage::put('uploads/projects', $request['image']);
        $formData['image'] = $img_path;
        $formData['slug'] = Str::of($formData['title'])->slug('-');
        $newProject = Project::create($formData);
        $newProject->slug = Str::of("$newProject->id ".$formData['title'])->slug('-');
        $newProject->save();

        return redirect()->route('admin.projects.index')->with('createSuccess', 'Project successfully added!');
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $formData = $request->validated();
        // CREATE SLUG
        Storage::delete($project->image);
        $img_path = Storage::put('uploads/projects', $request['image']);
        $formData['image'] = $img_path;
        $project->slug = Str::of("$project->id ".$formData['title'])->slug('-');
        $project->update($formData);

        return redirect()->route('admin.projects.show', compact('project'))->with('editSuccess', 'Project successfully edited!');
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
