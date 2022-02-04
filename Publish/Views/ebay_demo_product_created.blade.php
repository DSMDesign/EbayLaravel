<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Created Demo Product on ebay</title>
</head>

<body>

    <main class="font-sans bg-white">
        <div>
            <header class="bg-white shadow border-t-4 border-indigo-600">
                <div class="container mx-auto px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <a class="flex items-center text-gray-800 hover:text-indigo-600" href="#">
                                <svg class="h-6 w-6 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>

                                <span class="mx-3 font-medium text-sm md:text-base">Ebay integration</span>
                            </a>
                        </div>
                        <div class="flex items-center -mx-2">
                            <a class="flex items-center mx-2 text-gray-800 hover:text-indigo-600"
                                href="https://developer.ebay.com/my/auth" target="_blank">
                                <svg class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                Manage your apis here
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <section class="bg-white py-20">
                <div class="max-w-5xl px-6 mx-auto text-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Inventory item and product offer created {{
                        $offerId }}</h2>

                    <div class="flex flex-col items-center justify-center mt-6">
                        <a class="max-w-2xl w-full block bg-white shadow-md rounded-md border-t-4 border-indigo-600 transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110"
                            href="#">
                            <div class="flex items-center justify-between px-4 py-2">
                                <h3 class="text-lg font-medium text-gray-700">You have just create a offer number
                                </h3>
                                <span class="block text-gray-600 font-light text-sm">{{ $offerId }}</span>
                            </div>
                        </a>
                    </div>

                    <h3>Now you are able to see this offet in your dashboard</h3>

                    <div class="flex items-center justify-center mt-12">
                        <a class="flex items-center text-gray-600 hover:underline hover:text-gray-500"
                            href="https://developer.ebay.com/products/sell" target="_blank">
                            <span>Documentaiton Information</span>

                            <svg class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </main>

</body>

</html>
