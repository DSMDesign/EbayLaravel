<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Create Demo Product on ebay</title>
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
                    <h2 class="text-2xl font-semibold text-gray-800">Create a test product in the form so you can test
                        your api</h2>
                    <!-- component -->
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <form method="POST" action="{{ route('ebay.demo.product.store') }}">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="text-xl text-gray-600">Title <span
                                                    class="text-red-500">*</span></label></br>
                                            <input type="text" class="border-2 border-gray-300 p-2 w-full" name="title"
                                                id="title" name="title" value="Apple Watch" required>
                                        </div>

                                        <div class="mb-4">
                                            <label class="text-xl text-gray-600">Product Slug<span
                                                    class="text-red-500">*</span></label></br>
                                            <input type="text" class="border-2 border-gray-300 p-2 w-full"
                                                name="product_slug" id="product_slug" value="apple_watch_test" value=""
                                                required>
                                        </div>

                                        <small> Part of aspects</small>
                                        <div class="mb-4">
                                            <label class="text-xl text-gray-600">brands</label></br>
                                            <input type="text" class="border-2 border-gray-300 p-2 w-full" name="brands"
                                                id="brands" value="apple" placeholder="(multiple separe by coma)">
                                        </div>

                                        <div class="mb-4">
                                            <label class="text-xl text-gray-600">colors</label></br>
                                            <input type="text" class="border-2 border-gray-300 p-2 w-full" name="colors"
                                                id="colors" value="black,red,blue"
                                                placeholder="(multiple separe by coma)">
                                        </div>
                                        <small> Part of aspects end</small>

                                        <div class="mb-8">
                                            <label class="text-xl text-gray-600">Product Description <span
                                                    class="text-red-500">*</span></label></br>
                                            <textarea name="product_description" class="border-2 border-gray-500">
                                                Test listing - do not bid or buy \n Built-in GPS. Water resistance to 50 meters.1 A new lightning-fast dual-core processor. And a display that\u2019s two times brighter than before. Full of features that help you stay active, motivated, and connected, Apple Watch Series 2 is designed for all the ways you move
                                            </textarea>
                                        </div>

                                        <div class="mb-8">
                                            <label class="text-xl text-gray-600">Upc <span
                                                    class="text-red-500">*</span></label></br>
                                            <input type="text" class="border-2 border-gray-300 p-2 w-full" name="upc"
                                                id="upc" placeholder="(multiple separe by coma)" value="888462079525"
                                                required>
                                        </div>

                                        <div class="mb-8">
                                            <label class="text-xl text-gray-600">Condition <span
                                                    class="text-red-500">*</span></label></br>
                                            <input type="text" class="border-2 border-gray-300 p-2 w-full"
                                                name="condition" id="condition" placeholder="(multiple separe by coma)"
                                                value="NEW" required>
                                        </div>

                                        <div class="mb-8">
                                            <label class="text-xl text-gray-600">Qty<span
                                                    class="text-red-500">*</span></label></br>
                                            <input type="text" class="border-2 border-gray-300 p-2 w-full" name="qty"
                                                id="qty" value="10" required>
                                        </div>
                                        <small> The Rest of the information will be pre fill please check the
                                            documentation to check the extra fields</small>

                                        <div class="flex p-1">
                                            <button role="submit" class="p-3 bg-blue-500 text-white hover:bg-blue-400"
                                                required>Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

                    <script>
                        CKEDITOR.replace( 'product_description' );
                    </script>
                </div>
            </section>
        </div>
    </main>

</body>

</html>
