<?php
require_once('../../../wp-load.php'); // Load WordPress functions

global $wpdb;
$table_name = $wpdb->prefix . "watch_rooms"; // Your table name

if (isset($_POST['action'])) {
    $room_id = intval($_POST['room_id']);

    if ($_POST['action'] == 'update') {
        // Update the sync time and play status
        $sync_time = floatval($_POST['sync_time']);
        $is_playing = intval($_POST['is_playing']);

        $wpdb->update(
            $table_name,
            ['sync_time' => $sync_time, 'is_playing' => $is_playing],
            ['room_id' => $room_id]
        );
    }

    if ($_POST['action'] == 'fetch') {
        // Get sync data from database
        $data = $wpdb->get_row($wpdb->prepare("SELECT sync_time, is_playing FROM $table_name WHERE room_id = %d", $room_id), ARRAY_A);
        echo json_encode($data);
    }
}

exit();
?>
