<template>
    <div id="app">
        <!-- Clean and minimalistic header -->
        <header class="bg-light text-dark py-3 shadow-sm">
            <div
                class="container d-flex justify-content-between align-items-center"
            >
                <h1 class="m-0">Page Management</h1>
                <nav>
                    <a href="/" class="text-dark text-decoration-none me-3"
                        >Home</a
                    >
                    <a href="#" class="text-dark text-decoration-none"
                        >Logout</a
                    >
                </nav>
            </div>
        </header>

        <!-- Routed components -->
        <router-view />

        <!-- Footer -->
        <footer class="bg-light py-2">
            <div class="container text-center">
                <p class="m-0 text-muted">© 2025 Your Company</p>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    name: "App",
};
</script>

<style scoped>
#app {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
}

header {
    background-color: #f8f9fa; /* Light background for a clean look */
}

h1 {
    font-size: 1.75rem;
    font-weight: 600;
}

nav a {
    font-size: 1rem;
    color: #333;
}

nav a:hover {
    color: #007bff; /* Bootstrap primary color for hover */
}

footer {
    background-color: #f8f9fa;
}

footer p {
    color: #6c757d; /* Light gray text for footer */
}
</style>
