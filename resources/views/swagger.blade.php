<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>URL Shortener API Documentation</title>
    <link href="{{ l5_swagger_asset('swagger-ui.css') }}" rel="stylesheet">
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="{{ l5_swagger_asset('swagger-ui-bundle.js') }}"></script>
    <script src="{{ l5_swagger_asset('swagger-ui-standalone-preset.js') }}"></script>
    <script>
        window.onload = function() {
            const ui = SwaggerUIBundle({
                url: "{{ url('api/documentation/json') }}",
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout"
            });
            window.ui = ui;
        };
    </script>
</body>
</html>
