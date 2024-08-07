<!DOCTYPE html>
<html lang="EN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> @yield('title') | {{ config('app.name') }}</title>

    <link href="https://bootswatch.com/5/journal/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="d-flex flex-column vh-100">
    <header>
        @include('layout.nav')
    </header>

    <main class="flex-shrink-0">
        <div class="container py-4">
            {{-- Page content --}}
            @yield('content')
        </div>
    </main>

    <footer class="mt-auto">
        <div class="container py-4 d-md-flex justify-content-between align-items-center">
            <span class="text-body-tertiary fw-medium small">© 2023 <a
                    class="link-underline link-underline-opacity-0 link-underline-opacity-100-hover"
                    href="{{ route('dashboard') }}">Ideas</a>. All Rights Reserved.</span>
            <ul class="list-unstyled d-flex mb-0 mt-3 mt-md-0">
                <li class="me-4">
                    <a class="text-body-tertiary fw-semibold link-secondary link-underline link-underline-opacity-0 link-underline-opacity-100-hover"
                        href="{{ route('terms') }}">@lang('shared.terms')</a>
                </li>
            </ul>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

</body>

</html>
