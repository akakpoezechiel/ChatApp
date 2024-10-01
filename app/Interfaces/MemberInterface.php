<?php

namespace App\Interfaces;

interface MemberInterface
{
    public function getAllMembers();
    public function getMemberById($id);
    public function createMember(array $data);
    public function updateMember($id, array $data);
    public function deleteMember($id);
    public function store( array $data);
    public function destroy(array $data);
}
