<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>@yield('title', 'Simple Blog')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f6f8;
            color: #1f2937;
            font-family: Arial, sans-serif;
        }

        nav {
            background: #111827;
            padding: 16px;
        }

        nav .nav-content {
            width: min(1100px, 92%);
            margin: auto;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 6px;
        }

        nav a:hover {
            background: #374151;
        }

        .container {
            width: min(1100px, 92%);
            margin: 30px auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        }

        .card h2,
        .card h3 {
            margin-top: 0;
        }

        .meta {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 14px;
        }

        .button {
            display: inline-block;
            border: 0;
            border-radius: 7px;
            padding: 10px 15px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            background: #2563eb;
            color: white;
        }

        .button:hover {
            opacity: 0.9;
        }

        .button-secondary {
            background: #4b5563;
        }

        .button-danger {
            background: #dc2626;
        }

        .button-success {
            background: #059669;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
        }

        .actions form {
            margin: 0;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font: inherit;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #2563eb;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .checkboxes {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .checkboxes label,
        .publish-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-weight: normal;
        }

        .checkboxes input,
        .publish-label input {
            width: auto;
        }

        .alert {
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            color: #065f46;
            background: #d1fae5;
        }

        .alert-error {
            color: #991b1b;
            background: #fee2e2;
        }

        .tag {
            display: inline-block;
            background: #e5e7eb;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 13px;
            margin: 3px;
        }

        .post-body {
            line-height: 2;
            white-space: pre-line;
        }

        .empty-message {
            text-align: center;
            color: #6b7280;
        }

        small {
            display: block;
            color: #6b7280;
            margin-top: 6px;
        }
    
        .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    margin: 30px 0;
}

.pagination a {
    background: #2563eb;
    color: white;
    padding: 9px 15px;
    border-radius: 7px;
    text-decoration: none;
}

.pagination a:hover {
    opacity: 0.9;
}

.pagination-info {
    color: #4b5563;
    font-size: 14px;
}

.pagination-disabled {
    background: #e5e7eb;
    color: #9ca3af;
    padding: 9px 15px;
    border-radius: 7px;
}


        @media (max-width: 600px) {
            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            nav .nav-content {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>
<nav>
    <div class="nav-content">
        <a href="{{ route('posts.index') }}">
            Simple Blog
        </a>

        <a href="{{ route('posts.create') }}">
            Create Post
        </a>

        <a href="{{ route('posts.trash') }}">
            Trash
        </a>
    </div>
</nav>

<main class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <strong>Please correct the following errors:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>