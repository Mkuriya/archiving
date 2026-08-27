<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library Archiving</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/appps.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/img/icon.jpg">

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
    <main class="h-16 bg-primary  flex items-center justify-between">
        <span class="text-2xl pl-10 text-white font-calligraphy">
            <p>NAAP Library Archiving</p>
        </span>
    </main>
    @if ($errors->any())
        <!-- Modal overlay -->
        <div id="errorModalOverlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
            <!-- Modal structure -->
            <div class="bg-gray-300 rounded-lg shadow-lg w-11/12 md:w-1/3">
                <div class="flex justify-between items-center bg-red-500 text-white text-lg p-4 rounded-t-lg">
                    <!-- Error icon -->
                    <svg height="32" style="overflow:visible;enable-background:new 0 0 32 32" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="16" style="fill:#D72828;"/>
                        <path d="M14.5,25h3v-3h-3V25z M14.5,6v13h3V6H14.5z" style="fill:#E6E6E6;"/>
                    </svg>
                    <h5 class="font-bold">SOME FIELDS ARE MISSING, PLEASE FILL THEM.</h5>
                    <button id="closeErrorModal" class="text-2xl leading-none">&times;</button>
                </div>
                <div class="p-4">
                    <div class="text-red-800 text-start pl-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
<section class="max-w-5xl pt-6 px-6 mx-auto rounded-md shadow-md sm:mt-4 mt-0 text-white">
    <form id="borrow-form" action="/admin/dashboard/logbook/input" method="POST">
        @csrf
        <div class="max-w-4xl mx-auto bg-gray-800 rounded-xl shadow-xl p-8">
           <div class="flex items-center justify-between mb-6 border-b border-gray-700 pb-3">
                <h1 class="text-2xl font-bold text-white">
                    📚 Research Log Book
                </h1>
            </div>
            <input hidden type="text" name="status" class="border border-gray-600" value="0">

            <!-- Borrow Information -->
            <div class="grid md:grid-cols-2 gap-6 mt-4">
                <!-- Borrow Date -->
                <div>
                    <label class="block text-sm text-white font-medium mb-2">
                        Date
                    </label>
                   <input type="datetime-local" name="date" value="{{ old('b_date', now()->format('Y-m-d\TH:i')) }}"
                    class="w-full px-4 py-3 rounded-lg border bg-gray-800  border-gray-600 focus:border-white focus:outline-none">
                </div>

                <!-- Book Number -->
                <div>
                    <label class="block text-sm text-white font-medium mb-2">
                        Book Number
                    </label>

                    <input type="number" id="book_number" name="b_no" placeholder="Enter Book Number" class="w-full px-4 py-3 rounded-lg border bg-gray-800  border-gray-600 focus:border-white focus:outline-none">
                </div>
            </div>

            <!-- Book Title -->
            <div class="mt-6">
                <label class="block text-sm text-white font-medium mb-2">
                    Research Title
                </label>
                <textarea id="title" name="b_name" rows="3" readonly placeholder="Book title will appear here..." class="w-full px-4 py-3 rounded-lg border bg-gray-800  border-gray-600 focus:border-white resize-none focus:outline-none"></textarea>
            </div>

            <!-- Student Information -->
            <div class="mt-6">
                <label class="block text-sm text-white font-medium mb-2">
                    Student Name
                </label>
                <input type="text" name="s_name" placeholder="Enter Student Name" class="w-full px-4 py-3 rounded-lg border bg-gray-800  border-gray-600 focus:border-white focus:outline-none">
            </div>
            <!-- Buttons -->
            <div class="flex justify-end gap-4 mt-6">

                <button type="submit" class="px-16 py-3 bg-blue-900 hover:bg-gray-700 text-white rounded-lg transition shadow-lg">
                    Save
                </button>
            </div>
        </div>
    </form>
</section>
@include('partials.notif')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const bookInput = document.getElementById('book_number');
    const titleInput = document.getElementById('title');

    bookInput.addEventListener('keyup', function () {

        let bookNumber = this.value;

        if (bookNumber === '') {
            titleInput.value = '';
            return;
        }

        fetch('/get-book/' + bookNumber)
            .then(response => response.json())
            .then(data => {

                if (data.title) {
                    titleInput.value = data.title;
                } else {
                    titleInput.value = '';
                }

            })
            .catch(error => {
                console.log(error);
                titleInput.value = '';
            });

    });

});
</script>
<script src="/js/modal.js"></script>
@extends('partials.footer')
