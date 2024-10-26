@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Profile Section -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Your Profile
                    </h3>
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">
                            Your public profile: 
                            <a href="/{{ auth()->user()->username }}" class="text-purple-600 hover:text-purple-500">
                                {{ config('app.url') }}/{{ auth()->user()->username }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Statistics
                    </h3>
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-2xl font-semibold text-gray-900">{{ auth()->user()->links->count() }}</p>
                            <p class="text-sm text-gray-500">Total Links</p>
                        </div>
                        <div>
                            <p class="text-2xl font-semibold text-gray-900">{{ auth()->user()->shortUrls->count() }}</p>
                            <p class="text-sm text-gray-500">Shortened URLs</p>
                        </div>
                    </div>
                </div>
            </div>

               <!-- Links Management -->
    <div class="bg-white overflow-hidden shadow rounded-lg col-span-1 md:col-span-2">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Your Links
                </h3>
                <button onclick="toggleModal('addLinkModal')" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                    Add New Link
                </button>
            </div>
            <div class="mt-4">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach(auth()->user()->links as $link)
                                            <tr id="link-row-{{ $link->id }}">
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $link->title }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $link->url }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button type="button" 
                                                            onclick="openEditLinkModal({{ $link->id }}, '{{ addslashes($link->title) }}', '{{ addslashes($link->url) }}')" 
                                                            class="text-indigo-600 hover:text-indigo-900">
                                                        Edit
                                                    </button>
                                                    <button type="button" 
                                                            onclick="deleteLink({{ $link->id }})" 
                                                            class="ml-4 text-red-600 hover:text-red-900">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- URL Shortener Section -->
    <div class="mt-6 px-6 pb-6 bg-white overflow-hidden shadow rounded-lg  col-span-1 md:col-span-2">
          <form action="{{ route('short-urls.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="original_url" class="block text-sm font-medium text-gray-700">Enter URL to Shorten</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="url" name="original_url" id="original_url" class="focus:ring-purple-500 focus:border-purple-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300" placeholder="https://example.com">
                        <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            Shorten
                        </button>
                    </div>
                </div>
            </form>
        <div class="mt-6">
            <h4 class="text-md font-medium text-gray-900 mb-3">Your Shortened URLs</h4>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Original URL</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Short URL</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clicks</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach(auth()->user()->shortUrls as $url)
                                   <tr id="shorturl-row-{{ $url->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($url->original_url, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-600">
                                            <a href="{{ route('short-urls.redirect', $url->short_code) }}" target="_blank">
                                                {{ config('app.url') }}/s/{{ $url->short_code }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $url->clicks }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button type="button" 
                                                    onclick="copyToClipboard('{{ route('short-urls.redirect', $url->short_code) }}')" 
                                                    class="text-purple-600 hover:text-purple-900">
                                                Copy
                                            </button>
                                            <button type="button" 
                                                    onclick="deleteShortUrl({{ $url->id }})" 
                                                    class="ml-4 text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>

<!-- Add Link Modal -->
<div id="addLinkModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('links.store') }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                        <input type="url" name="url" id="url" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Add Link
                    </button>
                    <button type="button" onclick="toggleModal('addLinkModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Edit Link Modal -->
<div id="editLinkModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editLinkForm" method="POST" onsubmit="event.preventDefault(); submitEditForm(this);">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <label for="edit_title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="edit_title" required
                               class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="edit_url" class="block text-sm font-medium text-gray-700">URL</label>
                        <input type="url" name="url" id="edit_url" required
                               class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update Link
                    </button>
                    <button type="button" 
                            onclick="toggleModal('editLinkModal')"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle('hidden');
}

function openEditLinkModal(id, title, url) {
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_url').value = url;
    document.getElementById('editLinkForm').action = `/links/${id}`;
    toggleModal('editLinkModal');
    alert(document.getElementById('editLinkForm').action )
}

function deleteLink(id) {
    if (confirm('Are you sure you want to delete this link?')) {
        fetch(`/links/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                document.getElementById(`link-row-${id}`).remove();
            } else {
                alert('Error deleting link');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting link');
        });
    }
}

function deleteShortUrl(id) {
    if (confirm('Are you sure you want to delete this shortened URL?')) {
        fetch(`/short-urls/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                document.getElementById(`shorturl-row-${id}`).remove();
            } else {
                alert('Error deleting shortened URL');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting shortened URL');
        });
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
        .then(() => {
            alert('URL copied to clipboard!');
        })
        .catch(err => {
            console.error('Failed to copy text: ', err);
            alert('Failed to copy URL');
        });
}

async function submitEditForm(form) {
    // Get form data
    const formData = new FormData(form);
    const title = formData.get('title');
    const url = formData.get('url');
    
    // Get the link ID from the form action URL
    const linkId = form.action.split('/').pop();
    
    // Send AJAX request
   const res = await fetch(form.action, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            title: title,
            url: url
        })
    })


    if (res.status === 200) {
        const row = document.getElementById(`link-row-${linkId}`);
        if (row) {
            const cells = row.getElementsByTagName('td');
            cells[0].textContent = title;
            cells[1].textContent = url;
        }
        
        // Close the modal
        toggleModal('editLinkModal');
          alert('Link updated successfully!');
        return null
    }

    console.error('Error:', error);
    alert('Error updating link. Please try again.');
}
</script>
@endsection
