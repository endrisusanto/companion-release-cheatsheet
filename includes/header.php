<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Companion Release Cheat Sheet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1 0 auto;
        }
        .footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="index.php" class="text-xl font-bold">Companion Release Cheat Sheet</a>
                <div class="hidden md:flex space-x-4 items-center">
                    <a href="index.php" class="hover:bg-blue-700 px-3 py-2 rounded">Home</a>
                    <a href="today.php" class="hover:bg-blue-700 px-3 py-2 rounded">Today Releases</a>
                    <?php if (isLoggedIn()): ?>
                        <div class="relative">
                            <button class="hover:bg-blue-700 px-3 py-2 rounded flex items-center focus:outline-none" id="user-menu-button">
                                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10" id="user-menu">
                                <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="hover:bg-blue-700 px-3 py-2 rounded">Login</a>
                    <?php endif; ?>
                </div>
                <button class="md:hidden focus:outline-none" id="mobile-menu-button">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="index.php" class="block hover:bg-blue-700 px-3 py-2 rounded">Home</a>
                    <a href="today.php" class="block hover:bg-blue-700 px-3 py-2 rounded">Today Releases</a>
                    <?php if (isLoggedIn()): ?>
                        <a href="profile.php" class="block hover:bg-blue-700 px-3 py-2 rounded">Profile</a>
                        <a href="logout.php" class="block hover:bg-blue-700 px-3 py-2 rounded">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="block hover:bg-blue-700 px-3 py-2 rounded">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content container mx-auto px-4 py-6 flex-grow">
        <?php 
        if (isset($_SESSION['flash_message'])) {
            $type = $_SESSION['flash_type'] ?? 'blue';
            echo '<div class="bg-'.$type.'-100 border border-'.$type.'-400 text-'.$type.'-700 px-4 py-3 rounded mb-4">'
                .htmlspecialchars($_SESSION['flash_message']).
                '<button class="float-right focus:outline-none" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>';
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
        }
        ?>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // User dropdown menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', () => {
                userMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (event) => {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>