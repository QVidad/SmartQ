<template>
    <div class="">
        <TopStudents :data="data"/>
        <!-- <BellCurve :data="data"/> -->
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
        props: {
            data: {
                required: true
            }
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
