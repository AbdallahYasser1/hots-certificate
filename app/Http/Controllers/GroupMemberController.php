<?php

namespace App\Http\Controllers;

use App\Imports\GroupMemberImport;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class GroupMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Group $group)
    {
        return view('groups.members.create', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|max:254',
            'email' => [
                'required',
                'max:254',
                Rule::unique('group_members', 'email')->where('group_id', $group->id)
            ],
        ]);


        $group->members()->create($request->all());

        return redirect()->route('groups.show', $group)
            ->with('success', 'Member Added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GroupMember $groupMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group, GroupMember $groupMember)
    {
        return view('groups.members.edit', compact('group', 'groupMember'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group, GroupMember $groupMember)
    {
        $request->validate([
            'name' => 'required|max:254',
            'email' => ['required', 'max:254', 'email'],
            Rule::unique('group_members', 'email')->where('group_id', $group->id)->ignore($groupMember->id)

        ]);

        $groupMember->update($request->all());

        return redirect()->route('groups.show', $group)
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Group $group, GroupMember $groupMember)
    {
        $groupMember->delete();
        return redirect()->route('groups.show', $group)->with('success', 'Member Deleted successfully.');
    }

    public function showImportForm(Group $group, GroupMember $groupMember)
    {
        return view('groups.members.upload', compact('group', 'groupMember'));
    }

    public function import(Request $request, Group $group)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,xls,xlsx,doc,pdf,docx,docs',
        ]);

        $file = $request->file('csv_file');
        if (!$file) {
            return redirect()->route('members.import.form')
                ->with('error', 'No file uploaded.');
        }
        try {
            Excel::import(new GroupMemberImport($group), $file);
            return redirect()->route('groups.show', $group)
                ->with('success', 'Members imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('members.import.form', $group)
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
