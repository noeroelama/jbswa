<?php
include(dirname(__FILE__) . '/config.php');
$conn = mysqli_connect($db_host, $db_user, $db_pass, 'jbssms');

$sql = "SELECT * FROM outbox WHERE `status`=0 LIMIT " . $cronLimit;
$res = $conn->query($sql);

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $hp  = $row['DestinationNumber'];
        $msg = $row['Text'];
        $id  = $row['ID'];

        if ($onlyToContact == true) {
            $hp = substr($hp, 0, 1) == '0' ? '62' . substr($hp, 1) : $hp;

            // cek apakah $hp ada di phonebook
            $rescek = $conn->query("SELECT * FROM pbk WHERE Number='$hp'");

            if (mysqli_num_rows($rescek) == 0) {
                $conn->query("UPDATE outbox SET `status`=9 WHERE ID='$id'");
                continue;
            }
        }

        $response = sendwa($hp, $msg, $base_url, $token);
        $data     = json_decode($response, TRUE);

        // 1: sent, 0: pending/error
        $status   = ($data['status'] == 'sent') ? 1 : 0;

        // masukkan ke outboxhistory
        $resHistory = $conn->query("INSERT INTO outboxhistory SET Text='$msg', DestinationNumber='$hp', status='$status'");

        // hapus outbox
        $resDel     = $conn->query("DELETE FROM outbox WHERE ID='$id'");
    }
}

mysqli_close($conn);
