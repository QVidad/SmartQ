<template>
    <FacultyLayout>
        <AllExams></AllExams>
    </FacultyLayout>
</template>

<script>
    import axios from 'axios';
    import FacultyLayout from '../Layouts/FacultyLayout.vue';
    import AllExams from '../AllExams.vue';
    export default {
        components: {
            FacultyLayout, AllExams
        },
    };
</script>