<?php

namespace App\Interfaces;

interface MessageInterface
{
    public function getAllMessages();

    public function getMessageById($id);

    public function createMessage(array $data);

    public function updateMessage($id, array $data);

    public function deleteMessage($id);
}
