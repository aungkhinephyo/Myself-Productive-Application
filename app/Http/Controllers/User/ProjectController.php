<?php

namespace App\Http\Controllers\User;

use App\Models\Project;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\StoreProjectRequest;
use App\Http\Requests\User\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        return view('user.project.index');
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        $this->checkPermission($project->user_id);

        return view('user.project.show', compact('project'));
    }

    public function ssd(Request $request)
    {
        $projects = Project::query()->where('user_id', auth()->id());
        return Datatables::of($projects)
            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->editColumn('title', function ($each) {
                $link = '<a href="' . route('project.show', $each->id) . '" class="go-to-link" title="Go to project">' . $each->title . '</a>';
                return $link;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $info_icon = '';
                $delete_icon = '';

                $edit_icon = '<a href="' . route('project.edit', $each->id) . '" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                $delete_icon = '<a href="javascript:void(0);" class="text-danger delete-btn" data-id="' . $each->id . '" title="Delete"><i class="bi bi-trash"></i></a>';

                return '<div class="action-icons">' . $edit_icon . $info_icon . $delete_icon . '</div>';
            })
            ->rawColumns(['title', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('user.project.create');
    }

    public function store(StoreProjectRequest $request)
    {

        $images = null;
        if ($request->hasFile('images')) {
            $images = [];
            $img_files = $request->file('images');
            foreach ($img_files as $img_file) {
                $img_name = uniqid() . '_' . $img_file->getClientOriginalName();
                Storage::disk('public')->put('project/images/' . $img_name, file_get_contents($img_file));
                $images[] = $img_name;
            }
        }

        $files = null;
        if ($request->hasFile('files')) {
            $files = [];
            $pdf_files = $request->file('files');
            foreach ($pdf_files as $pdf_file) {
                $pdf_name = uniqid() . '_' . $pdf_file->getClientOriginalName();
                Storage::disk('public')->put('project/files/' . $pdf_name, file_get_contents($pdf_file));
                $files[] = $pdf_name;
            }
        }

        $project = Project::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'title' => $request->title,
            ],
            [
                'description' => $request->description,
                'start_date' => $request->start_date,
                'deadline' => $request->deadline,
                'images' => $images,
                'files' => $files,
            ]
        );

        return to_route('project.index')->with(['success' => 'New project created.']);
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $this->checkPermission($project->user_id);

        return view('user.project.edit', compact('project'));
    }

    public function update($id, UpdateProjectRequest $request)
    {
        $project = Project::findOrFail($id);
        $this->checkPermission($project->user_id);

        $images = $project->images;
        if ($request->hasFile('images')) {
            foreach ($project->images ?? [] as $image) {
                Storage::disk('public')->delete('project/images/' . $image);
            }

            $images = [];
            $img_files = $request->file('images');
            foreach ($img_files as $img_file) {
                $img_name = uniqid() . '_' . $img_file->getClientOriginalName();
                Storage::disk('public')->put('project/images/' . $img_name, file_get_contents($img_file));
                $images[] = $img_name;
            }
        }

        $files = $project->files;
        if ($request->hasFile('files')) {
            foreach ($project->files ?? [] as $file) {
                Storage::disk('public')->delete('project/files/' . $file);
            }

            $files = [];
            $pdf_files = $request->file('files');
            foreach ($pdf_files as $pdf_file) {
                $pdf_name = uniqid() . '_' . $pdf_file->getClientOriginalName();
                Storage::disk('public')->put('project/files/' . $pdf_name, file_get_contents($pdf_file));
                $files[] = $pdf_name;
            }
        }

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'images' => $images,
            'files' => $files,
        ]);

        return to_route('project.index')->with(['success' => 'Project updated.']);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $this->checkPermission($project->user_id);

        foreach ($project->images ?? [] as $image) {
            Storage::disk('public')->delete('project/images/' . $image);
        }
        foreach ($project->files ?? [] as $file) {
            Storage::disk('public')->delete('project/files/' . $file);
        }
        $project->delete();
        return response()->json(['message' => 'success'], 200);
    }

    private function checkPermission($id)
    {
        if (auth()->id() != $id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
