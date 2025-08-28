<?php
// 업로드 디렉토리 절대경로
$uploadDir = __DIR__ . "/uploads/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        echo "File uploaded: " . htmlspecialchars($uploadFile);
    } else {
        echo "Upload failed.";
    }
}

// 업로드된 파일 리스트 보여주기
$files = [];
if (is_dir($uploadDir)) {
    $files = array_diff(scandir($uploadDir), ['.', '..']);
}
?>

<h2>File Upload</h2>
<form enctype="multipart/form-data" method="POST">
    <input type="file" name="file">
    <input type="submit" value="Upload">
</form>

<hr>

<h2>Uploaded Files</h2>
<ul>
<?php foreach ($files as $f): ?>
    <li><a href="uploads/<?php echo urlencode($f); ?>" target="_blank">
        <?php echo htmlspecialchars($f); ?>
    </a></li>
<?php endforeach; ?>
</ul>