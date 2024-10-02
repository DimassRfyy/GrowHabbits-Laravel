<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('css/output.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
</head>
<body class="text-black font-poppins pt-10">
    <div id="checkout-section" class="max-w-[1200px] mx-auto w-full flex flex-col gap-10 pb-[50px] bg-[url('assets/background/Hero-Banner.png')] bg-center bg-no-repeat bg-cover rounded-[32px] overflow-hidden">
        <nav class="flex justify-between items-center pt-6 px-[50px]">
            <a href="{{ route('front.index') }}">
                <img src="{{ asset('assets/logo/logo-white.png') }}" alt="logo">
            </a>
            <ul class="flex items-center gap-[30px] text-white">
                <li>
                    <a href="{{ route('front.index') }}" class="font-semibold">Home</a>
                </li>
                <li>
                    <a href="{{ route('front.pricing') }}" class="font-semibold">Pricing</a>
                </li>
                <li>
                    <a href="{{ route('showQuestions') }}" class="font-semibold">Rekomendasi</a>
                </li>
                <li>
                    <a href="" class="font-semibold">Contact</a>
                </li>
            </ul>
            @auth
            <div class="flex gap-[10px] items-center">
                <div class="flex flex-col items-end justify-center">
                    <p class="font-semibold text-white">Hi, {{ Auth::user()->name }}</p>
                    @if (Auth::user()->hasActiveSubscription())
                    <p class="p-[2px_10px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center">PRO</p>
                    @endif
                </div>
                <div class="w-[56px] h-[56px] overflow-hidden rounded-full flex shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" class="w-full h-full object-cover" alt="photo">
                    </a>
                </div>
            </div>
            @endauth
    
            @guest
            <div class="flex gap-[10px] items-center">
                <a href="{{ route('register') }}" class="text-white font-semibold rounded-[30px] p-[16px_32px] ring-1 ring-white transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">Sign Up</a>
                <a href="{{ route('login') }}" class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]">Sign In</a>
            </div>
            @endguest
        </nav>
        
        <div class="flex flex-col gap-[10px] items-center">
            <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                <div>
                    <img src="assets/icon/medal-star.svg" alt="icon">
                </div>
                <p class="font-medium text-sm text-[#FF6129]">Invest In Yourself Today</p>
            </div>
            <h2 class="font-bold text-[40px] leading-[60px] text-white">Answer These Questions</h2>
        </div>
    
        <!-- Flex container to center the form -->
        <div class="flex justify-center items-center px-[100px] relative z-10">
            <div class="bg-[#F5F8FA] p-5 rounded-xl shadow-md max-w-lg w-full">
                <form action="{{ route('processAnswers') }}" method="POST">
                    @csrf
                    @foreach ($questions as $index => $question)
                        <div class="mb-6  p-4 rounded-lg shadow-md">
                            <p class="text-lg font-semibold">{{ $question }}</p>
                            <div class="flex items-center mt-2 space-x-6">
                                <label class="flex items-center">
                                    <input type="radio" name="question_{{ $index }}" value="yes" required class="form-radio h-5 w-5 text-orange-500">
                                    <span class="ml-2 p-4 font-medium">Iya</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="question_{{ $index }}" value="no" required class="form-radio h-5 w-5 text-orange-500">
                                    <span class="ml-2 font-medium">Tidak</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
    
                    <div class="flex justify-center bg-orange-500 text-xl">
                        <button type="submit" class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <!-- JavaScript -->
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/main.js') }}"></script>
    
</body>
</html>