<template>
    <div class="wrapper">
        <!-- Sidebar -->
        <InAppMenu />
        
        <!-- Header -->
        <InAppTop />
        
        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="page-content">
                <router-view></router-view>
            </div>
            
            <!-- Footer -->
            <InAppFooter />
        </div>
        
        <!-- Overlay for mobile sidebar -->
        <div class="overlay nav-toggle-icon"></div>
        
        <!-- Back to Top Button -->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    </div>
</template>

<script>
import InAppMenu from '../components/InAppMenu.vue';
import InAppTop from '../components/InAppTop.vue';
import InAppFooter from '../components/InAppFooter.vue';

export default {
    name: "InAppLayout",
    components: {
        InAppMenu,
        InAppTop,
        InAppFooter
    }
}
</script>

<style>
/* Global styles for InApp Layout */
:root {
    --sidebar-width: 250px;
    --primary-coral: #f36c5d;
}

body {
    background-color: #f8f9fa;
    font-family: 'Inter', sans-serif;
    color: #4b5563;
}

.wrapper {
    width: 100%;
    position: relative;
    overflow-x: hidden;
}

.page-wrapper {
    height: auto;
    margin-left: var(--sidebar-width);
    margin-top: 60px; /* Navbar height */
    position: relative;
    transition: all 0.3s ease;
}

.page-content {
    padding: 1.5rem;
    min-height: calc(100vh - 140px); /* 100vh - navbar(60) - footer(80) approx */
}

/* Card overrides to match InApp style */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    background: #fff;
    margin-bottom: 30px;
}

.card-header {
    background: transparent;
    border-bottom: 1px solid #f3f4f6;
    padding: 1.25rem;
}

.card-body {
    padding: 1.25rem;
}

@media (max-width: 1024px) {
    .page-wrapper {
        margin-left: 0;
    }
}

/* Scrollbar Styling */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
::-webkit-scrollbar-track {
    background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
