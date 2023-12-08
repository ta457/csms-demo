<form action="{{ $action }}" method="POST">
  @csrf
  <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr>
        <th scope="col" class="px-4 py-3"></th>
        @foreach ($heads as $head)
          <th scope="col" class="px-4 py-4">{{ $head }}</th>
        @endforeach
        <th scope="col" class="px-4 py-3">
          <span class="sr-only">Actions</span>
        </th>
      </tr>
    </thead>
    <tbody>
      {{ $slot }}
    </tbody>
  </table>
  <button id="realDeleteAllBtn" type="submit" class="hidden"></button>
</form>