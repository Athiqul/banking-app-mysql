<!DOCTYPE html>
<html
  class="h-full bg-gray-100"
  lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0" />

    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS CDN -->
    <script
      defer
      src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Inter Font -->
    <link
      rel="preconnect"
      href="https://fonts.googleapis.com" />
    <link
      rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
      rel="stylesheet" />
    <style>
      * {
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
          'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
          'Helvetica Neue', sans-serif;
      }
    </style>

    <title>All Customers</title>
  </head>
  <body class="h-full">
    <div class="min-h-full">
      <!-- Navbar -->
       <?php require_once __DIR__ . '/../includes/admin_nav.php'?>

      <main class="-mt-32">
        <div class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="py-8 bg-white rounded-lg">
            <!-- List of All The Customers -->
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                  <p class="mt-2 text-sm text-gray-600">
                    A list of all the customers including their name, email and
                    profile picture.
                  </p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                  <a
                    href="<?=App_Url?>admin-customer-add"
                    type="button"
                    class="block px-3 py-2 text-sm font-semibold text-center text-white rounded-md shadow-sm bg-sky-600 hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                    Add Customer
                  </a>
                </div>
              </div>

              <!-- Users List -->
              <div class="flow-root mt-8">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <ul
                    role="list"
                    class="divide-y divide-gray-100">
                    <?php foreach ($customers as $customer):?>
                      <li
                      class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                      <div class="flex gap-x-4">
                       
                        <span
                          class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-sky-500">
                          <span
                            class="text-xl font-medium leading-none text-white"
                            ><?php 
                           echo nameShort($customer['name']);

                            ?></span
                          >
                        </span>

                        <div class="flex-auto min-w-0">
                          <p
                            class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="<?=App_Url?>admin-customer-transaction/<?=$customer['id']?>">
                              <span
                                class="absolute inset-x-0 bottom-0 -top-px"></span>
                             <?=$customer['name']?>
                            </a>
                          </p>
                          <p class="flex mt-1 text-xs leading-5 text-gray-500">
                            <a
                              href="<?=App_Url?>admin-customer-transaction/<?=$customer['id']?>"
                              class="relative truncate hover:underline"
                              ><?=$customer['email']?></a
                            >
                          </p>
                        </div>
                      </div>
                    </li>
                    <?php endforeach?>
                    

                  
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
