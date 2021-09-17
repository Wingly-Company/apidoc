<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>

        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://unpkg.com/@tailwindcss/typography@0.4.x/dist/typography.min.css" rel="stylesheet">
    </head>
    <body class="antialiased h-screen bg-white overflow-hidden flex">
        <!-- Sidebar -->
        <div class="flex flex-shrink-0 docs-sidebar">
            <div class="w-96 flex flex-col">
                <div class="border-r border-gray-200 pt-5 pb-4 flex flex-col flex-grow overflow-y-auto">
                    <div class="flex-grow flex flex-col">
                        <nav class="flex-1 bg-white px-2 space-y-1">{!! $index !!}</nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main -->
        <main class="flex-1 relative overflow-y-auto focus:outline-none bg-gray-100">
            <div class="py-6">
                <div class="px-4 prose">{!! $content !!}</div>
            </div>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                let links = [...document.getElementsByClassName('docs-sidebar')[0].getElementsByTagName('a')];

                let current = links.filter((el) => el.href === window.location.href )[0];

                (current || links[0]).parentElement.classList.add('underline', 'font-semibold');
            })
        </script>
    </body>
</html>
