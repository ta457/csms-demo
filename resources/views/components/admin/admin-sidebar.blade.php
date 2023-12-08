<x-sidebar>
  @php $isUserPage = Str::contains(request()->route()->uri, '/users') @endphp
  <x-sidebar-item 
    :active="$isUserPage"
    href="/admin/users"
    label="Users">
    <x-icon.user-icon :active="$isUserPage" />
  </x-sidebar-item>

  @php $isProductPage = Str::contains(request()->route()->uri, '/products') @endphp
  <x-sidebar-item 
    :active="$isProductPage"
    href="/admin/products"
    label="Products">
    <x-icon.product-icon :active="$isProductPage" />
  </x-sidebar-item>
</x-sidebar>