<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $socket = stream_socket_client('tcp://127.0.0.1:3000');
        if ($socket) {
            $sent = stream_socket_sendto($socket, 'message');
            if ($sent > 0) {
                $server_response = fread($socket, 4096);
            }
        } else {
            return 'Unable to connect to server';
        }
        stream_socket_shutdown($socket, STREAM_SHUT_RDWR);
    }

?>

<h3><?= $server_response ?></h3>

<form method="post">
    <button type="submit">Get Message</button>
</form>
