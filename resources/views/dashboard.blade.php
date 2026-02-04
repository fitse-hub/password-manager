@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-500">Dashboard</h1>
            <p class="text-gray-500">Welcome back, {{ auth()->user()->name }}</p>
        </div>
        <button onclick="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Add New</span>
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Credentials</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_credentials'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Categories</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Favorites</p>
                    <p id="favorites-count" class="text-3xl font-bold text-gray-900">{{ $stats['favorites'] }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Credentials Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">My Credentials</h2>
                <div class="flex items-center gap-3 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-200 w-80">
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Search" 
                        class="bg-transparent border-none focus:outline-none focus:ring-0 w-full text-gray-700 placeholder-gray-400 text-sm p-0"
                        onkeyup="searchCredentials()">
                </div>
            </div>
            <p id="searchResults" class="text-sm text-gray-500 hidden"></p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Website</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Password</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($credentials as $credential)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <button onclick="toggleFavorite({{ $credential->id }})" class="focus:outline-none transition-transform hover:scale-110" title="{{ $credential->is_favorite ? 'Remove from favorites' : 'Add to favorites' }}">
                                    <svg id="star-{{ $credential->id }}" class="w-5 h-5 {{ $credential->is_favorite ? 'text-yellow-500 fill-current' : 'text-gray-400' }}" fill="{{ $credential->is_favorite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                </button>
                                <div class="text-sm font-medium text-gray-900">{{ $credential->website_name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $credential->username_email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-900">••••••••</span>
                                <button onclick="showPassword({{ $credential->id }})" class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($credential->category)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $credential->category->name }}
                                </span>
                            @else
                                <span class="text-sm text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="editCredential({{ $credential->id }}, '{{ addslashes($credential->website_name) }}', '{{ addslashes($credential->website_url ?? '') }}', '{{ addslashes($credential->username_email) }}', {{ $credential->category_id ?? 'null' }}, '{{ addslashes($credential->encrypted_notes ?? '') }}')" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <button onclick="confirmDelete({{ $credential->id }}, '{{ addslashes($credential->website_name) }}')" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No credentials yet. Click "Add New" to get started!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6">
            {{ $credentials->links() }}
        </div>
    </div>
</div>

<!-- Add Credential Modal -->
<div id="addModal" class="hidden fixed inset-0 overflow-y-auto h-full w-full z-50" style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); background-color: rgba(255, 255, 255, 0.3);">
    <div class="relative top-20 mx-auto p-5 border border-white/20 w-96 shadow-lg rounded-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Add New Credential</h3>
            <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('credentials.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Website</label>
                <input type="text" name="website_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">URL (Optional)</label>
                <input type="url" name="website_url" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Username/Email</label>
                <input type="text" name="username_email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <div class="flex space-x-2">
                    <input type="password" id="credential-password" name="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" onclick="generatePassword()" class="mt-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 whitespace-nowrap">
                        Generate
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">None</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                <textarea name="notes" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save</button>
                <button type="button" onclick="closeAddModal()" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Credential Modal -->
<div id="editModal" class="hidden fixed inset-0 overflow-y-auto h-full w-full z-50" style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); background-color: rgba(255, 255, 255, 0.3);">
    <div class="relative top-20 mx-auto p-5 border border-white/20 w-96 shadow-lg rounded-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Edit Credential</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Website</label>
                <input type="text" id="edit-website-name" name="website_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">URL (Optional)</label>
                <input type="url" id="edit-website-url" name="website_url" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Username/Email</label>
                <input type="text" id="edit-username-email" name="username_email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password (leave blank to keep current)</label>
                <div class="flex space-x-2">
                    <input type="password" id="edit-password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" onclick="generatePasswordEdit()" class="mt-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 whitespace-nowrap">
                        Generate
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select id="edit-category-id" name="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">None</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                <textarea id="edit-notes" name="notes" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update</button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Password Display Modal -->
<div id="passwordModal" class="hidden fixed inset-0 overflow-y-auto h-full w-full z-50 flex items-center justify-center" style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); background-color: rgba(255, 255, 255, 0.3);">
    <div class="relative mx-auto p-8 border border-white/20 w-full max-w-md shadow-2xl rounded-2xl transform transition-all" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
        <div class="text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h3 class="text-xl font-bold text-gray-900 mb-2">Decrypted Password</h3>
            <p class="text-sm text-gray-500 mb-6">Your password has been securely decrypted</p>
            
            <!-- Password Display -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6 border-2 border-gray-200">
                <div class="flex items-center justify-between">
                    <span id="displayedPassword" class="text-lg font-mono font-semibold text-gray-900 break-all"></span>
                    <button onclick="copyPassword()" class="ml-3 text-blue-600 hover:text-blue-800 transition" title="Copy to clipboard">
                        <svg id="copyIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Warning -->
            <div class="flex items-start space-x-2 text-left bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-6">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <p class="text-xs text-yellow-800">Keep your password secure. This window will close automatically in <span id="countdown">30</span> seconds.</p>
            </div>
            
            <!-- Actions -->
            <button onclick="closePasswordModal()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow-md">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 overflow-y-auto h-full w-full z-50 flex items-center justify-center" style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); background-color: rgba(255, 255, 255, 0.3);">
    <div class="relative mx-auto p-8 border border-white/20 w-full max-w-md shadow-2xl rounded-2xl transform transition-all" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
        <div class="text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Credential</h3>
            <p class="text-sm text-gray-500 mb-4">Are you sure you want to delete this credential?</p>
            
            <!-- Credential Info -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6 border-2 border-gray-200">
                <p class="text-sm text-gray-600 mb-1">Website</p>
                <p id="deleteWebsiteName" class="text-lg font-semibold text-gray-900"></p>
            </div>
            
            <!-- Warning -->
            <div class="flex items-start space-x-2 text-left bg-red-50 border border-red-200 rounded-lg p-3 mb-6">
                <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <p class="text-xs text-red-800">This action cannot be undone. The credential will be permanently deleted.</p>
            </div>
            
            <!-- Actions -->
            <div class="flex space-x-3">
                <button onclick="closeDeleteModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition">
                    Cancel
                </button>
                <button onclick="executeDelete()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow-md">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let deleteCredentialId = null;
