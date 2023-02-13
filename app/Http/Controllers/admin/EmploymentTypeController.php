<?php

namespace App\Http\Controllers\admin;

use App\Models\Employment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EmploymentTypeController extends Controller
{
    public function index()
    {
        $employments = Employment::get();
        return view('admin.employment.index', compact('employments'));
    }

    public function create()
    {
        return view('admin.employment.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'employment_type' => [
                'required',
                Rule::unique('employments', 'employment_type'),
            ],
        ]);
        Employment::create($formFields);
        return redirect()
            ->route('admin#employmentType')
            ->with('message', 'New Employment Type created successfully!');
    }

    // Route-Model Binding (Delete & Edit Page & Update)
    public function destroy(Employment $employment)
    {
        $employment->delete();
        return redirect()
            ->route('admin#employmentType')
            ->with('message', 'Employment Type deleted!');
    }

    public function edit(Employment $employment)
    {
        return view('admin.employment.edit', ['employment' => $employment]);
    }

    public function update(Request $request, Employment $employment)
    {
        Validator::make(
            $request->all(),
            [
                'employmentType' =>
                    'required|unique:employments,employment_type,' .
                    $employment->id,
            ]
        )->validate();

        Employment::where('id', $employment->id)->update([
            'employment_type' => $request->employmentType,
        ]);
        return redirect()
            ->route('admin#employmentType')
            ->with('message', 'Employment Type already Updated!');
    }
}
