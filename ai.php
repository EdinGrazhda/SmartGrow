<?php
// Plant Health Analysis using OpenAI Vision API
session_start();

// API Configuration
$api_key = "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"; 
$api_url = "https://api.openai.com/v1/chat/completions";

// Process form submission
$analysis_result = '';
$uploaded_image = '';

// Check if it's a page refresh/load (not a form submission)
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Clear session data if any was stored
    if (isset($_SESSION['analysis_result'])) {
        unset($_SESSION['analysis_result']);
    }
    if (isset($_SESSION['uploaded_image'])) {
        // If there was an uploaded image in session, consider deleting the file
        if (file_exists($_SESSION['uploaded_image'])) {
            @unlink($_SESSION['uploaded_image']); // @ suppresses warnings if file can't be deleted
        }
        unset($_SESSION['uploaded_image']);
    }
} 
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["plant_image"])) {
    // Handle file upload
    $target_dir = "uploads/";
    
    // Create upload directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
      $file_name = basename($_FILES["plant_image"]["name"]);
    // Ensure filename has an extension
    if (empty(pathinfo($file_name, PATHINFO_EXTENSION))) {
        // Try to determine file type from mime type if no extension
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        // $mime_type = finfo_file($finfo, $_FILES["plant_image"]["tmp_name"]);
        finfo_close($finfo);
        
        // Map common image mime types to extensions
        $mime_to_ext = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/jpg' => 'jpg'
        ];
        
        // if (isset($mime_to_ext[$mime_type])) {
        //     $file_name .= '.' . $mime_to_ext[$mime_type];
        // }
    }
    
    $target_file = $target_dir . time() . '_' . $file_name;
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));    // Check if image file is a actual image and tmp_name is not empty
    if (!empty($_FILES["plant_image"]["tmp_name"]) && file_exists($_FILES["plant_image"]["tmp_name"])) {
        // First verify the file is an image using getimagesize
        $check = getimagesize($_FILES["plant_image"]["tmp_name"]);
        
        if ($check === false) {
            $analysis_result = "Error: File is not a valid image.";
            $upload_ok = 0;
        } else {
            // Additional MIME type verification
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $_FILES["plant_image"]["tmp_name"]);
            finfo_close($finfo);
            
            $allowed_mimes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($mime_type, $allowed_mimes)) {
                $analysis_result = "Error: File type not allowed. Detected MIME type: " . $mime_type;
                $upload_ok = 0;
            }
        }
    } else {
        $analysis_result = "Error: No file uploaded or file upload failed.";
        $upload_ok = 0;
    }
    
    // Check file size (limit to 5MB)
    if ($_FILES["plant_image"]["size"] > 5000000) {
        $analysis_result = "Error: Sorry, your file is too large. Max 5MB allowed.";
        $upload_ok = 0;
    }
      // Allow only certain file formats
    $image_file_type = strtolower($image_file_type); // Ensure lowercase for comparison
    $allowed_types = ["jpg", "jpeg", "png"];
    
    if (!in_array($image_file_type, $allowed_types)) {
        $analysis_result = "Error: Sorry, only JPG, JPEG & PNG files are allowed. Detected file type: " . $image_file_type;
        $upload_ok = 0;
    }
      // Debug log file upload details
    file_put_contents('upload_debug.log', date('Y-m-d H:i:s') . " - Upload details: " . 
                      json_encode([
                          'filename' => $_FILES["plant_image"]["name"],
                          'filetype' => $image_file_type,
                          'filesize' => $_FILES["plant_image"]["size"],
                          'upload_ok' => $upload_ok,
                          'error_code' => $_FILES["plant_image"]["error"]
                      ]) . PHP_EOL, FILE_APPEND);
    
    // If everything is ok, try to upload file and analyze it
    if ($upload_ok) {
        if (move_uploaded_file($_FILES["plant_image"]["tmp_name"], $target_file)) {
            $uploaded_image = $target_file;
            
            // Convert image to base64
            $image_data = base64_encode(file_get_contents($target_file));
            
            // Call OpenAI API for analysis
            $analysis_result = analyzeImage($api_key, $api_url, $image_data);
        } else {
            $analysis_result = "Error: There was an error uploading your file. Error code: " . $_FILES["plant_image"]["error"];
        }
    }
}

