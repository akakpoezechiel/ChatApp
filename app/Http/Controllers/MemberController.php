<?php

namespace App\Http\Controllers;

use App\Interfaces\MemberInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    

    private MemberInterface $memberInterface;


    public function __construct(MemberInterface $memberInterface)
    {
        $this->memberInterface = $memberInterface;
    }

    // Retourner tous les membres
    public function index()
    {
        $members = $this->memberInterface->getAllMembers();
        return response()->json($members);
    }

    // Afficher un membre par son ID
    public function show($id)
    {
        $member = $this->memberInterface->getMemberById($id);
        return response()->json($member);
    }

    // Créer un nouveau membre
    public function store(Request $request)
    {
        $data = [
            'user_id' =>$request->user_id,
            'groupe_id' => $request->groupe_id,
            // 'name'=>$request->name,
            // 'email'=>$request->email,
            // 'role' => '',
        ];

        // $member = $this->memberInterface->createMember($data);
        // return response()->json($member, 201);


         try{

            DB::beginTransaction();

            $data = $this->memberInterface->store($data);
            DB::commit();
            return response()->json($data, 201);

         } catch (\Exception $th) {

          return $th;

           }
    }

    // Mettre à jour un membre
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'role' => 'nullable|string|max:50',
        ]);

        $member = $this->memberInterface->updateMember($id, $validatedData);
        return response()->json($member);
    }

    // Supprimer un membre
    public function destroy($data)
    {
        return response()->json('notice');
        try {
        $member = $this->memberInterface->getMemberById($data);
        // return $member;
        $member->delete();
        return response()->json([
            'success' => true,
            'message' => 'Membre supprimé avec succès.'

            ] ,204);
    } catch (\Exception $e) {
        // En cas d'erreur, retourner une réponse JSON d'échec avec le code 500 (Erreur serveur interne)
        return response()->json([
           'success' => false,
           'message' => 'Erreur lors de la modification du membre.',
            'error' => $e->getMessage()
        ], 500);
    }
}
}

