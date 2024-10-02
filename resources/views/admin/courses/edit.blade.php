<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                
                <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $course->name }}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="thumbnail" :value="__('thumbnail')" />
                        <x-text-input id="thumbnail" class="block mt-1 w-full" type="file" name="thumbnail" autofocus autocomplete="thumbnail" />
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="path_trailer" :value="__('path_trailer')" />
                        <x-text-input id="path_trailer" class="block mt-1 w-full" type="text" name="path_trailer" value="{{ $course->path_trailer }}" required autofocus autocomplete="path_trailer" />
                        <x-input-error :messages="$errors->get('path_trailer')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category" :value="__('category')" />
                        
                        <select name="category_id" id="category_id" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="">Choose category</option>
                            @forelse($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @empty
                            @endforelse
                        </select>

                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="about" :value="__('about')" />
                        <textarea name="about" id="about" cols="30" rows="5" class="border border-slate-300 rounded-xl w-full">{{ $course->about }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>

                    <!-- Input for WhatsApp Group Link -->
                    <div class="mt-4">
                        <x-input-label for="grup_wa" :value="__('WhatsApp Group Link')" />
                        <x-text-input id="grup_wa" class="block mt-1 w-full" type="text" name="grup_wa" value="{{ $course->grup_wa }}" autofocus autocomplete="grup_wa" />
                        <x-input-error :messages="$errors->get('grup_wa')" class="mt-2" />
                    </div>
                
                    <!-- Input for Discord Group Link -->
                    <div class="mt-4">
                        <x-input-label for="grup_discord" :value="__('Discord Group Link')" />
                        <x-text-input id="grup_discord" class="block mt-1 w-full" type="text" name="grup_discord" value="{{ $course->grup_discord }}" autofocus autocomplete="grup_discord" />
                        <x-input-error :messages="$errors->get('grup_discord')" class="mt-2" />
                    </div>

                    <hr class="my-5">

                    <div class="mt-4">
                        
                        <div class="flex flex-col gap-y-5">
                            <x-input-label for="keypoints" :value="__('keypoints')" />
                           @forelse ($course->courseKeypoints as $keypoint)
                           <input type="text" class="py-3 rounded-lg border-slate-300 border" value="{{ $keypoint->name }}" name="course_keypoints[]">
                           @empty
                               
                           @endforelse
                                
                           
                        </div>
                        <x-input-error :messages="$errors->get('keypoints')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
            
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Update Course
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
