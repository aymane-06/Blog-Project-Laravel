<x-app-layout>
    <div class="py-12"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @foreach ($errors->all() as $error)
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ $error }}</span>
                        </div>
                    
                    @endforeach
                    <h1 class="text-2xl font-semibold">{{ isset($article) ? "Edit":"Create" }} Article</h1>
                    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-900 flex justify-center w-24 justify-self-end bg-[#f5f5dc]">Back</a>
                    <br>
                    <form method="POST" action="{{ isset($article) ? route('articles.update', $article->id) : route('articles.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($article))
                            @method('PUT')
                        @endif
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                Title
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" value="{{ old('title', $article['title'] ?? '') }}" name="title" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="content">
                                Content
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="content" name="content" rows="5" required>{{ old('content', $article['content'] ?? '') }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                                Category
                            </label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" name="category" required>
                                <option value="" disabled >Select a category</option>
                                @foreach ($categories as $category )
                                    <option value="{{ $category->id }}" {{ old('category', $article['category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
                                Image
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" name="image" type="file" accept="image/*" {{ isset($article) ? '' : 'required' }}>
                            @if(isset($article) && $article->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="Current Image" class="w-32 h-32 object-cover">
                                </div>
                            @endif
                        </div>
                        <button class="bg-[#f5f5dc] hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            {{ isset($article) ? 'Update Article' : 'Create Article' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
