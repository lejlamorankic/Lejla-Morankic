<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FitTrack API Docs</title>

    <link rel="stylesheet" href="swagger-ui.css">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />

    <style>
        body {
            margin: 0;
            background: #fafafa;
        }
    </style>
</head>

<body>
    <div id="swagger-ui"></div>

    <script src="swagger-ui-bundle.js"></script>
    <script src="swagger-ui-standalone-preset.js"></script>

    <script>
        window.onload = function () {
            SwaggerUIBundle({
                url: "swagger.php",
                dom_id: "#swagger-ui",
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                layout: "BaseLayout"
            });
        };
    </script>
</body>
</html>
