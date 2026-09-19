<?php
namespace App\Controllers;

use App\Config;
use App\Models\TmpFile;
use Exception;

class upload_attachments {
    public function index() {
        errCode(404);
    }

    public function _post() {
        ensureIsAdmin();
        ensureAttachmentValidJSON('file', 10000000, ["image/png", "image/jpeg", "image/webp", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel", "	application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation"]);
        try {
            $filename = moveUploadedFile('file', Config::getUploadDirPath());
            TmpFile::add([
                "filename" => $filename
            ]);
            echo json_encode(["url" => "/assets/uploads/".$filename, "newToken" => generateCSRFToken()]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => $e->getMessage()]);
        }
    }
}