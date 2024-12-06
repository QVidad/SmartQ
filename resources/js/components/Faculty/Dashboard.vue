<template>
    <div class="">
        <TopStudents/>
        <BellCurve/>
    </div>
</template>

<script>
    import BellCurve from './BellCurve.vue';
    import TopStudents from './TopStudents.vue';
    export default {
        name: 'Dashboard',
        data() {
            return {
                
            };
        },
        methods: {
            
        },
        components: {
            BellCurve, TopStudents
        },
        mounted() {
            
        }
    }
</script>
