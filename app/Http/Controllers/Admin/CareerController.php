<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::latest()->get();
        $applications = JobApplication::latest()->get();
        return view('admin.careers.index', compact('careers', 'applications'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);
        Career::create($request->only(['title', 'type', 'location', 'is_open']));
        return back()->with('success', 'Position created successfully.');
    }

    public function update(Request $request, Career $career)
    {
        $career->update($request->only(['title', 'type', 'location', 'is_open']));
        return back()->with('success', 'Position updated.');
    }

    public function destroy(Career $career)
    {
        $career->delete();
        return back()->with('success', 'Position deleted.');
    }

    public function updateApplication(Request $request, JobApplication $application)
    {
        $application->update(['status' => $request->status]);
        return back()->with('success', 'Application status updated.');
    }

    public function destroyApplication(JobApplication $application)
    {
        $application->delete();
        return back()->with('success', 'Application deleted.');
    }
}
