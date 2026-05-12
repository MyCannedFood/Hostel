<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $page }}</title>
</head>
<body style="margin:0; padding:0; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial; background:#fff; color:#111;">
    <div style="display:flex;">
        @include('components.admin_sidenavbar')

        <main style="flex:1; padding: 24px; box-sizing:border-box;">
            <h1 style="margin:0;">{{ $page }}</h1>
        </main>
    </div>
</body>
</html>

