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
                <div class="border-r border-gray-200 pt-5 flex flex-col flex-grow overflow-y-auto">
                    <div class="flex-grow flex flex-col">
                        <nav class="flex-1 bg-white px-2 space-y-1">{!! $index !!}</nav>
                    </div>
                    <div class="flex-shrink-0 flex border-t border-gray-200 p-4 items-center justify-center">
                        <a
                            href="postman"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Download postman collection
                        </a>
                      </div>
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
