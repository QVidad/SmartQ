<template>
    <div>
        <!-- Error and Success Alerts -->
        <div v-if="errors" class="alert alert-danger" role="alert">
            An Error Occurred
        </div>
        <div v-if="success" class="alert alert-success" role="alert">
            {{ success }}
        </div>

        <!-- Exam Type Selector -->
        <!-- <div class="form-group">
            <label for="examType">Exam Type</label>
            <select v-model="examData.examType" class="form-control" required>
                <option disabled value="">Select Exam Type</option>
                <option value="1">Major Exam</option>
                <option value="2">Mock Exam</option>
            </select>
        </div> -->

        <!-- <form v-if="examData.examType === '2'" @submit.prevent="submitForm">
            <div class="form-group">
                <label for="examName">Exam Name</label>
                <input v-model="examData.name" type="text" class="form-control" placeholder="Enter exam name" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea v-model="examData.description" class="form-control" placeholder="Enter description" required></textarea>
            </div>

            <div class="form-group row justify-content-center mx-auto">
                <div class="col-md-3 mb-3">
                    <label for="duration">Duration</label>
                    <input v-model="examData.duration" type="number" class="form-control" placeholder="Enter duration" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="item_num">Number of Items</label>
                    <input v-model="examData.item_num" type="number" class="form-control" placeholder="Enter number of items" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="startDate">Start Date</label>
                    <input v-model="examData.startDate" type="date" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="endDate">End Date</label>
                    <input v-model="examData.endDate" type="date" class="form-control" required>
                </div>
            </div>

            <div class="form-group row justify-content-center mx-auto">
                <div class="col-md-3 mb-3">
                    <div class="dropdown custom-dropdown">
                        <button 
                            class="btn btn-primary dropdown-toggle w-100 text-start" 
                            type="button" 
                            id="dropdownMenuButton" 
                            @click="toggleDropdown"
                        >
                        {{ examData.selectedStudents.length > 0 
                            ? `${examData.selectedStudents.length} Student(s) Selected` 
                            : 'Select Students' }}
                        </button>

                        <div class="dropdown-menu shadow" v-if="dropdownOpen" ref="dropdownMenu">
                            <div v-for="student in students" :key="student.id" class="dropdown-item">
                                <input 
                                    type="checkbox" 
                                    :id="'student-' + student.id" 
                                    :value="student.id" 
                                    v-model="examData.selectedStudents"
                                />
                                <label :for="'student-' + student.id" class="ms-2">{{ student.name }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="/exams" class="btn btn-secondary">Close</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form> -->

        <form v-else-if="examData.examType === '1'" @submit.prevent="submitForm">
            <div class="form-group">
                <label for="majorExamName">Exam Name</label>
                <input v-model="examData.name" type="text" class="form-control" placeholder="Enter major exam name" required>
            </div>
            
            <div class="form-group">
                <label for="majorDescription">Description</label>
                <textarea v-model="examData.description" class="form-control" placeholder="Enter description" required></textarea>
            </div>

            <div class="form-group row justify-content-center mx-auto">
                <div class="col-md-3 mb-3">
                    <label for="majorDuration">Duration</label>
                    <input v-model="examData.duration" type="number" class="form-control" placeholder="Enter duration in minutes" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="startDate">Start Date</label>
                    <input v-model="examData.startDate" type="date" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="endDate">End Date</label>
                    <input v-model="examData.endDate" type="date" class="form-control" required>
                </div>
            </div>

            <div class="form-group row justify-content-center mx-auto">
                    <div class="col-md-3 mb-3">
                        <div class="dropdown custom-dropdown">
                            <button 
                                class="btn btn-primary dropdown-toggle w-100 text-start" 
                                type="button" 
                                id="dropdownMenuButton" 
                                @click="toggleDropdown"
                            >
                            {{ examData.selectedStudents.length > 0 
                                ? `${examData.selectedStudents.length} Student(s) Selected` 
                                : 'Select Students' }}
                            </button>

                            <div class="dropdown-menu shadow" v-if="dropdownOpen" ref="dropdownMenu">
                                <input 
                                    type="text" 
                                    class="form-control mb-2" 
                                    placeholder="Search students..." 
                                    v-model="searchQuery" 
                                    @input="filterStudents"
                                />
                                
                                <div v-for="student in filteredStudents" :key="student.id" class="dropdown-item">
                                    <input 
                                        type="checkbox" 
                                        :id="'student-' + student.id" 
                                        :value="student.id" 
                                        v-model="examData.selectedStudents"
                                    />
                                    <label :for="'student-' + student.id" class="ms-2">{{ student.name }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Questions Section -->
            <div class="questions-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Questions</h4>
                    <button @click.prevent="addQuestion" class="btn btn-primary btn-sm">Add Question</button>
                </div>

                <div v-for="(question, index) in examData.questions" :key="index" class="question-form">
                    <h5>Question {{ index + 1 }}</h5>
                    
                    <div class="form-row">
                        <!-- Question Text -->
                        <div class="form-group col-lg-12">
                            <label>Question</label>
                            <input v-model="question.question" type="text" class="form-control" placeholder="Enter question" required>
                        </div>

                        <div class="col-lg-1"></div>
                        <!-- Option 1 -->
                        <div class="form-group col-12 col-md-6 col-lg-2">
                            <label>Option 1</label>
                            <input v-model="question.option1" type="text" class="form-control" placeholder="Enter option 1" required>
                        </div>

                        <!-- Option 2 -->
                        <div class="form-group col-12 col-md-6 col-lg-2">
                            <label>Option 2</label>
                            <input v-model="question.option2" type="text" class="form-control" placeholder="Enter option 2" required>
                        </div>

                        <!-- Option 3 -->
                        <div class="form-group col-12 col-md-6 col-lg-2">
                            <label>Option 3</label>
                            <input v-model="question.option3" type="text" class="form-control" placeholder="Enter option 3" required>
                        </div>

                        <!-- Option 4 -->
                        <div class="form-group col-12 col-md-6 col-lg-2">
                            <label>Option 4</label>
                            <input v-model="question.option4" type="text" class="form-control" placeholder="Enter option 4" required>
                        </div>

                        <!-- Correct Answer -->
                        <div class="form-group col-12 col-md-6 col-lg-2">
                            <label>Correct Answer</label>
                            <select v-model="question.correctAnswer" class="form-control" required>
                                <option disabled value="">Select the correct answer</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                            </select>
                        </div>

                        <div class="col-lg-1"></div>

                        <!-- Reference -->
                        <div class="form-group col-md-6 col-lg-6">
                            <label>Reference</label>
                            <input v-model="question.reference" type="text" class="form-control" placeholder="Enter reference">
                        </div>

                        <!-- Topic Dropdown -->
                        <div class="form-group col-md-6 col-lg-3">
                            <label>Topic</label>
                            <select v-model="question.topic_id" class="form-control" @change="updateSubtopics(question)" required>
                                <option disabled value="">Select a topic</option>
                                <option v-for="topic in topics" :key="topic.topic_id" :value="topic.topic_id">
                                    {{ topic.topic_name }}
                                </option>
                            </select>
                        </div>

                        <!-- Subtopic Dropdown -->
                        <div class="form-group col-md-6 col-lg-3">
                            <label>Sub-Topic</label>
                            <select v-model="question.subtopic_id" class="form-control" required>
                                <option disabled value="">Select a subtopic</option>
                                <option v-for="subtopic in filteredSubtopics(question.topic_id)" :key="subtopic.subtopic_id" :value="subtopic.subtopic_id">
                                    {{ subtopic.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Remove Question Button -->
                    <div class="text-right">
                        <button @click.prevent="removeQuestion(index)" class="btn btn-danger btn-sm">Remove Question</button>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="modal-footer">
                <a href="/exams" class="btn btn-secondary">Close</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            examData: {
                name: '',
                description: '',
                startDate: '',
                endDate: '',
                duration: '',
                item_num: '',
                examType: '1', 
                questions: [],
                selectedStudents: []
            },
            errors: '',
            success: '',
            dropdownOpen: false,
            searchQuery: '',
            filteredStudents: []
        };
    },
    methods: {
        submitForm() {
            axios.post('/add-exams', this.examData).then((response) => {
                this.success = "Successfully Created";
                this.examData = {
                    name: '',
                    description: '',
                    startDate: '',
                    endDate: '',
                    duration: '',
                    item_num: '',
                    examType: '',
                    questions: [],
                    selectedStudents: []
                };
                window.location.href = '/exams';
            }).catch(error => {
                this.errors = error;
            });
        },
        addQuestion() {
            this.examData.questions.push({
                question: '',
                option1: '',
                option2: '',
                option3: '',
                option4: '',
                correctAnswer: '',
                reference: '',
                topic_id: '',
                subtopic_id: ''
            });
        },
        removeQuestion(index) {
            this.examData.questions.splice(index, 1);
        },
        updateSubtopics(question) {
            question.subtopic_id = '';
        },
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
            if (this.dropdownOpen) {
                this.filterStudents();
            } else {
                this.searchQuery = '';
                this.filteredStudents = [];
            }
        },
        filterStudents() {
            const query = this.searchQuery.toLowerCase();

            if (query) {
                this.filteredStudents = this.students.filter(student =>
                student.name.toLowerCase().includes(query)
                );
            } else {
                // Show only selected students when search is empty
                this.filteredStudents = this.students.filter(student =>
                    this.examData.selectedStudents.includes(student.id)
                );
            }
        }
    },
    props: {
        topics: {
            required: false // This makes the prop optional
        },
        subtopics: {
            required: false // This makes the prop optional
        },
        students: {
            required: false // This makes the prop optional
        }
    },
    mounted() {
    },
    computed: {
        filteredSubtopics() {
            // Filter subtopics based on selected topic_id
            return (topic_id) => this.subtopics.filter(subtopic => subtopic.topic_id === topic_id);
        }
    },
};
</script>

<style scoped>
    .questions-section {
        margin-top: 20px;
    }
    .question-form {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    .custom-dropdown {
        position: relative;
        width: 100%;
    }

    .dropdown-toggle {
        cursor: pointer;
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        border-radius: 0.375rem;
    }

    .dropdown-menu {
        display: block;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 0.375rem;
        z-index: 1050;
        max-height: 200px;
        overflow-y: auto;
        padding: 0.5rem;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .ms-2 {
        margin-left: 0.5rem;
        margin-bottom: 0;
        padding: .2rem 0;
        width: 100%;
    }

    .shadow {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dropdown-menu::-webkit-scrollbar {
        width: 8px;
    }

    .dropdown-menu::-webkit-scrollbar-thumb {
        background: #cccccc;
        border-radius: 4px;
    }

    .dropdown-menu::-webkit-scrollbar-thumb:hover {
        background: #aaaaaa;
    }

    .form-control {
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 0.375rem;
        width: 100%;
    }
</style>
