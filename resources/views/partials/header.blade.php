<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library Archiving</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/appps.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/img/icon.jpg">

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   {{-- --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .font-calligraphy {
            font-family: 'Dancing Script', cursive;
        }
        .side {
            margin-right: 0;
        }

        @media (min-width: 768px) {
            .side {
                margin-right: 240px;
            }
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
        .dropdown-list {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

