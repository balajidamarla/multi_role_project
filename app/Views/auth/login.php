<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
</head>

<body>

<div class="w-1/3 mx-auto h-[100vh] flex items-center justify-center p-10">
    <div class="w-full">

        <!-- Display errors or success messages -->
        

        <!-- Login Form -->
        <form action="<?= base_url('auth/dologin') ?>" method="post" class="flex flex-col items-center text-sm text-slate-800">
            <?= csrf_field() ?>
            <p class="text-2xl bg-black text-white font-medium px-5 py-2 rounded-full">Login</p>
            <?php if ($errors = session()->get('error')): ?>
            <div class="text-red-500 text-base text-center mb-5">
                <?php if (is_array($errors)): ?>
                    <ul class="mb-2 pl-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <?= esc($errors) ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

            <div class="max-w-96 w-full px-4">

                <!-- Email Address Input -->
                <label for="email" class="font-medium mt-4">Email Address</label>
                <div class="flex items-center mt-2 mb-4 h-10 pl-3 border border-slate-300 rounded-full focus-within:ring-2 focus-within:ring-indigo-400 transition-all overflow-hidden">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.5 3.438h-15a.937.937 0 0 0-.937.937V15a1.563 1.563 0 0 0 1.562 1.563h13.75A1.563 1.563 0 0 0 18.438 15V4.375a.94.94 0 0 0-.938-.937m-2.41 1.874L10 9.979 4.91 5.313zM3.438 14.688v-8.18l5.928 5.434a.937.937 0 0 0 1.268 0l5.929-5.435v8.182z" fill="#475569" />
                    </svg>
                    <input type="email" name="email" id="email" class="h-full px-2 w-full outline-none bg-transparent" placeholder="Enter your email address" required>
                </div>

                <!-- Password Input -->
                <label for="password" class="font-medium">Password</label>
                <div class="flex items-center mt-2 mb-4 h-10 pl-3 border border-slate-300 rounded-full focus-within:ring-2 focus-within:ring-indigo-400 transition-all overflow-hidden">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.311 16.406a9.64 9.64 0 0 0-4.748-4.158 5.938 5.938 0 1 0-7.125 0 9.64 9.64 0 0 0-4.749 4.158.937.937 0 1 0 1.623.938c1.416-2.447 3.916-3.906 6.688-3.906 2.773 0 5.273 1.46 6.689 3.906a.938.938 0 0 0 1.622-.938M5.938 7.5a4.063 4.063 0 1 1 8.125 0 4.063 4.063 0 0 1-8.125 0" fill="#475569" />
                    </svg>
                    <input type="password" name="password" id="password" class="h-full px-2 w-full outline-none bg-transparent" placeholder="Password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="flex items-center justify-center gap-1 mt-5 bg-black text-white py-2.5 w-full rounded-full transition hover:bg-gray-900">
                    Submit
                    <svg class="mt-0.5" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m18.038 10.663-5.625 5.625a.94.94 0 0 1-1.328-1.328l4.024-4.023H3.625a.938.938 0 0 1 0-1.875h11.484l-4.022-4.025a.94.94 0 0 1 1.328-1.328l5.625 5.625a.935.935 0 0 1-.002 1.33" fill="#fff" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>