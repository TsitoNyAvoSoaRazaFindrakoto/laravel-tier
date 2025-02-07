<!DOCTYPE html>
<html>
<head>
    <title>Images Uploadées</title>
    <style>
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .image-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .image-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }
        .image-info {
            margin-top: 10px;
            font-size: 0.9em;
            color: #666;
        }
        .error-message {
            background-color: #fee;
            color: #c00;
            padding: 10px;
            margin: 10px 20px;
            border-radius: 4px;
            border: 1px solid #fcc;
        }
        .no-images {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        .header {
            padding: 20px;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }
        .upload-link {
            display: inline-block;
            margin-left: 20px;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .upload-link:hover {
            background: #0056b3;
        }
        body {
            margin: 0;
            background: #f9f9f9;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0; display: inline-block;">Images Uploadées</h2>
        <a href="{{ url('/test-upload') }}" class="upload-link">Uploader une nouvelle image</a>
    </div>

    @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    @if(count($images) > 0)
        <div class="image-grid">
            @foreach($images as $image)
            <div class="image-card">
                <img src="{{ $image->url }}" alt="Image uploadée" onerror="this.src='https://via.placeholder.com/200x200?text=Image+non+disponible'">
                <div class="image-info">
                    <div><strong>ID:</strong> {{ $image->fileId }}</div>
                    <div><strong>Nom:</strong> {{ $image->name }}</div>
                    <div><strong>Date:</strong> {{ $image->createdAt }}</div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="no-images">
            Aucune image n'a été uploadée pour le moment.
            <br><br>
            <a href="{{ url('/test-upload') }}" class="upload-link">Uploader votre première image</a>
        </div>
    @endif
</body>
</html>