// Store analysis result and uploaded image path in session for potential later use
if (!empty($analysis_result)) {
    $_SESSION['analysis_result'] = $analysis_result;
}
if (!empty($uploaded_image)) {
    $_SESSION['uploaded_image'] = $uploaded_image;
}

// Function to clean up old uploaded files (older than 24 hours)
function cleanupOldUploads($directory, $maxAgeHours = 24) {
    if (!is_dir($directory)) return;
    
    $files = glob($directory . '/*');
    $now = time();
    
    foreach ($files as $file) {
        if (is_file($file)) {
            // If file is older than maxAgeHours
            if ($now - filemtime($file) > $maxAgeHours * 3600) {
                @unlink($file); // @ suppresses warnings if file can't be deleted
            }
        }
    }
}

// Run cleanup on page load (with low probability to avoid doing it too often)
if (rand(1, 10) === 1) { // 10% chance to run cleanup
    cleanupOldUploads('uploads', 24); // Delete files older than 24 hours
}

// Function to analyze image using OpenAI Vision API
function analyzeImage($api_key, $api_url, $image_data) {$headers = [
        "Content-Type: application/json",
        "Authorization: Bearer " . $api_key,
        "OpenAI-Beta: assistants=v1"
    ];
    
    // Updated payload for gpt-4o
    $payload = [
        "model" => "gpt-4o",
        "messages" => [
            [
                "role" => "user",
                "content" => [
                    [
                        "type" => "text",
                        "text" => "This is an image of a plant. Please analyze if it has any health problems. 
                                  If there are issues, describe them in detail and provide suggestions for 
                                  how to treat the plant to make it healthy again. If the plant appears healthy, 
                                  confirm that and provide general care tips for this type of plant."
                    ],
                    [
                        "type" => "image_url",
                        "image_url" => [
                            "url" => "data:image/jpeg;base64," . $image_data
                        ]
                    ]
                ]
            ]
        ],
        "max_tokens" => 1000
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $err = curl_error($ch);
      curl_close($ch);
    
    if ($err) {
        return "API Error: " . $err;
    } else {
        $response_data = json_decode($response, true);
        
        // Debug: Log the raw response to a file (remove in production)
        file_put_contents('api_response_log.txt', date('Y-m-d H:i:s') . " - Response: " . $response . PHP_EOL, FILE_APPEND);
        
        if (isset($response_data['error'])) {
            return "API Error: " . $response_data['error']['message'];
        }
        
        if (isset($response_data['choices'][0]['message']['content'])) {
            return $response_data['choices'][0]['message']['content'];
        } else {
            return "Error: Unable to extract analysis from API response. Check api_response_log.txt for details.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Health Analysis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
            text-align: center;
        }
        .upload-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .result-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .upload-area {
            border: 2px dashed #4CAF50;
            border-radius: 5px;
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
            cursor: pointer;
        }
        .upload-icon {
            font-size: 48px;
            color: #4CAF50;
        }
        #preview-image {
            max-width: 100%;
            max-height: 300px;
            margin-top: 20px;
        }
        .btn-primary {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        .btn-primary:hover {
            background-color: #45a049;
            border-color: #45a049;
        }
        .grass-container {
            height: 30px;
            overflow: hidden;
            position: relative;
            margin-bottom: -1px;
        }
        .grass-blade {
            position: absolute;
            bottom: 0;
            width: 12px;
            height: 30px;
            background: linear-gradient(to top, #4CAF50, #81C784);
            border-radius: 50% 50% 0 0;
            transform-origin: bottom center;
            animation: sway 3s infinite ease-in-out;
        }
        @keyframes sway {
            0%, 100% { transform: rotate(-8deg); }
            50% { transform: rotate(8deg); }
        }
        .grass-blade.small {
            height: 20px;
            width: 8px;
        }
        .grass-blade.large {
            height: 35px;
            width: 14px;
        }
        .footer {
            background-color: #8B4513;
            color: white;
            padding: 20px 0;
            margin-top: 30px;
            border-radius: 5px;
        }
        .footer-logo {
            font-weight: 700;
            font-size: 1.5rem;
            color: white;
        }
        .footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
        }
        .footer a:hover {
            color: white;
        }



    </style>
</head>
<body class="loading">
    <?php include 'loading.php'; ?>
    
    <div class="container">
        <div class="header">
            <h1>DEMO</h1>
            <p class="lead">Plant Health Analysis</p>
        </div>
        
        <div class="upload-container">
            <form action="" method="post" enctype="multipart/form-data" id="upload-form">
                <div class="upload-area" id="upload-area">
                    <div class="upload-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </div>
                    <h3>Drag & Drop or Click to Upload</h3>
                    <p>Upload a photo of your plant for AI analysis and care recommendations</p>
                    <input type="file" name="plant_image" id="plant-image" class="form-control" style="display: none;" accept="image/jpeg, image/png">
                </div>
                
                <div id="image-preview" class="text-center" style="display: none;">
                    <img id="preview-image" src="#" alt="Plant Preview">
                    <div class="mt-3">
                        <button type="button" class="btn btn-secondary" id="change-image">Change Image</button>
                    </div>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg" id="analyze-button">Analyze Plant Health</button>
                </div>
<br>
<div class="text-center">
<button type="button" class="btn btn-secondary btn-lg" onclick="window.location.href='index.php'">Back</button>

                </div>
            </form>
        </div>
          <?php if (!empty($analysis_result)): ?>
        <div class="result-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Analysis Results</h2>
                <a href="index.php" class="btn btn-secondary">Start New Analysis</a>
            </div>
            
            <?php if (!empty($uploaded_image)): ?>
            <div class="row mb-4">
                <div class="col-md-4">
                    <img src="<?php echo $uploaded_image; ?>" alt="Uploaded Plant" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <?php echo nl2br($analysis_result); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-danger">
                <?php echo $analysis_result; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    <script>
        // Reset form on page refresh/reload
        window.addEventListener('beforeunload', function() {
            // This will trigger a reset of the form when the page is about to unload (refresh/reload)
            // The actual deletion of files is handled server-side
            fetch('index.php', { method: 'GET', headers: { 'Clear-Analysis': 'true' } });
            // This fetch may not complete due to page unload, but the server-side PHP logic will handle cleanup
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('upload-area');
            const fileInput = document.getElementById('plant-image');
            const imagePreview = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview-image');
            const changeImageBtn = document.getElementById('change-image');
            const analyzeButton = document.getElementById('analyze-button');
            
            // Click on upload area to trigger file input
            uploadArea.addEventListener('click', function() {
                fileInput.click();
            });
            
            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.style.borderColor = '#45a049';
            });
            
            uploadArea.addEventListener('dragleave', function() {
                uploadArea.style.borderColor = '#4CAF50';
            });
            
            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.style.borderColor = '#4CAF50';
                
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    displayImagePreview();
                }
            });
            
            // Handle file selection
            fileInput.addEventListener('change', displayImagePreview);
            
            // Change image button
            changeImageBtn.addEventListener('click', function() {
                imagePreview.style.display = 'none';
                uploadArea.style.display = 'block';
                fileInput.value = '';
            });
            
            function displayImagePreview() {
                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        uploadArea.style.display = 'none';
                        imagePreview.style.display = 'block';
                        analyzeButton.disabled = false;
                    }
                    
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        });
    </script>
</body>
</html>