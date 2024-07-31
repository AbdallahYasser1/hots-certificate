<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class GroupMemberImport implements ToModel
{
    use Importable;

    public function __construct(private $group)
    {
    }

    public function model(array $row)
    {
        if (empty($row[1]) || !filter_var($row[1], FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        if (GroupMember::where('email', $row[1])->where('group_id', $this->group->id)->exists()) {
            return null;
        }

        return new GroupMember([
            'group_id' => $this->group->id,
            'name' => $row[0],
            'email' => $row[1],
        ]);
    }
}
