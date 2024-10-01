<?php

namespace App\Interfaces;

interface GroupeInterface
{ 
    public function addUserToGroup();

    public function getAllGroups();

    public function getGroupById($id);

    public function createGroup(array $data);

    public function updateGroup($id, array $data);

    public function deleteGroup($id);
}
