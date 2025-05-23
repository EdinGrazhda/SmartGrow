<?php
include "./../database.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM category WHERE categoryID = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Category deleted successfully. <a href='categories.php'>Back</a>";
    } else {
        echo "Error deleting category.";
    }
} else {
    echo "No category ID provided.";
}
$conn->close();
?>
