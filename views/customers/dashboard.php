<html class="h-full bg-gray-100" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwindcss CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AlpineJS CDN -->
  <script defer="" src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Inter Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
 
  <link rel="stylesheet" href="/style.css">

  <title>Dashboard</title>
  
</head>

<body class="h-full">
  <div class="min-h-full">
    <!-- Navbar includes -->
    <?php require_once __DIR__ . '/../includes/customer_nav.php' ?>
    <main class="-mt-32">
      <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg p-2">
          <!-- Current Balance Stat -->
          <dl class="mx-auto grid grid-cols-1 gap-px sm:grid-cols-2 lg:grid-cols-4">
            <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-10 sm:px-6 xl:px-8">
              <dt class="text-sm font-medium leading-6 text-gray-500">
                Current Balance
              </dt>
              <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
                $<?=number_format($user['balance'],2)?>
              </dd>
            </div>
          </dl>

          <!-- List of All The Transactions -->
          <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
              <div class="sm:flex-auto">
                <p class="mt-2 text-sm text-gray-700">
                  Here's a list of all your transactions which inlcuded
                  receiver's name, email, amount and date.
                </p>
              </div>
            </div>
            <div class="mt-8 flow-root">
              <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                      <tr>
                      <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                          Trxid
                        </th>
                        <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                          Type
                        </th>
                        <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                          Sender/Receiver
                        </th>
                        <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                          Email
                        </th>
                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                          Amount
                        </th>
                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                          Balance
                        </th>
                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                          Date
                        </th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      <?php foreach ($transactions as $key=>$value):?>
                      <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-800 sm:pl-0">
                          <?=strtoupper( $value['trxid'])?>
                        </td>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                          <?=$value['type']==1?'DEPOSIT':($value['type']==2?'WITHDRAW':'TRANSFER')?>
                        </td>
                        <td class="whitespace-nowrap px-2 py-4 text-sm font-medium text-emerald-600">
                          <?php if($value['type']==1|| $value['type']== 2):?>
                            Self
                          <?php else:?>
                            <?=$value['receiverName']?>
                          <?php endif?>  
                        </td>
                        <td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">
                        <?php if($value['type']==1|| $value['type']== 2):?>
                            Self
                          <?php else:?>
                            <?=$value['receiverEmail']?>
                          <?php endif?>  
                        </td>
                        <td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">
                        <?php if($value['type']==2|| $value['type']== 3):?>

                            <?=$value['type']==2?'-':($value['balance_added']==0?'-':'+')?>$<?=number_format($value['amount'],2)?>
                          <?php else:?>
                            +$<?=number_format($value['amount'],2)?>
                          <?php endif?>  
                        </td>
                        <td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">
                        $<?=number_format($value['userBalance'],2)?>
                        </td>
                        <td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">
                          <?=date('j M Y',strtotime($value['created_at']))?>
                        </td>
                      </tr>
                    <?php endforeach?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>


</body>

</html>