@props([
'providers' => $props['providers']
])

<x-app-layout>
  <x-slot name="sidebar">
    <x-admin.admin-sidebar />
  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Providers management') }}
    </h2>
    <div class="font-semibold text-xl">
      <x-header-message />
    </div>
  </x-slot>

  <div class="py-12 sm:px-6 lg:px-8">
    
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
      <x-admin.table-header action="/admin/providers" search="Name/description/phone/email">
      </x-admin.table-header>

      <x-admin.table-body
        action='/admin/providers/destroy-all' 
        :heads="['ID','Name','Description','Phone','Email','Address']">

        @foreach ($providers as $provider)
          <tr class="border-b dark:border-gray-700">
            <td class="px-4 py-3">
              @if ($provider->id !== 1) 
              <input class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" 
                type="checkbox" name="selected[]" value="{{ $provider->id }}" onclick="showDeleteAllBtn()">
              @endif
            </td>
            <td class="px-4 py-3">
              {{ $provider->id }}
            </td>
            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $provider->name }}
            </th>
            <td class="px-4 py-3">
              {{ $provider->description }}
            </td>
            <td class="px-4 py-3">
              {{ $provider->phone }}
            </td>
            <td class="px-4 py-3">
              {{ $provider->email }}
            </td>
            <td class="px-4 py-3">
              {{ $provider->address }}
            </td>
            @if ($provider->id !== 1) 
              <x-admin.table-dropdown 
                action='/admin/providers' :id="$provider->id" 
                onclick="updateFormData('/api/v1/provider/{{ $provider->id }}','/admin/providers/{{ $provider->id }}', 'provider')"
              >
                {{-- <li>
                  <a class="hover:cursor-pointer flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor"
                      aria-hidden="true">
                      <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                    </svg>
                    Orders
                  </a>
                </li> --}}
              </x-admin.table-dropdown> 
            @endif
          </tr>
        @endforeach
      </x-admin.table-body>
    </div>
    <div id="admin-paginate" class="w-full mt-4 px-4 dark:text-white">
      {{ $providers->links() }}
    </div>
  </div>

  <!-- Create Provider modal ------------------------- -->
  <x-admin.create-modal action="/admin/providers" header="Create new provider">
    <div>
      <x-input-label for="name" :value="__('Name')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-sm" placeholder="Provider A" required />
    </div>

    <div>
      <x-input-label for="description" :value="__('Description')" />
      <x-text-input id="description" name="description" type="text" class="mt-1 block w-full text-sm" placeholder="Provider of product A, product B,..." required />
    </div>

    <div>
      <x-input-label for="phone" :value="__('Phone')" />
      <x-text-input onkeypress="return isNumberKey(event)" id="phone" name="phone" type="text" class="mt-1 block w-full text-sm" placeholder="0000000000" />
    </div>

    <div>
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-sm" placeholder="provider@gmail.com" />
    </div>

    <div>
      <x-input-label for="address" :value="__('Address')" />
      <x-text-input id="address" name="address" type="text" class="mt-1 block w-full text-sm" placeholder="Street A, District B, City C" />
    </div>
  </x-admin.create-modal>

  <!-- Update modal ------------------------------ -->
  <x-admin.update-modal action="/admin/providers" header="Update provider" :hideBtn="false">
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
      <x-text-input id="update-name" name="name" type="text" class="mt-1 block w-full text-sm" 
        placeholder="Provider A" required 
      />
    </div>

    <div>
      <x-input-label for="update-description" :value="__('Description')" />
      <x-text-input id="update-description" name="description" type="text" class="mt-1 block w-full text-sm" placeholder="Provider description" required />
    </div>

    <div>
      <x-input-label for="update-phone" :value="__('Phone')" />
      <x-text-input onkeypress="return isNumberKey(event)" id="update-phone" name="phone" type="text" class="mt-1 block w-full text-sm" placeholder="0000000000" />
    </div>

    <div>
      <x-input-label for="update-email" :value="__('Email')" />
      <x-text-input id="update-email" name="email" type="email" class="mt-1 block w-full text-sm" placeholder="provider@gmail.com" />
    </div>

    <div>
      <x-input-label for="update-address" :value="__('Address')" />
      <x-text-input id="update-address" name="address" type="text" class="mt-1 block w-full text-sm" placeholder="Street A, District B, City C" />
    </div>
  </x-admin.update-modal>

  <!-- Delete modal ------------------------------ -->
  <x-admin.delete-modal />
  <x-admin.delete-all-modal />
</x-app-layout>