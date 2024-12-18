<template>
    <div style="background-image: url('/assets/background.png'); 
                background-size: cover; 
                background-repeat: no-repeat; 
                background-position: center center; 
                background-attachment: fixed;
                min-height: 100vh;">
    <div id="app">
        <Navbar></Navbar>
        <slot />
    </div>
</div>
</template>

<script>
    import axios from 'axios';
    import Navbar from '../../components/NavBar.vue';
    export default {
        data() {
            
        },
        components: {
            Navbar
        },
    };
</script>