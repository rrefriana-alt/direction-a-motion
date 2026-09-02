<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobPosition;
use App\Models\CareerHero;
use App\Models\CareerBenefit;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $stats = [
            'total_applications' => JobApplication::count(),
            'total_positions' => JobPosition::count(),
            'total_benefits' => CareerBenefit::count(),
            'active_positions' => JobPosition::where('is_active', true)->count(),
            'open_positions' => JobPosition::where('is_open', true)->count(),
            'pending_applications' => JobApplication::where('status', 'pending')->count(),
        ];
        return view('admin.career.index', compact('stats'));
    }

    // ==================== APPLICATIONS ====================
    public function applicationsIndex(Request $request)
    {
        $query = JobApplication::query();
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('position')) {
            $pos = JobPosition::find($request->position);
            if ($pos) $query->where('position', $pos->job_title);
        }
        if ($request->filled('education')) $query->where('education', $request->education);
        if ($request->filled('job_field')) $query->where('last_job_field', $request->job_field);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('full_name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%")->orWhere('position', 'like', "%{$s}%")->orWhere('phone', 'like', "%{$s}%"));
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(20);
        $stats = [
            'total' => JobApplication::count(),
            'pending' => JobApplication::where('status', 'pending')->count(),
            'reviewed' => JobApplication::where('status', 'reviewed')->count(),
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
        ];
        $positions = JobPosition::where('is_active', true)->orderBy('job_title')->get();
        $educations = ['sma' => 'SMA', 'smk' => 'SMK', 'd3' => 'D3', 'd4' => 'D4', 's1' => 'S1', 's2' => 'S2', 's3' => 'S3', 'other' => 'Lainnya'];
        $jobFields = ['sales' => 'Sales', 'marketing' => 'Marketing', 'finance' => 'Finance', 'grafis editor' => 'Graphic Editor', 'video editor' => 'Video Editor', 'script writer/copy' => 'Script Writer', 'content creator' => 'Content Creator', 'fotografer' => 'Fotografer', 'videografer' => 'Videografer', 'other' => 'Lainnya'];

        return view('admin.career.applications.index', compact(
            'applications', 'stats', 'positions', 'educations', 'jobFields'
        ));
    }

    public function editApplication($id)
    {
        $application = JobApplication::findOrFail($id);
        $statusOptions = ['pending' => 'Pending', 'reviewed' => 'Reviewed', 'accepted' => 'Accepted', 'rejected' => 'Rejected'];
        return view('admin.career.applications.edit', compact('application', 'statusOptions'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,reviewed,accepted,rejected']);
        try {
            $application = JobApplication::findOrFail($id);
            $oldStatus = $application->status;
            $application->update(['status' => $request->status]);
            return redirect()->route('admin.career.applications.index')->with('success', "Status {$application->full_name} diubah dari " . ucfirst($oldStatus) . " menjadi " . ucfirst($request->status));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function exportApplications(Request $request)
    {
        $query = JobApplication::query();
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('position')) $query->where('position', $request->position);
        if ($request->filled('education')) $query->where('education', $request->education);
        if ($request->filled('job_field')) $query->where('last_job_field', $request->job_field);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('full_name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%"));
        }
        $applications = $query->orderBy('created_at', 'desc')->get();
        $fileName = 'job_applications_' . date('Y-m-d_H-i-s') . '.csv';

        $callback = function () use ($applications) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['No', 'Name', 'Email', 'Phone', 'Position', 'Education', 'Status', 'Date']);
            $counter = 1;
            foreach ($applications as $a) {
                fputcsv($file, [$counter++, $a->full_name, $a->email, $a->phone, $a->position, $a->education_display, ucfirst($a->status), $a->created_at->format('Y-m-d')]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    public function downloadResume($id)
    {
        $application = JobApplication::findOrFail($id);
        if (!$application->resume_path) return redirect()->back()->with('error', 'Resume tidak ditemukan.');
        $filePath = storage_path('app/public/' . $application->resume_path);
        if (!file_exists($filePath)) return redirect()->back()->with('error', 'File tidak ditemukan.');
        return response()->download($filePath, $application->full_name . '_resume.' . pathinfo($filePath, PATHINFO_EXTENSION));
    }

    public function downloadPortfolio($id)
    {
        $application = JobApplication::findOrFail($id);
        if (!$application->portfolio_path) return redirect()->back()->with('error', 'Portfolio tidak ditemukan.');
        $filePath = storage_path('app/public/' . $application->portfolio_path);
        if (!file_exists($filePath)) return redirect()->back()->with('error', 'File tidak ditemukan.');
        return response()->download($filePath, $application->full_name . '_portfolio.' . pathinfo($filePath, PATHINFO_EXTENSION));
    }

    // ==================== POSITIONS ====================
    public function positionsIndex()
    {
        $positions = JobPosition::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        $stats = [
            'total' => JobPosition::count(),
            'active' => JobPosition::where('is_active', true)->count(),
            'open' => JobPosition::where('is_open', true)->count(),
            'closed' => JobPosition::where('is_open', false)->count(),
        ];
        return view('admin.career.positions.index', compact('positions', 'stats'));
    }

    public function positionsCreate()
    {
        $employmentTypes = JobPosition::getEmploymentTypes();
        $experienceLevels = JobPosition::getExperienceLevels();
        return view('admin.career.positions.create', compact('employmentTypes', 'experienceLevels'));
    }

    public function positionsStore(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'job_department' => 'required|string|max:255',
            'job_description' => 'required|string',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string',
            'experience_level' => 'required|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_open' => 'boolean',
        ]);

        try {
            $position = JobPosition::create([
                'job_title' => $request->job_title,
                'job_department' => $request->job_department,
                'job_description' => $request->job_description,
                'location' => $request->location,
                'employment_type' => $request->employment_type,
                'experience_level' => $request->experience_level,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active'),
                'is_open' => $request->has('is_open'),
            ]);
            return redirect()->route('admin.career.positions.index')->with('success', "Posisi '{$position->job_title}' berhasil dibuat!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function positionsEdit($id)
    {
        $position = JobPosition::findOrFail($id);
        $employmentTypes = JobPosition::getEmploymentTypes();
        $experienceLevels = JobPosition::getExperienceLevels();
        return view('admin.career.positions.edit', compact('position', 'employmentTypes', 'experienceLevels'));
    }

    public function positionsUpdate(Request $request, $id)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'job_department' => 'required|string|max:255',
            'job_description' => 'required|string',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string',
            'experience_level' => 'required|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
            'is_open' => 'sometimes|boolean',
        ]);

        try {
            $position = JobPosition::findOrFail($id);
            $position->update([
                'job_title' => $request->job_title,
                'job_department' => $request->job_department,
                'job_description' => $request->job_description,
                'location' => $request->location,
                'employment_type' => $request->employment_type,
                'experience_level' => $request->experience_level,
                'sort_order' => $request->sort_order ?? $position->sort_order,
                'is_active' => $request->has('is_active'),
                'is_open' => $request->has('is_open'),
            ]);
            return redirect()->route('admin.career.positions.index')->with('success', "Posisi berhasil diupdate!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function positionsDestroy($id)
    {
        try {
            $position = JobPosition::findOrFail($id);
            $position->delete();
            return redirect()->route('admin.career.positions.index')->with('success', 'Posisi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function positionsToggleActive($id)
    {
        try {
            $position = JobPosition::findOrFail($id);
            $position->update(['is_active' => !$position->is_active]);
            return response()->json(['success' => true, 'is_active' => $position->is_active]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function positionsToggleOpen($id)
    {
        try {
            $position = JobPosition::findOrFail($id);
            $position->update(['is_open' => !$position->is_open]);
            return redirect()->route('admin.career.positions.index')->with('success', 'Status lowongan diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function positionsUpdateSort(Request $request)
    {
        try {
            foreach ($request->positions as $pos) {
                JobPosition::where('id', $pos['id'])->update(['sort_order' => $pos['order']]);
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ==================== HERO & BENEFITS ====================
    public function heroBenefitsIndex()
    {
        $hero = CareerHero::first();
        $benefits = CareerBenefit::orderBy('sort_order')->get();
        $stats = [
            'total_benefits' => CareerBenefit::count(),
            'active_benefits' => CareerBenefit::where('is_active', true)->count(),
            'hero_active' => $hero?->is_active ?? false,
        ];
        return view('admin.career.hero-benefits.benefits-index', compact('hero', 'benefits', 'stats'));
    }

    public function heroEdit()
    {
        $hero = CareerHero::first();
        if (!$hero) {
            $hero = CareerHero::create(['description' => 'Join our team!', 'is_active' => true]);
        }
        return view('admin.career.hero-benefits.hero-edit', compact('hero'));
    }

    public function heroUpdate(Request $request)
    {
        $request->validate(['description' => 'required|string']);
        try {
            $hero = CareerHero::firstOrFail();
            $hero->update(['description' => $request->description, 'is_active' => $request->has('is_active')]);
            return redirect()->route('admin.career.hero-benefits.index')->with('success', 'Hero berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function benefitsCreate()
    {
        $iconClasses = CareerBenefit::getIconClasses();
        return view('admin.career.hero-benefits.benefits-create', compact('iconClasses'));
    }

    public function benefitsStore(Request $request)
    {
        $request->validate([
            'benefit_title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_class' => 'required|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        try {
            CareerBenefit::create([
                'benefit_title' => $request->benefit_title,
                'description' => $request->description,
                'icon_class' => $request->icon_class,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active'),
            ]);
            return redirect()->route('admin.career.hero-benefits.index')->with('success', 'Benefit berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function benefitsEdit($id)
    {
        $benefit = CareerBenefit::findOrFail($id);
        $iconClasses = CareerBenefit::getIconClasses();
        return view('admin.career.hero-benefits.benefits-edit', compact('benefit', 'iconClasses'));
    }

    public function benefitsUpdate(Request $request, $id)
    {
        $request->validate([
            'benefit_title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_class' => 'required|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        try {
            $benefit = CareerBenefit::findOrFail($id);
            $benefit->update([
                'benefit_title' => $request->benefit_title,
                'description' => $request->description,
                'icon_class' => $request->icon_class,
                'sort_order' => $request->sort_order ?? $benefit->sort_order,
                'is_active' => $request->has('is_active'),
            ]);
            return redirect()->route('admin.career.hero-benefits.index')->with('success', 'Benefit berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function benefitsDestroy($id)
    {
        try {
            CareerBenefit::findOrFail($id)->delete();
            return redirect()->route('admin.career.hero-benefits.index')->with('success', 'Benefit berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function benefitsToggleActive($id)
    {
        try {
            $benefit = CareerBenefit::findOrFail($id);
            $benefit->update(['is_active' => !$benefit->is_active]);
            return response()->json(['success' => true, 'is_active' => $benefit->is_active]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function benefitsUpdateSort(Request $request)
    {
        try {
            foreach ($request->benefits as $b) {
                CareerBenefit::where('id', $b['id'])->update(['sort_order' => $b['order']]);
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
