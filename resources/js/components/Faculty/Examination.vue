<template>
    <div class="">
        <div class="d-flex justify-content-end">
            <div class="d-flex">
                <a href="/create-exams" class="m-2 p-2 btn btn-primary btn-sm">
                    <i class="bi bi-plus-square"></i> Create Exam
                </a>
            </div>
        </div>
        <div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-2">
                <div v-for="exam in exams" :key="exam.id" class="col my-2">
                    <div class="card shadow-sm h-100">
                        <!-- Image, if needed -->
                        <!-- <img class="card-img-top p-2" :src="imageSrc" :alt="exam.exam_name + ' Image'"> -->
                        <div class="card-body">
                            <h4 class="card-title" style="font-weight: bold">{{ exam.exam_name }}</h4>
                            <h5 class="text-muted">{{ exam.description }}</h5>
                            <h5 class="text-muted">Start Date: {{ formatTimestamp(exam.start_date) }}</h5>
                            <h5 class="text-muted">End Date: {{ formatTimestamp(exam.end_date) }}</h5>
                            <div class="d-flex justify-content-end p-3">
                                <a :href="'/download-report/' + exam.exam_id" class="btn btn-secondary mx-1 px-3">
                                    Download Report
                                    <!-- <i class="bi bi-download"></i> -->
                                </a>
                                <a :href="'/exam-report/' + exam.exam_id" class="btn btn-primary mx-1 px-3">
                                    Report
                                    <!-- <i class="bi bi-file-earmark-text-fill"></i> -->
                                </a>
                                <a :href="'/configure-exam/' + exam.exam_id" class="btn btn-primary mx-1 px-3" style="background-color: #292B4E;">
                                    Configure
                                    <!-- <i class="bi bi-gear"></i> -->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ExamModal from './CreateExam.vue';
    export default {
        name: 'Examination',
        data() {
            return {
                exams: ''
            };
        },
        methods: {
            fetchExams() {
                axios.get('/fetch-exams').then((response) => {
                    this.exams = response.data;
                });
            },
            formatTimestamp(timestamp) {
                const date = new Date(timestamp);
                const dateOptions = {
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric'
                };
                const timeOptions = {
                    hour: 'numeric', 
                    minute: 'numeric', 
                    hour12: true
                };

                return date.toLocaleDateString(undefined, dateOptions) + ', ' + date.toLocaleTimeString(undefined, timeOptions);
            }
        },
        components: {
            ExamModal
        },
        mounted() {
            this.fetchExams();
        }
    }
</script>
