<?php
namespace App\Repositories;

use App\Interfaces\GroupeInterface;
use App\Models\Group;
use App\Models\Groupe;

class GroupeRepository implements GroupeInterface
{
    public function getAllGroups()
    {
        return Groupe::all();
    }

    public function addUserToGroup()
    {
        // Implement this method to add a user to a group
    }
    public function getGroupById($id)
    {
        return Groupe::findOrFail($id);
    }

    public function createGroup(array $data)
    {
        return Groupe::create($data);
    }

    public function updateGroup($id, array $data)
    {
        $group = Groupe::findOrFail($id);
        $group->update($data);
        return $group;
    }

    public function deleteGroup($id)
    {
        $group = Groupe::findOrFail($id);
        return $group->delete();
    }
}
