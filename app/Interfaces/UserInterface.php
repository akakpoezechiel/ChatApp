<?php

namespace App\Interfaces;

interface UserInterface 
{
    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);

    public function all();
    public function login(array $data);

    public function checkOtpCode (array $data);
}
