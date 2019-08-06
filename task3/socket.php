<?php
$queue = new SplQueue();
$conn = stream_socket_server('tcp://127.0.0.1:3000');

$oldErrorReporting = error_reporting(); // save error reporting level
error_reporting($oldErrorReporting ^ E_WARNING); // disable warnings

$message = null;

while (true) {
    $acceptSocket = stream_socket_accept($conn, 1);
    socket_set_blocking($acceptSocket,0);

    if ($acceptSocket) {
        $server_response = fread($acceptSocket, 4096);
        $pkt = stream_socket_recvfrom($acceptSocket, 1500, 0, $peer);

        if (false === empty($pkt)) {
            stream_socket_sendto($acceptSocket, $queue->dequeue(), 0, $peer);
        }
    } else {
        if (trim($message) != 'q' && is_null($message)) {
            echo 'Enter message, оr enter "q" to stop proces : ';
            stream_set_blocking(STDIN, 0);
            $message = fgets(STDIN);

            if (trim($message) != '' && !is_null($message)) {
                $queue->enqueue($message);
                $message = null;
                continue;
            }
        } elseif(trim($message) != 'q') {
            fclose(STDIN);
        }
    }
    fclose($acceptSocket);
}
error_reporting($oldErrorReporting); // restore error reporting level
stream_socket_shutdown($conn, STREAM_SHUT_RDWR);
