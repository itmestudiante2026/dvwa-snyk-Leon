<?php

if (isset($_POST['Upload'])) {

    $target_path = DVWA_WEB_PAGE_TO_ROOT . "hackable/uploads/";
    $target_path .= basename($_FILES['uploaded']['name']);

    $allowed_types = ['image/jpeg', 'image/png'];
    $file_type = mime_content_type($_FILES['uploaded']['tmp_name']);

    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $file_extension = strtolower(pathinfo($target_path, PATHINFO_EXTENSION));

    // ✅ Validar primero
    if (in_array($file_type, $allowed_types) && in_array($file_extension, $allowed_extensions)) {

        // ✅ Luego subir archivo
        if (move_uploaded_file($_FILES['uploaded']['tmp_name'], $target_path)) {
            $html .= "<pre>{$target_path} successfully uploaded!</pre>";
        } else {
            $html .= '<pre>Your file was not uploaded.</pre>';
        }

    } else {
        $html .= '<pre>Archivo no permitido</pre>';
    }
}

