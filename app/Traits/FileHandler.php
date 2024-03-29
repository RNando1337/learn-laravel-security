<?php 

namespace App\Traits;

trait FileHandler 
{
    use HttpResponse;
    /**
     * Handles file upload and returns the path where the file was stored
     *
     * @param Request $file The request data from user
     * @param string $targetDir [optional] The target directory where the file will be stored
     * @param string $fileName [optional] The name of the file will be stored
     * @param array $allowedExtensions [optional] An array of allowed file extensions
     * @return string The path where the file was stored
     * @throws AppException If the file upload fails
     */
    public function upload($file = null, $targetDir = "", $fileName = "", $access = 'public', $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']){
        $extension = strtolower($file->getClientOriginalExtension());
        $targetDir = $targetDir === "" ? 'uploads' : $targetDir;
        $fileName = $fileName === "" ? uniqid('', true) . '.' . $extension : $fileName . $extension;

        $messages = "Upload file activity on directory: " . $targetDir . " with filename: " . $fileName;

        // Checking for malicious activity by file extensions
        if (!in_array($extension, $allowedExtensions)) {
            
        }
        
        $file->storeAs($targetDir, $fileName, $access == 'private' ? 'local' : 'public');

        return $targetDir . "/" . $fileName;
    }
}