<template>
    <div class="d-flex justify-content-center">
        <div class="table-responsive" style="max-width: 80%;">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Details</th>
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="student in students" :key="student.id">
                        <td>{{ student.name }}</td>
                        <td>Details</td>
                        <td>Details</td>
                        <td>Details</td>
                        <td>
                            <div class="btn-group">
                                <!-- Student Report -->
                                <a href="" class="mx-1 btn btn-primary btn-sm"><i class="bi bi-file-text-fill"></i> Student Report </a>

                                <!-- Delete Button -->
                                <!-- <form action="" method="POST" style="display:inline;">
                                    <button type="submit" class="mx-1 btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form> -->
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Students',
        data() {
            return {
                
            };
        },
        methods: {
            
        },
        components: {
            
        },
        mounted() {
            // console.log(this.students);
        },
        props: {
            students: {
                // type: Object,
                required: true 
            }
        },
    }
</script>
