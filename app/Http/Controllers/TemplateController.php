<?php

namespace App\Http\Controllers;

use App\Jobs\SendTemplateJob;
use App\Models\Group;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use setasign\Fpdi\Tcpdf\Fpdi;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Template::all();
        return view('templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:templates,name|max:254',
            'description' => 'required|max:254',
            'template' => 'required|file|mimes:pdf,docx,doc,xlsx,xls,csv'
        ]);

        if ($request->hasFile('template')) {
            $directory = 'files/templates/';
            $this->checkDirectory($directory);
            $filePath = Storage::disk('public')->put('files/templates/', request()->file('template'));
        }

        $template = Template::create(
            [
                'name' => $request->name,
                'description' => $request->description,
                'template' => $filePath
            ]
        );
        if ($template) {
            return redirect()->route('templates.index')
                ->with('success', 'Template created successfully.');
        } else {
            abort(500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        return view('templates.show', compact($template));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        return view('templates.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name' => [
                'required',
                'max:254',
                Rule::unique('templates', 'name')->ignore($template)
            ],
            'description' => 'required|max:254',
            'template' => 'nullable|file|mimes:pdf,docx,doc,xlsx,xls,csv'
        ]);
        $data = $request->all();
        if (isset($data['template']) && $data['template'] == null) {
            unset($data['template']);
        }
        $template->update($data);
        return redirect()->route('templates.index')
            ->with('success', 'Template created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        if (isset($template->template)) {
            Storage::disk('public')->delete($template->template);
        }
        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Template deleted successfully');
    }

    public function showSendTemplateForm(Template $template)
    {
        $groups = Group::all();
        return view('templates.send_template', get_defined_vars());
    }

    public function sendTemplateToGroup(Request $request, Template $template)
    {
        $directory = 'certificates';
        $this->checkDirectory($directory);
        $group = Group::findOrFail($request->group_id);
        foreach ($group->members as $member) {
            SendTemplateJob::dispatch($group, $template, $member);
        }
        return redirect()->route('templates.index')
            ->with('success', 'Template Sent successfully.');
    }

    public function checkDirectory($directoryName)
    {
        if (!Storage::disk('public')->exists($directoryName)) {
            Storage::disk('public')->makeDirectory($directoryName);
        }
    }
}
