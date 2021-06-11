<?php

namespace App\Http\Controllers;

use App\Models\Project;
use http\Header;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;

class ProjectController extends Controller
{
    public function index()
    {
        return response($this->show(), 200);
    }

    public function create()
    {
        $this->validate(request(), [
            'project' => 'required',
            'description' => 'required'
        ]);
        $collection = request()->except(['errors', 'projects','projectId']);
        Project::create($collection);
        return $this->show();
    }

    public function store()
    {
        $this->validate(request(), [
            'projectId'=>'required',
            'project' => 'required',
            'description' => 'required'
        ]);
        $collection = request()->except(['errors','projects']);
        Project::find($collection['projectId'])
            ->update([
                'project' => $collection['project'],
                'description'=>$collection['description']
            ]);
        $collection = Project::all();
        return response($collection, 200);
    }

    public function show()
    {
        return Project::all();
    }

    public function edit(Project $project)
    {
        //
    }

    public function update(Request $request, Project $project)
    {
        //
    }

    public function destroy(Project $project,$id)
    {
        Project::destroy($id);
        return response($this->show(), 200);
    }
}