let passwordTimer = null;

function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
}

function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function editCredential(id, websiteName, websiteUrl, usernameEmail, categoryId, notes) {
    // Set form action
    document.getElementById('editForm').action = `/credentials/${id}`;
    
    // Populate form fields
    document.getElementById('edit-website-name').value = websiteName;
    document.getElementById('edit-website-url').value = websiteUrl;
    document.getElementById('edit-username-email').value = usernameEmail;
    document.getElementById('edit-category-id').value = categoryId || '';
    document.getElementById('edit-notes').value = notes;
    document.getElementById('edit-password').value = '';
    
    // Open modal
    openEditModal();
}

async function showPassword(id) {
    try {
        const response = await fetch(`/credentials/${id}/decrypt`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const data = await response.json();
        
        if (data.password) {
            // Display password in modal
            document.getElementById('displayedPassword').textContent = data.password;
            document.getElementById('passwordModal').classList.remove('hidden');
            
            // Start countdown timer
            let seconds = 30;
            document.getElementById('countdown').textContent = seconds;
            
            passwordTimer = setInterval(() => {
                seconds--;
                document.getElementById('countdown').textContent = seconds;
                
                if (seconds <= 0) {
                    closePasswordModal();
                }
            }, 1000);
        } else if (data.error) {
            alert('Error: ' + data.error);
        }
    } catch (error) {
        alert('Failed to decrypt password');
    }
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
    document.getElementById('displayedPassword').textContent = '';
    
    // Clear timer
    if (passwordTimer) {
        clearInterval(passwordTimer);
        passwordTimer = null;
    }
}

function copyPassword() {
    const password = document.getElementById('displayedPassword').textContent;
    
    navigator.clipboard.writeText(password).then(() => {
        // Change icon to checkmark
        const copyIcon = document.getElementById('copyIcon');
        copyIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
        copyIcon.classList.add('text-green-600');
        
        // Reset after 2 seconds
        setTimeout(() => {
            copyIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>';
            copyIcon.classList.remove('text-green-600');
        }, 2000);
    }).catch(() => {
        alert('Failed to copy password');
    });
}

function confirmDelete(id, websiteName) {
    deleteCredentialId = id;
    document.getElementById('deleteWebsiteName').textContent = websiteName;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    deleteCredentialId = null;
}

function executeDelete() {
    if (!deleteCredentialId) return;
    
    // Create and submit form
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/credentials/${deleteCredentialId}`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    
    form.appendChild(csrfToken);
    form.appendChild(methodField);
    document.body.appendChild(form);
    form.submit();
}

async function generatePassword() {
    try {
        const response = await fetch('/password/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                length: 16,
                uppercase: true,
                lowercase: true,
                numbers: true,
                symbols: true
            })
        });
        
        const data = await response.json();
        
        if (data.password) {
            const passwordInput = document.getElementById('credential-password');
            passwordInput.type = 'text';
            passwordInput.value = data.password;
            
            setTimeout(() => {
                passwordInput.type = 'password';
            }, 3000);
        }
    } catch (error) {
        alert('Failed to generate password');
    }
}

async function generatePasswordEdit() {
    try {
        const response = await fetch('/password/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                length: 16,
                uppercase: true,
                lowercase: true,
                numbers: true,
                symbols: true
            })
        });
        
        const data = await response.json();
        
        if (data.password) {
            const passwordInput = document.getElementById('edit-password');
            passwordInput.type = 'text';
            passwordInput.value = data.password;
            
            setTimeout(() => {
                passwordInput.type = 'password';
            }, 3000);
        }
    } catch (error) {
        alert('Failed to generate password');
    }
}

async function toggleFavorite(id) {
    try {
        const response = await fetch(`/credentials/${id}/favorite`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            const star = document.getElementById(`star-${id}`);
            
            if (data.is_favorite) {
                // Add to favorites - fill star with yellow
                star.classList.remove('text-gray-400');
                star.classList.add('text-yellow-500', 'fill-current');
                star.setAttribute('fill', 'currentColor');
                
                // Add animation
                star.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    star.style.transform = 'scale(1)';
                }, 200);
            } else {
                // Remove from favorites - outline star in gray
                star.classList.remove('text-yellow-500', 'fill-current');
                star.classList.add('text-gray-400');
                star.setAttribute('fill', 'none');
            }
            
            // Update the favorites count in stats
            updateFavoritesCount(data.is_favorite ? 1 : -1);
        }
    } catch (error) {
        console.error('Failed to toggle favorite:', error);
    }
}

function updateFavoritesCount(change) {
    // Find the favorites stat element by ID and update it
    const favoritesElement = document.getElementById('favorites-count');
    if (favoritesElement) {
        const currentCount = parseInt(favoritesElement.textContent);
        favoritesElement.textContent = currentCount + change;
    }
}

function searchCredentials() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase().trim();
    const table = document.querySelector('tbody');
    const rows = table.getElementsByTagName('tr');
    const searchResults = document.getElementById('searchResults');
    
    let visibleCount = 0;
    let totalCount = 0;
    
    // Loop through all table rows
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        
        // Skip the "no credentials" row
        if (row.querySelector('td[colspan]')) {
            continue;
        }
        
        totalCount++;
        
        // Get text content from website name, username, and category
        const cells = row.getElementsByTagName('td');
        if (cells.length > 0) {
            const websiteName = cells[0].textContent.toLowerCase();
            const username = cells[1].textContent.toLowerCase();
            const category = cells[3].textContent.toLowerCase();
            
            // Check if any field matches the search
            if (websiteName.includes(filter) || 
                username.includes(filter) || 
                category.includes(filter)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
    }
    
    // Update search results text
    if (filter === '') {
        searchResults.classList.add('hidden');
    } else {
        searchResults.classList.remove('hidden');
        if (visibleCount === 0) {
            searchResults.textContent = 'No credentials found matching "' + input.value + '"';
            searchResults.classList.add('text-red-600');
            searchResults.classList.remove('text-gray-500');
        } else {
            searchResults.textContent = 'Showing ' + visibleCount + ' of ' + totalCount + ' credentials';
            searchResults.classList.remove('text-red-600');
            searchResults.classList.add('text-gray-500');
        }
    }
}

// Close modals when clicking outside
window.onclick = function(event) {
    const passwordModal = document.getElementById('passwordModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === passwordModal) {
        closePasswordModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
}
</script>
@endsection
