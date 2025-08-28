<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo json_encode(["status" => "success", "message" => "Password reset link sent"]);
}
?>