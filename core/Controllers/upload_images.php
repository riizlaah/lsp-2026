<?php
namespace App\Controllers;

use App\Config;
use App\Models\TmpFile;
use Exception;

class upload_images {
    public function index() {
        errCode(404);
    }

    public function _post() {
        ensureIsAdmin();
        ensureImageValidJSON('file');
        try {
            $filename = moveUploadedFile('file', Config::getUploadDirPath());
            TmpFile::add([
                "filename" => $filename
            ]);
            echo json_encode(["url" => "/assets/uploads/".$filename, "newToken" => generateCSRFToken()]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Failed to upload file"]);
        }
    }
}