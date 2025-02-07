<!DOCTYPE html>
<html>
<head>
    <title>Test ImageKit Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .preview-image {
            max-width: 300px;
            margin-top: 20px;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .success {
            color: green;
            margin-top: 10px;
        }
        .file-info {
            color: #666;
            margin-top: 5px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h2>Test ImageKit Upload</h2>
    
    <form id="uploadForm" enctype="multipart/form-data">
        @csrf
        <div>
            <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
            <div class="file-info">
                Types acceptés: JPEG, PNG, JPG, GIF (max: 2MB)
            </div>
        </div>
        <button type="submit">Upload</button>
    </form>

    <div id="result"></div>
    <img id="preview" class="preview-image" style="display: none;">

    <script>
        document.getElementById('uploadForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const resultDiv = document.getElementById('result');
            const preview = document.getElementById('preview');
            
            try {
                resultDiv.innerHTML = 'Upload en cours...';
                preview.style.display = 'none';
                
                const response = await fetch('/test-upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    resultDiv.innerHTML = `<div class="success">${data.message}</div>`;
                    preview.src = data.image_url;
                    preview.style.display = 'block';
                } else {
                    resultDiv.innerHTML = `<div class="error">Erreur: ${data.error}</div>`;
                }
            } catch (error) {
                resultDiv.innerHTML = `<div class="error">Erreur: ${error.message}</div>`;
            }
        });
    </script>
</body>
</html>
