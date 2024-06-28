<?php
try {
    $db = new PDO('sqlite:projectweek4.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Unable to connect: " . $e->getMessage();
    exit;
}
?>
