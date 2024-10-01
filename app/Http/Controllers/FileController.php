<?php

namespace App\Http\Controllers;


use App\Http\Requests\FileRequest;
use App\Interfaces\FileInterface;
use App\Models\File;
// use App\Repositories\Interfaces\FileInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    private FileInterface $fileInterface;

    public function __construct(FileInterface $fileInterface)
    {
        $this->fileInterface = $fileInterface;
    }

    // Récupère tous les fichiers
    public function index()
    {
        $files = $this->fileInterface->getAllFiles();
        return response()->json($files);
    }

    // Récupère un fichier par son ID
    public function show($id)
    {
        $file = $this->fileInterface->getFileById($id);
        return response()->json($file);
    }

    // Crée un nouveau fichier
    public function store(FileRequest $request)
    {

        $filePath = null;

        if ($request->hasFile('filepath')) {

            $file = $request->file('filepath');

            $fileName = 'chatapp_' . time() . rand(10000, 99999) . '.' . $file->getClientOriginalExtension(); // Nom unique pour le fichier
            $filePath = $file->storeAs('files', $fileName, 'public'); // Stockage de le fichier dans 'public/files'
        }

        $data = [
            'filename' => $request->filename,
            'filepath' => $filePath,
            'user_id' => $request->user_id,
            'group_id' => $request->group_id,
        ];

        DB::beginTransaction();

        $file = $this->fileInterface->store($data);
        DB::commit();
        return response()->json($file, 201);
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
