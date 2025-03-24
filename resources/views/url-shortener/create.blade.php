<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">URL Shortener</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($shortUrl))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <p class="font-medium">URL shortened successfully!</p>
                <div class="mt-2">
                    <span class="font-medium">Original URL:</span>
                    <a href="{{ $originalUrl }}" class="break-all hover:text-green-800" target="_blank">{{ $originalUrl }}</a>
                </div>
                <div class="mt-2">
                    <span class="font-medium">Short URL:</span>
                    <a href="{{ $shortUrl }}" class="break-all hover:text-green-800" target="_blank" id="shortUrl">{{ $shortUrl }}</a>
                </div>
                <button onclick="copyToClipboard()" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                    Copy Short URL
                </button>
            </div>
        @endif

        <form action="{{ route('url.shorten') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="url" class="block text-sm font-medium text-gray-700 mb-1">Enter URL to shorten</label>
                <input type="url" 
                       name="url" 
                       id="url" 
                       required
                       value="{{ old('url') }}"
                       placeholder="https://example.com"
                       class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="custom_alias" class="block text-sm font-medium text-gray-700 mb-1">
                    Custom alias (optional)
                    <span class="text-gray-500 text-xs">3-20 characters, letters, numbers, hyphens, and underscores only</span>
                </label>
                <input type="text" 
                       name="custom_alias" 
                       id="custom_alias"
                       value="{{ old('custom_alias') }}"
                       pattern="[a-zA-Z0-9-_]+"
                       minlength="3"
                       maxlength="20"
                       placeholder="my-custom-url"
                       class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">
                Shorten URL
            </button>
        </form>
    </div>

    <script>
        function copyToClipboard() {
            const shortUrl = document.getElementById('shortUrl').textContent;
            navigator.clipboard.writeText(shortUrl).then(() => {
                alert('Short URL copied to clipboard!');
            });
        }
    </script>
</body>
</html>
