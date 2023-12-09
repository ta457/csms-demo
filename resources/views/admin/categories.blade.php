@props([
'categories' => $props['categories']
])

<x-app-layout>
  <x-slot name="sidebar">
    <x-admin.admin-sidebar />
  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Categories management') }}
    </h2>
    <div class="font-semibold text-xl">
      <x-header-message />
    </div>
  </x-slot>

  <div class="py-12 sm:px-6 lg:px-8">
    
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
      <x-admin.table-header action="/admin/categories">
      </x-admin.table-header>

      <x-admin.table-body
        action='/admin/categories/destroy-all' 
        :heads="['ID','Name','Description']">

        @foreach ($categories as $category)
          <tr class="border-b dark:border-gray-700">
            <td class="px-4 py-3">
              <input class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" 
                type="checkbox" name="selected[]" value="{{ $category->id }}" onclick="showDeleteAllBtn()">
            </td>
            <td class="px-4 py-3">
              {{ $category->id }}
            </td>
            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $category->name }}
            </th>
            <td class="px-4 py-3">
              {{ $category->description }}
            </td>
            <x-admin.table-dropdown 
              action='/admin/categories' :id="$category->id" 
              onclick="updateFormData('/api/v1/category/{{ $category->id }}','/admin/categories/{{ $category->id }}', 'category')"
            /> 
          </tr>
        @endforeach
      </x-admin.table-body>
    </div>
    <div id="admin-paginate" class="w-full mt-4 px-4 dark:text-white">
      {{ $categories->links() }}
    </div>
  </div>

  <!-- Create category modal ------------------------- -->
  <x-admin.create-modal action="/admin/categories" header="Create new category">
    <div>
      <x-input-label for="name" :value="__('Name')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-sm" placeholder="Category name" required />
    </div>

    <div>
      <x-input-label for="description" :value="__('Description')" />
      <x-text-input id="description" name="description" type="text" class="mt-1 block w-full text-sm" placeholder="Category description" required />
    </div>
  </x-admin.create-modal>

  <!-- Update modal ------------------------------ -->
  <x-admin.update-modal action="/admin/categories" header="Update category" :hideBtn="false">
    <div>
      <x-input-label for="update-created" :value="__('Created at')" />
      <x-text-input id="update-created" name="created" type="text" class="mt-1 block w-full text-sm" readonly />
    </div>

    <div>
      <x-input-label for="update-updated" :value="__('Updated at')" />
      <x-text-input id="update-updated" name="updated" type="text" class="mt-1 block w-full text-sm" readonly />
    </div>

    <div>
      <x-input-label for="update-name" :value="__('Name')" />
      <x-text-input id="update-name" name="name" type="text" class="mt-1 block w-full text-sm" placeholder="Category name" required />
    </div>

    <div>
      <x-input-label for="update-description" :value="__('Description')" />
      <x-text-input id="update-description" name="description" type="text" class="mt-1 block w-full text-sm" placeholder="Category escription" required />
    </div>
  </x-admin.update-modal>

  <!-- Delete modal ------------------------------ -->
  <x-admin.delete-modal />
  <x-admin.delete-all-modal />
</x-app-layout>