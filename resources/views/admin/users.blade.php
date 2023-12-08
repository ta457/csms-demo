@props([
'users' => $props['users']
])

<x-app-layout>
  <x-slot name="sidebar">
    <x-admin.admin-sidebar />
  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Admin') }}
    </h2>
    <div class="font-semibold text-xl">
      <x-header-message />
    </div>
  </x-slot>

  <div class="py-12 sm:px-6 lg:px-8">
    
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
      <x-admin.table-header action="/admin/users">
        <select name="filter_role"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full px-2 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
          <option @if (request('filter_role') == 0) @selected(true) @endif  value="0">All</option>
          <option value="2" @if (request('filter_role') == 2) @selected(true) @endif>
            Manager
          </option>
          <option value="3" @if (request('filter_role') == 3) @selected(true) @endif>
            Employee
          </option>
        </select>
      </x-admin.table-header>

      <x-admin.table-body
        action='/admin/users/destroy-all' 
        :heads="['ID','Name','Username','Email','Role']">

        @foreach ($users as $user)
          <tr class="border-b dark:border-gray-700">
            <td class="px-4 py-3">
              @if ($user->id !== 1) 
              <input class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" 
                type="checkbox" name="selected[]" value="{{ $user->id }}" onclick="showDeleteAllBtn()">
              @endif
            </td>
            <td class="px-4 py-3">
              {{ $user->id }}
            </td>
            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $user->name }}
            </th>
            <td class="px-4 py-3">
              {{ $user->username }}
            </td>
            <td class="px-4 py-3">
              {{ $user->email }}
            </td>
            <td class="px-4 py-3">
              {{ $user->role_name }}
            </td>
            @if ($user->id !== 1) <x-admin.table-dropdown action='/admin/users' :id="$user->id" /> @endif
          </tr>
        @endforeach
      </x-admin.table-body>
    </div>
    <div id="admin-paginate" class="w-full mt-4 px-4 dark:text-white">
      {{ $users->links() }}
    </div>
  </div>

  <!-- Create User modal ------------------------- -->
  <x-admin.create-modal action="/admin/users" header="Create new user">
    <div>
      <x-input-label for="name" :value="__('Name')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-sm" placeholder="John Doe" required />
    </div>

    <div>
      <x-input-label for="username" :value="__('Username')" />
      <x-text-input id="username" name="username" type="text" class="mt-1 block w-full text-sm" placeholder="John Doe" required />
    </div>

    <div>
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-sm" placeholder="johndoe@gmail.com" required />
    </div>

    <div>
      <x-input-label for="password" :value="__('Password')" />
      <x-text-input id="password" name="password" type="password" class="mt-1 block w-full text-sm" placeholder="12345678" required />
    </div>

    <div>
      <x-input-label for="role" :value="__('Role')" />
      <select id="role" name="role"
        class="mt-1 bg-gray-50 border border-gray-300 text-gray-500 dark:text-gray-500 text-sm rounded-md focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500">
        <option selected="">Select role</option>
        <option class="text-gray-900 dark:text-white" value="2">Manager</option>
        <option class="text-gray-900 dark:text-white" value="3">Employee</option>
      </select>
    </div>
  </x-admin.create-modal>

  <!-- Update modal ------------------------------ -->
  <x-admin.update-modal action="/admin/users" header="Update user">
    <div>
      <x-input-label for="update-name" :value="__('Name')" />
      <x-text-input id="update-name" name="name" type="text" class="mt-1 block w-full text-sm" 
        placeholder="John Doe" required 
      />
    </div>

    <div>
      <x-input-label for="update-username" :value="__('Username')" />
      <x-text-input id="update-username" name="username" type="text" class="mt-1 block w-full text-sm" placeholder="John Doe" required />
    </div>

    <div>
      <x-input-label for="update-email" :value="__('Email')" />
      <x-text-input id="update-email" name="email" type="email" class="mt-1 block w-full text-sm" placeholder="johndoe@gmail.com" required />
    </div>

    {{-- <div>
      <x-input-label for="update-password" :value="__('Password')" />
      <x-text-input id="update-password" name="password" type="password" class="mt-1 block w-full text-sm" placeholder="12345678" required />
    </div> --}}

    <div>
      <x-input-label for="update-role" :value="__('Role')" />
      <select id="update-role" name="role"
        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 dark:text-white text-sm rounded-md focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500">
        <option value="2">Manager</option>
        <option value="3">Employee</option>
      </select>
    </div>
  </x-admin.update-modal>

  <!-- Delete modal ------------------------------ -->
  <x-admin.delete-modal />
  <x-admin.delete-all-modal />
</x-app-layout>