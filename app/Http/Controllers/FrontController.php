<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscribeTransactionRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\SubscribeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index (){
        $categories = Category::all();
        $courses = Course::inRandomOrder()->take(6)->get();
        return view('front.index', compact('categories','courses'));
    }

    public function category(Category $category) {
        $courses = $category->courses()->get();
        return view('front.category', compact('courses','category'));
    }

    public function details (Course $course) {
        return view('front.details', compact('course'));
    }

    public function learning(Course $course, $courseVideoId) {
        $user = Auth::user();

        if (!$user->hasActiveSubscription()) {
            return redirect()->route('front.pricing');
        }

        $video = $course->courseVideos->firstWhere('id', $courseVideoId);

        $user->courses()->syncWithoutDetaching($course->id);

        return view('front.learning', compact('course','video'));
    }

    public function pricing() {
        return view('front.pricing');
    }

    public function checkout() {
        return view('front.checkout');
    }

    public function success_transaction () {
        return view('front.success_transaction');
    }

    public function checkout_store(StoreSubscribeTransactionRequest $request) {
        $user = Auth::user();
        if ($user->hasActiveSubscription()) {
            return redirect()->route('front.index');
        }
        DB::transaction(function () use($request, $user){
            $validated = $request->validated();

            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proofs','public');
                $validated['proof'] = $proofPath;
            } 

            $validated['user_id'] = $user->id;
            $validated['total_amount'] = 250000;
            $validated['is_paid'] = false;

            $transaction = SubscribeTransaction::create($validated);
        });

        return redirect()->route('front.success-transaction');
    }

    public function showQuestions()
    {
        $questions = [
            "Apakah menurut Anda membaca buku itu membosankan?",
            "Apakah Anda tidak suka bepergian sendirian?",
            "Apakah Anda kesulitan belajar hanya dengan teori dan lebih mudah jika langsung praktek ?",
            "Apakah Anda lebih suka menghadiri acara sosial seperti pesta atau pertemuan besar?",
            "Apakah Anda senang bertemu dengan orang-orang baru dan menjalin pertemanan?",
            "Apakah Anda sering mencari kesempatan untuk berpartisipasi dalam kegiatan sosial atau komunitas?",
            "Apakah Anda menikmati menghabiskan waktu di tempat umum seperti kafe atau pusat perbelanjaan?",
            "Apakah Anda merasa lebih nyaman berkomunikasi secara langsung, baik itu dalam percakapan tatap muka atau panggilan video?",
            "Apakah Anda lebih suka kegiatan yang melibatkan kolaborasi, seperti olahraga tim atau proyek kelompok?",
            "Apakah Anda tidak suka menatap komputer dengan waktu yang lama?",
            "Saat Bermain Bola Anda lebih suka jadi Striker dibanding Kiper?"
        ];

        return view('front.questions', compact('questions'));
    }

    public function processAnswers(Request $request)
    {
        $answers = $request->all();
        
        // Hitung jumlah 'Iya'
        $yesCount = collect($answers)->filter(function ($answer) {
            return $answer === 'yes';
        })->count();

        // Hitung jumlah 'Tidak'
        $noCount = count($answers) - $yesCount;

        // Tentukan kepribadian
        $personality = $yesCount > $noCount ? 'social' : 'personal';

        return redirect()->route('recommendations', ['personality' => $personality]);
    }

    public function getRecommendations($personality)
{
    if ($personality === 'social') {
        $recommendedCourses = Course::whereHas('category', function ($query) {
            $query->whereIn('type', ['social', 'keduanya']);
        })->get();;
    } else {
        $recommendedCourses = Course::whereHas('category', function ($query) {
            $query->whereIn('type', ['personal', 'keduanya']);
        })->get();;
    }

    return view('front.recommendations', compact('recommendedCourses'));
}

}
