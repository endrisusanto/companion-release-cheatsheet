    </main>

    <footer class="footer bg-gray-100 border-t border-gray-200 py-4">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-600 mb-2 md:mb-0">
                    &copy; <?php echo date('Y'); ?> Companion Release Cheat Sheet
                </div>
                <div class="text-gray-600">
                    v1.0.0
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>