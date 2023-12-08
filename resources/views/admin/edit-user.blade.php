@props([
'user' => $props['user']
])


<x-app-layout>
  <x-slot name="header">
    <a href="/admin/users" class="font-semibold text-xl text-blue-600 leading-tight">
      {{ __('Admin') }} 
    </a>
    <p class="ml-1 font-semibold text-xl text-gray-900 dark:text-gray-200 leading-tight">
      / User (ID = {{ $user->id }})
    </p>
    <div class="font-semibold text-xl">
      <x-header-message />
    </div>
  </x-slot>

  <div class="py-12 sm:px-6 lg:px-8">
    
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
      <form action="/admin/users/{{ $user->id }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="p-6 max-w-xl space-y-6">
          <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
            <input type="text" name="name" id="name"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              value="{{ $user->name }}" required>
          </div>
          <div>
            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
            <input type="text" name="username" id="username"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              value="{{ $user->username }}" required>
          </div>
          <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input type="password" name="password" id="password"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              value="{{ $user->password }}" required>
          </div>
          <div>
            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
            <select id="role" name="role"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
              <option @if ($user->role == 2) @selected(true) @endif value="2">Manager</option>
              <option @if ($user->role == 3) @selected(true) @endif value="3">Employee</option>
            </select>
          </div>
          <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>