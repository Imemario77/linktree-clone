<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->username }} - Links</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <!-- Profile Section -->
            <div class="text-center mb-8">
                <div class="inline-block h-24 w-24 rounded-full overflow-hidden bg-gray-100">
                    <img src="{{ $user->img }}" alt="Profile" class="h-full w-full object-cover">
                </div>
                <h1 class="mt-4 text-2xl font-bold text-gray-900">{{ $user->username }}</h1>
                <p class="mt-2 text-sm text-gray-500">Explore my links</p>
            </div>

            <!-- Links Section -->
            <div class="space-y-4">
                @foreach($user->links as $link)
                <a href="{{ $link->url }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="block w-full px-6 py-4 bg-white hover:bg-gray-50 shadow-sm rounded-lg transition-all duration-200 border border-gray-200 hover:border-purple-500">
                    <div class="flex items-center justify-between">
                        <span class="text-base font-medium text-gray-900">{{ $link->title }}</span>
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Footer -->
            <footer class="mt-12 text-center">
                <a href="/" class="text-sm text-purple-600 hover:text-purple-500">
                    Create your own link page →
                </a>
            </footer>
        </div>
    </div>

    <!-- Animation for link clicks -->
    <script>
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 100);
            });
        });
    </script>
</body>
</html>