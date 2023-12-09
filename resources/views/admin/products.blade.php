@props([
'products' => $props['products'],
'categories' => $props['categories']
])

<x-app-layout>
  <x-slot name="sidebar">
    <x-admin.admin-sidebar />
  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Products management') }}
    </h2>
    <div class="font-semibold text-xl">
      <x-header-message />
    </div>
  </x-slot>

  <div class="py-12 sm:px-6 lg:px-8">
    
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
      <x-admin.table-header action="/admin/products">
        <select name="filter_category"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full px-2 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
          <option @if (request('filter_category') == 0) @selected(true) @endif  value="0">All</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}" 
              @if (request('filter_category') == 2) @selected(true) @endif>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </x-admin.table-header>

      <x-admin.table-body
        action='/admin/products/destroy-all' 
        :heads="['ID','Name','Description','Price','Category']">

        @foreach ($products as $product)
          <tr class="border-b dark:border-gray-700">
            <td class="px-4 py-3">
              <input class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" 
                type="checkbox" name="selected[]" value="{{ $product->id }}" onclick="showDeleteAllBtn()">
            </td>
            <td class="px-4 py-3">
              {{ $product->id }}
            </td>
            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $product->name }}
            </th>
            <td class="px-4 py-3">
              {{ $product->description }}
            </td>
            <td class="px-4 py-3">
              {{ $product->price }}
            </td>
            <td class="px-4 py-3">
              {{ $product->category_name }}
            </td>
            <x-admin.table-dropdown 
              action='/admin/products' :id="$product->id" 
              onclick="updateFormData('/api/v1/product/{{ $product->id }}','/admin/products/{{ $product->id }}', 'product')"
            /> 
          </tr>
        @endforeach
      </x-admin.table-body>
    </div>
    <div id="admin-paginate" class="w-full mt-4 px-4 dark:text-white">
      {{ $products->links() }}
    </div>
  </div>

  <!-- Create product modal ------------------------- -->
  <x-admin.create-modal action="/admin/products" header="Create new product" hideBtn="true">
    <div>
      <x-input-label for="name" :value="__('Name')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-sm" placeholder="Product name" required />
    </div>

    <div>
      <x-input-label for="description" :value="__('Description')" />
      <x-text-input id="description" name="description" type="text" class="mt-1 block w-full text-sm" placeholder="Product description" required />
    </div>

    <div>
      <x-input-label for="price" :value="__('Price')" />
      <x-text-input id="price" name="price" type="text" class="mt-1 block w-full text-sm" placeholder="100000" required />
    </div>

    <div>
      <x-input-label for="category" :value="__('Category')" />
      <select id="category" name="category_id"
        class="mt-1 bg-gray-50 border border-gray-300 text-gray-500 dark:text-gray-500 text-sm rounded-md focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500">
        <option selected="">Select category</option>
        @foreach ($categories as $category)
          <option class="text-gray-900 dark:text-white" 
            value="{{ $category->id }}">
            {{ $category->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-span-2">
      <x-admin.update-file-form />
    </div>
  </x-admin.create-modal>

  <!-- Update modal ------------------------------ -->
  <x-admin.update-modal action="/admin/products" header="Update product" :hideBtn="true">
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
      <x-text-input id="update-name" name="name" type="text" class="mt-1 block w-full text-sm" placeholder="Product name" required />
    </div>

    <div>
      <x-input-label for="update-description" :value="__('Description')" />
      <x-text-input id="update-description" name="description" type="text" class="mt-1 block w-full text-sm" placeholder="Product description" required />
    </div>

    <div>
      <x-input-label for="update-price" :value="__('Price')" />
      <x-text-input id="update-price" name="price" type="text" class="mt-1 block w-full text-sm" placeholder="100000" required />
    </div>

    <div>
      <x-input-label for="update-category" :value="__('Category')" />
      <select id="update-category" name="category_id"
        class="mt-1 bg-gray-50 border border-gray-300 text-gray-500 dark:text-gray-500 text-sm rounded-md focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500">
        @foreach ($categories as $category)
          <option class="text-gray-900 dark:text-white" 
            value="{{ $category->id }}">
            {{ $category->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-span-2">
      <x-input-label :value="__('Product images')" />
      
      <div id="update-images" class="w-full mt-1 flex gap-2 flex-wrap">
        {{-- <img class="w-24 h-24 rounded-md" style="object-fit: cover;"
          src="/storage/product-images/eZthw06nrhdYAEX40yvEBqoxh38ijbWHS1wM0Mjb.jpg" alt="product-img"
        > --}}
      </div>
    </div>
    
    <div class="col-span-2">
      <x-admin.update-file-form />
    </div>
  </x-admin.update-modal>

  <!-- Delete modal ------------------------------ -->
  <x-admin.delete-modal />
  <x-admin.delete-all-modal />
</x-app-layout>

<script>
  let deleteBtns = document.querySelectorAll('[id^="/submission/"]');
  console.log(deleteBtns);
  deleteBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const dynamicNumber = btn.id.split("/")[2];
      console.log(dynamicNumber);
      document.getElementById('deleteButton').click();
      const form = document.getElementById('delete-file');
      form.action = `/submission/${dynamicNumber}`;
    })
  });

  const fileTempl = document.getElementById("file-template"),
  imageTempl = document.getElementById("image-template"),
  empty = document.getElementById("empty");

  // use to store pre selected files
  let FILES = {};

  // check if file is of type image and prepend the initialied
  // template to the target element
  function addFile(target, file) {
    const isImage = file.type.match("image.*"),
    objectURL = URL.createObjectURL(file);

    const clone = isImage
    ? imageTempl.content.cloneNode(true)
    : fileTempl.content.cloneNode(true);

    clone.querySelector("h1").textContent = file.name;
    clone.querySelector("li").id = objectURL;
    clone.querySelector(".delete").dataset.target = objectURL;
    clone.querySelector(".size").textContent =
    file.size > 1024
      ? file.size > 1048576
        ? Math.round(file.size / 1048576) + "mb"
        : Math.round(file.size / 1024) + "kb"
      : file.size + "b";

    isImage &&
    Object.assign(clone.querySelector("img"), {
      src: objectURL,
      alt: file.name
    });

    empty.classList.add("hidden");
    target.prepend(clone);

    FILES[objectURL] = file;
  }

  const gallery = document.getElementById("gallery"),
  overlay = document.getElementById("overlay");

  // click the hidden input of type file if the visible button is clicked
  // and capture the selected files
  const hidden = document.getElementById("hidden-input");
  document.getElementById("button").onclick = () => hidden.click();
  hidden.onchange = (e) => {
    for (const file of e.target.files) {
      addFile(gallery, file);
    }
  };

  // use to check if a file is being dragged
  const hasFiles = ({ dataTransfer: { types = [] } }) =>
  types.indexOf("Files") > -1;

  // use to drag dragenter and dragleave events.
  // this is to know if the outermost parent is dragged over
  // without issues due to drag events on its children
  let counter = 0;

  // reset counter and append file to gallery when file is dropped
  function dropHandler(ev) {
    ev.preventDefault();
    for (const file of ev.dataTransfer.files) {
    addFile(gallery, file);
    overlay.classList.remove("draggedover");
    counter = 0;
    }
  }

  // only react to actual files being dragged
  function dragEnterHandler(e) {
    e.preventDefault();
    if (!hasFiles(e)) {
      return;
    }
    ++counter && overlay.classList.add("draggedover");
  }

  function dragLeaveHandler(e) {
    1 > --counter && overlay.classList.remove("draggedover");
  }

  function dragOverHandler(e) {
    if (hasFiles(e)) {
      e.preventDefault();
    }
  }

  // event delegation to caputre delete events
  // fron the waste buckets in the file preview cards
  gallery.onclick = ({ target }) => {
    if (target.classList.contains("delete")) {
      const ou = target.dataset.target;
      document.getElementById(ou).remove(ou);
      gallery.children.length === 1 && empty.classList.remove("hidden");
      delete FILES[ou];
    }
  };

  // print all selected files
  // document.getElementById("submit").onclick = () => {
  //   alert(`Submitted Files:\n${JSON.stringify(FILES)}`);
  //   console.log(FILES);
  // };

  // clear entire selection
  document.getElementById("cancel").onclick = () => {
    while (gallery.children.length > 0) {
    gallery.lastChild.remove();
  }
  FILES = {};
    empty.classList.remove("hidden");
    gallery.append(empty);
  };

  // ===============================================================================

</script>

<style>
  .hasImage:hover section {
    background-color: rgba(5, 5, 5, 0.4);
  }

  .hasImage:hover button:hover {
    background: rgba(5, 5, 5, 0.45);
  }

  #overlay p,
  i {
    opacity: 0;
  }

  #overlay.draggedover {
    background-color: rgba(255, 255, 255, 0.7);
  }

  #overlay.draggedover p,
  #overlay.draggedover i {
    opacity: 1;
  }

  .group:hover .group-hover\:text-blue-800 {
    color: #2b6cb0;
  }
</style>