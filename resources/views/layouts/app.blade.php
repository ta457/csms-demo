<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body @if (Str::contains(request()->route()->uri,'profile'))
    class="font-sans antialiased flex"
    @else
    class="font-sans antialiased flex overflow-auto lg:overflow-hidden"
    @endif
    >

    @if (isset($sidebar)) {{ $sidebar }} @endif

    <div class="w-full min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class=" mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
                {{ $header }}
            </div>
        </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>
</body>

<script>
    // handle delete modal ==============================================================
    function changeDeleteFormAction(url, id) {
        var form = document.getElementById('deleteRecordForm');
        var deleteMessage = document.getElementById('deleteMessage'); 
        form.action = url + id;
        deleteMessage.textContent ='ID = ' + id;
    }

    // handle delete all btn ===========================================================
    function showDeleteAllBtn() {
        document.getElementById('fakeDeleteAllBtn').classList.remove('hidden');
    }
    
    function clickDeleteAllBtn() {
        realBtn = document.getElementById('realDeleteAllBtn');
        realBtn.click();
    }


    // Handle api calls & display info in Update modal ========================================
    // Function to update modal content with user data
    function updateUserModal(url, userData) {
        let form = document.getElementById('update-form');
        form.action = url;
        document.getElementById('update-created').value = userData.created_at;
        document.getElementById('update-updated').value = userData.updated_at;
        document.getElementById('update-name').value = userData.name;
        // document.getElementById('update-username').value = userData.username;
        document.getElementById('update-email').value = userData.email;
        //document.getElementById('update-password').value = userData.password;
        let roleSelect = document.getElementById('update-role');
        for (let i = 0; i < roleSelect.options.length; i++) {
            if (roleSelect.options[i].value == userData.role) {
                roleSelect.options[i].selected = true;
            } else {
                roleSelect.options[i].selected = false;
            }
        }
    }

    function updateCategoryModal(url, categoryData) {
        let form = document.getElementById('update-form');
        form.action = url;
        document.getElementById('update-created').value = categoryData.created_at;
        document.getElementById('update-updated').value = categoryData.updated_at;
        document.getElementById('update-name').value = categoryData.name;
        document.getElementById('update-description').value = categoryData.description;
    }

    function updateProviderModal(url, providerData) {
        let form = document.getElementById('update-form');
        form.action = url;
        document.getElementById('update-created').value = providerData.created_at;
        document.getElementById('update-updated').value = providerData.updated_at;
        document.getElementById('update-name').value = providerData.name;
        document.getElementById('update-description').value = providerData.description;
        document.getElementById('update-phone').value = providerData.phone;
        document.getElementById('update-email').value = providerData.email;
        document.getElementById('update-address').value = providerData.address;
    }

    function updateProductModal(url, productData) {
        let form = document.getElementById('update-form');
        form.action = url;

        document.getElementById('update-created').value = productData.created_at;
        document.getElementById('update-updated').value = productData.updated_at;
        document.getElementById('update-name').value = productData.name;
        document.getElementById('update-description').value = productData.description;
        document.getElementById('update-price').value = productData.price;
        document.getElementById('update-quantity').value = productData.quantity;
        let categorySelect = document.getElementById('update-category');
        for (let i = 0; i < categorySelect.options.length; i++) {
            if (categorySelect.options[i].value == productData.category_id) {
                categorySelect.options[i].selected = true;
            } else {
                categorySelect.options[i].selected = false;
            }
        }
        let providerSelect = document.getElementById('update-provider');
        for (let i = 0; i < providerSelect.options.length; i++) {
            if (providerSelect.options[i].value == productData.provider_id) {
                providerSelect.options[i].selected = true;
            } else {
                providerSelect.options[i].selected = false;
            }
        }

        let imgContainer = document.getElementById('update-images');
        while (imgContainer.firstChild) {
            imgContainer.removeChild(imgContainer.firstChild);
        }
        productData.images.forEach(function (image) {
            let wrapper = document.createElement('div');
            wrapper.classList.add('relative');

            let imgElement = document.createElement('img');
            imgElement.classList.add('w-24', 'h-24', 'rounded-md');
            imgElement.style.objectFit = 'cover';
            imgElement.src = '/storage/' + image.file;
            imgElement.alt = 'product-img';

            let deleteButton = document.createElement('button');
            deleteButton.setAttribute('type', 'button');
            deleteButton.classList.add('mr-1','mb-1','font-bold','text-sm','w-6','h-6','absolute','bottom-0','right-0','rounded-full','bg-rose-600','hover:bg-rose-400','text-white','shadow-md');
            deleteButton.textContent = '-';
            deleteButton.setAttribute('onclick', `deleteImage(${image.id},'/api/v1/product/${productData.id}','/admin/products/${productData.id}','product')`);

            wrapper.appendChild(imgElement);
            wrapper.appendChild(deleteButton);
            imgContainer.appendChild(wrapper);
        });
    }

    function deleteImage(imageId,apiUrl, url, key) {
        fetch(`/api/v1/product-img/delete/${imageId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            console.log('Image deleted successfully');
        })
        .catch(error => {
            console.error('Error deleting image:', error);
        });
        updateFormData(apiUrl, url, key);
    }

    function updateFormData(apiUrl, url, key) {

        // Make fetch request to get user data
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(function (data) {
            // Update modal content with user data
            if(key === 'user') {
                updateUserModal(url, data);
            }
            if(key === 'category') {
                updateCategoryModal(url, data);
            }
            if(key === 'product') {
                updateProductModal(url, data);
            }
            if(key === 'provider') {
                updateProviderModal(url, data);
            }
        })
        .catch(function (error) {
            console.error('Error fetching user data:', error);
        });
    }

    function isNumberKey(evt) {
        // Get the event key code
        var charCode = (evt.which) ? evt.which : event.keyCode;

        // Allow only numeric input (0-9) and special keys like Backspace, Delete, Tab
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 8 && charCode !== 46 && charCode !== 9) {
        return false;
        }

        return true;
    }
</script>

</html>