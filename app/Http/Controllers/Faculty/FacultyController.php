<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Topic;
use App\Tes;
use App\User;

class FacultyController extends Controller
{
    public function index() {
        $results = Topic::query()
            ->with('subtopics') // Load the subtopics relationship
            ->get()
            ->map(function ($topic) {
                // Get all student responses for this topic
                $responses = Tes::query()
                    ->whereIn('topic', $topic->subtopics->pluck('subtopic_id')) // Get responses for all subtopics of the topic
                    ->selectRaw('student_id, topic, MAX(score) as max_score, MAX(itemnum) as itemnum')
                    ->groupBy('student_id', 'topic')
                    ->get();

                // Get students who passed
                $passedStudents = $responses->filter(function ($response) {
                    return $response->max_score >= 0.7 * $response->itemnum;
                })->pluck('student_id')->unique(); // Get unique student_ids who passed

                // Get students who failed
                $failedStudents = $responses->filter(function ($response) {
                    return $response->max_score < 0.7 * $response->itemnum;
                })->pluck('student_id')->unique(); // Get unique student_ids who failed

                // Map student details (names, etc.) for passed and failed students
                $passedStudentDetails = $passedStudents->map(function ($studentId) {
                    return User::find($studentId)->name; // Assuming 'name' is the student’s name
                });

                $failedStudentDetails = $failedStudents->map(function ($studentId) {
                    return User::find($studentId)->name; // Assuming 'name' is the student’s name
                });

                // Calculate the score distribution
                $scores = $responses->pluck('max_score')->toArray();
                $totalStudents = count($scores);
                
                // Calculate the distribution (for bell curve purposes)
                $scoreDistribution = $this->calculateMeanAndStdDev($scores);

                 // Only return topics with pass or fail data
                if ($passedStudents->count() > 0 || $failedStudents->count() > 0) {
                    return [
                        'topic_id' => $topic->topic_id,
                        'topic_name' => $topic->topic_name,
                        'students_passed' => $passedStudents->count(), // Count of students who passed
                        'students_failed' => $failedStudents->count(), // Count of students who failed
                        'mean' => $scoreDistribution['mean'],
                        'stdDev' => $scoreDistribution['stdDev'],
                        'total_students' => $totalStudents, // Total number of students for this topic
                    ];
                }

                return null;

                // return [
                //     'topic_id' => $topic->topic_id,
                //     'topic_name' => $topic->topic_name,
                //     'students_passed' => $passedStudentDetails->count(),
                //     'students_failed' => $failedStudentDetails->count(),
                //     'mean' => $scoreDistribution['mean'],
                //     'stdDev' => $scoreDistribution['stdDev'],
                //     'total_students' => $totalStudents,
                // ];
            })
            ->filter() // Remove null entries (topics with no passed or failed students)
            ->values(); // Re-index the array

        // dd($results);
        return view('faculty', compact('results'));
    }

    private function calculateMeanAndStdDev(array $scores)
    {
        // If there are no scores, return null values
        if (count($scores) === 0) {
            return [
                'mean' => null,
                'stdDev' => null,
            ];
        }
    
        // Calculate mean
        $mean = array_sum($scores) / count($scores);
    
        // Calculate variance and standard deviation
        $variance = array_sum(array_map(function($score) use ($mean) {
            return pow($score - $mean, 2);
        }, $scores)) / count($scores);
    
        $stdDev = sqrt($variance);
    
        return [
            'mean' => $mean,
            'stdDev' => $stdDev,
        ];
    }
}
