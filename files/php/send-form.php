<?php

const TOKEN = '6510081991:AAEhgrF7VM4dmSJMInrGham__J7BX2SX68M';
const CHAT_ID = '-4003027626'; //'-1002010749006';

// Максимальный размер файла в байтах
$maxFileSize = 1073741824; // 1 ГБ

function sendTextWithImageToTelegram($contact, $communication, $question, $filePath) {
    $url = "https://api.telegram.org/bot" . TOKEN . "/sendDocument";

    // Получаем оригинальное имя файла
    $originalFileName = $_FILES['form-image']['name'];

    // Получаем MIME-тип файла
    $imageMimeType = mime_content_type($filePath);

    $caption = !empty($question) ? "$communication: $contact\n\nСообщение:\n$question" : "$communication: $contact";

    // Добавляем данные формы к $data
    $data = [
        'chat_id' => CHAT_ID,
        'caption' => $caption,
        'document' => new CURLFile($filePath, $imageMimeType, $originalFileName), // Передаем MIME-тип и оригинальное имя
        'parse_mode' => 'html',
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $contact = isset($_POST['form-contact']) ? strip_tags(trim($_POST['form-contact'])) : '';
    $communication = isset($_POST['communication']) ? strip_tags(trim($_POST['communication'])) : '';
    $question = isset($_POST['form-question']) ? strip_tags(trim($_POST['form-question'])) : '';

    if (!empty($contact)) {
        if (!empty($_FILES['form-image']['tmp_name'])) {
            $fileType = $_FILES['form-image']['type'];
            $filePath = $_FILES['form-image']['tmp_name'];
            $fileSize = $_FILES['form-image']['size'];

            if ($fileSize <= $maxFileSize) {
                // Получите MIME-тип изображения
                $imageMimeType = image_type_to_mime_type(exif_imagetype($filePath));

                $imageResult = sendTextWithImageToTelegram($contact, $communication, $question, $filePath, $imageMimeType);

                if (isset($imageResult['ok']) && $imageResult['ok']) {
                    echo json_encode('SUCCESS');
                } else {
                    echo json_encode('ERROR_IMAGE');
                }
            } else {
                echo json_encode('ERROR_IMAGE_SIZE');
            }
        } else {
            $caption = $question !== "" ? "$communication: $contact%0A%0AСообщение:%0A$question" : "$communication:%0A$contact";
            // if (!empty($question)) {
            //     $arr = array(
            //         strval($communication): => $contact,
            //         // 'Сообщение: ' => $question,
            //     );
            //     sendTextToTelegram($arr);
            // } else {
            //     $arr = array(
            //         strval($communication): => $contact,
            //     );
            //     sendTextToTelegram($arr);
            // }
            $sendToTelegram = fopen("https://api.telegram.org/bot" . TOKEN . "/sendMessage?chat_id=" . CHAT_ID . "&parse_mode=html&text=$caption","r");
            // Если файл не загружен, выводим сообщение об успешной отправке без файла
            echo json_encode('SUCCESS_NO_FILE');
        }
    } else {
        echo json_encode('ERROR_CONTACT_EMPTY');
    }
} else {
    header("Location: /");
}

function sendTextToTelegram($arr) {
    foreach($arr as $key => $value) {
        $txt .= "$key $value%0A";
        $txt = nl2br($txt);
    };
    $txt = $arr;
    $sendToTelegram = fopen("https://api.telegram.org/bot" . TOKEN . "/sendMessage?chat_id=" . CHAT_ID . "&parse_mode=html&text=$txt","r");
}
