<?php

namespace App\Http\Controllers;


use App\Http\Requests\FileRequest;
use App\Interfaces\FileInterface;
use App\mail\fileNotification;
use App\Models\File;
// use App\Repositories\Interfaces\FileInterface;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Responses\ApiResponse;
use Illuminate\Support\Facades\Mail;

class FileController extends Controller
{
    private FileInterface $fileInterface;

    public function __construct(FileInterface $fileInterface)
    {
        $this->fileInterface = $fileInterface;
    }

    // Récupère tous les fichiers
    public function index($groupId)
    {
       try{

        $files = $this->fileInterface->getAllFiles($groupId);

        
        return ApiResponse::sendResponse(
            true,
            ['files' => $files],
            'fichiers récupérés avec succès.'
        );


       }catch (\Exception $th){
        return response()->json([
           'success' => false,
           'message' => 'Erreur lors de la récupération des données.',
            'error' => $th->getMessage()
        ], 500);
       }
   
      
    }
   


    public function download($filename)
{
    $file = storage_path("/Upload/{$filename}");
    
    if (file_exists($file)) {
        return response()->download($file);
    }
    
    return abort(404, 'Fichier non trouvé.');
}

    // Récupère un fichier par son ID
    public function show($id)
    {
        $file = $this->fileInterface->getFileById($id);
        return response()->json($file);
    }

    // Crée un nouveau fichier
    public function store(Request $request)
    {

        $request->validate([
            'group_id' => 'required|integer',
            'user_id' => 'required|integer',
            'file' => 'required|file|max: 10240' 
            
        ]);

        $file = new File();
        $file->group_id = $request->group_id;
        $file->user_id = $request->user_id;

        if ($request->hasFile('file')){
            $fichier = $request->file('file');
            $filename = $fichier->getClientOriginalName();
            $fichier->move(public_path('Upload'), $filename);
            $file->filename = $filename;	
        }

        $file->save();
        


    $groupe = Groupe::with('users')->find($request->group_id);

    if (!$groupe) {
        return response()->json(['message' => 'Groupe non trouvé.'], 404);
    }

    $emails = $groupe->users->pluck('email');

    foreach ($emails as $email) {
        Mail::to($email)->send(new FileNotification( $groupe->name)); // Corrigé : $Crew->name à $groupe->name
    }

    return response()->json(['message' => 'Notifications envoyées avec succès.'], 201);


    return response()->json([
        'success' => true,
        'message' => 'Fichier créé avec succès.',
         'file' => $file
     ], 201);



        
    }
    

    // Met à jour un fichier
    // public function update(Request $request, $id)
    // {
    //     $data = $request->validate([
    //         'name' => 'string',
    //         'path' => 'string',
    //         'group_id' => 'nullable|exists:groups,id',
    //     ]);

    //     $file = $this->fileInterface->updateFile($id, $data);
    //     return response()->json($file);
    // }

    // Supprime un fichier
    public function destroy($data)
    {
        try {
            // Supprimer le fichier en appelant la méthode du repository
            $file = $this->fileInterface->getFileById($data);
            $file->delete();
    
            // Retourner une réponse JSON de succès avec le code 200 (OK)
            return response()->json([
                'success' => true,
                'message' => 'Fichier supprimé avec succès.'
            ], 200);
    
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse JSON d'échec avec le code 500 (Erreur serveur interne)
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du fichier.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
