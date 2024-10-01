<?php

namespace App\repositories;
use App\Interfaces\MemberInterface;
use App\Models\Member;

class MemberRepository implements MemberInterface
{
    public function getAllMembers()
    {
        return Member::with(['user', 'group'])->get();
    }

    public function getMemberById($id)
    {
        return Member::with(['user', 'group'])->findOrFail($id);
    }

    public function createMember(array $data)
    {
        return Member::create($data);
    }

    public function updateMember($id, array $data)
    {
        $member = Member::findOrFail($id);
        $member->update($data);
        return $member;
    }

    public function deleteMember($id)
    {
        $member = Member::findOrFail($id);
        return $member->delete();
    }

    public function store($data)
    {
        return Member::create($data);
    }

    public function destroy(array $data)
    {
        return Member::where('id',$data);

       
    }
    
}
