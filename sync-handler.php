<?php
require_once('../../../wp-load.php'); // Load WordPress functions

global $wpdb;
$table_name = $wpdb->prefix . "watch_rooms";

// Handle admin sync update
if (isset($_POST['room_id']) && isset($_POST['sync_time']) && isset($_POST['is_playing'])) {
    $room_id = intval($_POST['room_id']);
    $sync_time = floatval($_POST['sync_time']);
    $is_playing = intval($_POST['is_playing']);

    $wpdb->update(
        $table_name,
        ['sync_time' => $sync_time, 'is_playing' => $is_playing],
        ['room_id' => $room_id]
    );
    echo json_encode(["status" => "success"]);
    exit;
}

// Handle getting sync data
if (isset($_GET['room_id'])) {
    $room_id = intval($_GET['room_id']);
    $room = $wpdb->get_row("SELECT sync_time, is_playing FROM $table_name WHERE room_id = $room_id");

    if ($room) {
        echo json_encode($room);
    } else {
        echo json_encode(["sync_time" => 0, "is_playing" => 1]);
    }
    exit;
}
?>
