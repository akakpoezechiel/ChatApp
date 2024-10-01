<?php

namespace App\Repositories;

namespace App\Repositories;

use App\Interfaces\MessageInterface;
use App\Models\Message;

class MessageRepository implements MessageInterface
{
    public function getAllMessages()
    {
        return Message::all();
    }

    public function getMessageById($id)
    {
        return Message::findOrFail($id);
    }

    public function createMessage(array $data)
    {
        return Message::create($data);
    }

    public function updateMessage($id, array $data)
    {
        $message = Message::findOrFail($id);
        $message->update($data);
        return $message;
    }

    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);
        return $message->delete();
    }
}

