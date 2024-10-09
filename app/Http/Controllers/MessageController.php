<?php

namespace App\Http\Controllers;

use App\Interfaces\MessageInterface;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private MessageInterface $messageInterface;
    protected $messageRepository;

    // Injection de dépendance via le constructeur
    public function __construct(MessageInterface $messageInterface)
    {
        $this->messageInterface = $messageInterface;
    }
    // Afficher tous les messages
    public function index()
    {
        $messages = $this->messageInterface->getAllMessages();
        return response()->json($messages);
    }

    // Afficher un message spécifique par ID
    public function show($id)
    {
        $message = $this->messageInterface->getMessageById($id);
        return response()->json($message);
    }

    // Créer un nouveau message
    // public function store(Request $request)
    // {
    //     // Validation des données
    // //    $data = [
    // //         'User_id' => 'required|integer|exists:users,id',
    // //         'receiver_id' => 'nullable|integer|exists:users,id',
    // //         'file_'
    // //         'group_id' => 'required|string|max:500'
    // //     ];

    //     // Création du message via le repository
    //     $message = $this->messageInterface->createMessage($data);
    //     return response()->json($message, 201);
    // }

    // Mettre à jour un message
    public function update(Request $request, $id)
    {
        // Validation des données pour la mise à jour
        $validatedData = $request->validate([
            'message' => 'sometimes|required|string|max:500',
        ]);

        // Mise à jour du message via le repository
        $message = $this->messageInterface->updateMessage($id, $validatedData);
        return response()->json($message);
    }

    // Supprimer un message
    public function destroy($id)
    {
        // Suppression du message via le repository
        $this->messageInterface->deleteMessage($id);
        return response()->json(null, 204);
    }
}
