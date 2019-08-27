<?php

require '../../../bootloader.php';

$response = [
    'status' => null,
    'data' => [],
    'errors' => []
];

if ($_SESSION) {

    $model = new App\Participants\Model();

    // fetch-as atsiunčia į šitą failą POST metodu duomenis (REQUEST)
    // tie duomenys tai yra formData
    //
    // Į formData buvom įtraukę drink'o id. Vadinasi POST'e indeksu id rasim
    // to drink'o id verte.
    //
    // Zinodami koks drinko eilutes id, galime su model'iu issitraukti
    // ta drinka. Bet get funkcija atiduoda ne "iskart" ta drinka
    // bet visada ideda ji i masyva. (nes funkcija pritaikyta atiduoti ir daugiau drinku
    // nei viena)
    // Todel pavadinam variabla ne drink, o drinks.
    $participants = $model->get(['row_id' => intval($_POST['id'])]);

    if ($participants) {
        $person = $participants[0];
        $model->delete($person);

        $response['status'] = 'success';
        $response['data'] = $person->getData();
    } else {
        $response['status'] = 'fail';
        $response['errors'][] = 'Participant doesn`t exist';
    }
} else {
    $response['status'] = 'fail';
    $response['errors'][] = 'Authorization failed!';
}

print json_encode($response);