<li>
  <a href="{{ $href }}"
    class="flex items-center py-2.5 px-4 text-sm rounded-lg group
      {{ $active ? 'text-white font-semibold bg-gray-700' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}"
    >
    {{ $slot }}
    <span class="ml-3 {{ $active ? 'font-semibold' : '' }}">{{ $label }}</span>
  </a>
</li>