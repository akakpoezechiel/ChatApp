<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\GroupeRequest;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\User;
use App\Interfaces\GroupeInterface;
use App\Models\Groupe;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GroupeController extends Controller
{
    private GroupeInterface $groupeInterface;
    public function __construct(GroupeInterface $GroupeInterface)
    {
        $this->groupeInterface = $GroupeInterface;
    }

    
    public function createGroup(GroupeRequest $request)

    
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $request->user_id,
        ];
    
        DB::beginTransaction();
    
        try {
            $group = $this->groupeInterface->createGroup($data);
    
            DB::commit();
            return ApiResponse::sendResponse(
                true,
                [new UserResource($group)], // Vérifie si $group contient bien les données
                'Groupe créé avec succès.'  // Message de succès clair
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du groupe.',
                'error' => $th->getMessage() // Renvoyer le message d'erreur pour comprendre ce qui se passe
            ], 500); // Utiliser un code d'erreur HTTP 500 en cas d'erreur
        }
    }
    
    

    public function addUserToGroup(Request $request, $groupId)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
    
        $group = Groupe::findOrFail($groupId);
    
        $group->users()->attach($data['user_id']); // Utilisez $data ici pour l'ID de l'utilisateur
    
        // Retourner une réponse JSON
        return response()->json(['message' => 'User added to group'], 201);
    }
    


    public function getAllGroups()
    {
        try {
            // Récupérer tous les groupes de la base de données
            $groups = $this->groupeInterface->getAllGroups();
    
            // Retourner les groupes avec un message de succès
            return ApiResponse::sendResponse(
                true,
                ['groups' => $groups],
                'Groupes récupérés avec succès.'
            );
        } catch (\Throwable $th) {
            // Gérer les erreurs et renvoyer une réponse d'erreur
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des groupes.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    

public function getGroupById($id)
{
    try {
        $group = $this->groupeInterface->getGroupById($id);
        return response()->json($group, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Groupe non trouvé'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la récupération du groupe'], 500);
    }
}

public function updateGroup(Request $request, $id)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        $group = $this->groupeInterface->updateGroup($id, $data);
        return response()->json($group, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Groupe non trouvé'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la mise à jour du groupe'], 500);
    }
}


public function deleteGroup($id)
{
    try {
        $this->groupeInterface->deleteGroup($id);
        return response()->json(['message' => 'Groupe supprimé avec succès'], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Groupe non trouvé'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la suppression du groupe'], 500);
    }
}

}
