<x-sidebar>
  @php $isUserPage = Str::contains(request()->route()->uri, '/users') @endphp
  <x-sidebar-item 
    :active="$isUserPage"
    href="/admin/users"
    label="Users">
    <x-icon.user-icon :active="$isUserPage" />
  </x-sidebar-item>

  @php $isCategoryPage = Str::contains(request()->route()->uri, '/categories') @endphp
  <x-sidebar-item 
    :active="$isCategoryPage"
    href="/admin/categories"
    label="Categories">
    <x-icon.category-icon :active="$isCategoryPage" />
  </x-sidebar-item>

  @php $isProductPage = Str::contains(request()->route()->uri, '/products') @endphp
  <x-sidebar-item 
    :active="$isProductPage"
    href="/admin/products"
    label="Products">
    <x-icon.product-icon :active="$isProductPage" />
  </x-sidebar-item>

  @php $isProviderPage = Str::contains(request()->route()->uri, '/providers') @endphp
  <x-sidebar-item 
    :active="$isProviderPage"
    href="/admin/providers"
    label="Providers">
    <x-icon.provider-icon :active="$isProviderPage" />
  </x-sidebar-item>
</x-sidebar>