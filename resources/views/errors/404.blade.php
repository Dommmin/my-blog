<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8fafc;
            text-align: center;
            padding: 100px;
        }
        h1 {
            font-size: 5rem;
            color: #1f2937;
        }
        p {
            font-size: 1.5rem;
            color: #4b5563;
        }
        a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>
<h1>404</h1>
<p>Oops! The page you're looking for doesn't exist.</p>
<p><a href="{{ route('home') }}">Back to Home</a></p>
</body>
</html>
