<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-fit">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold">Articles</h1>
                    <a href="{{ route('articles.create') }}" class="text-indigo-600 hover:text-indigo-900 flex justify-center w-24 justify-self-end bg-[#f5f5dc]">Create</a>
                    <br>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Created At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tbody" class="divide-y divide-gray-200">
                            <!-- @foreach ($Articles as $article)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->image }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->category->name}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->status}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->created_at->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('articles.edit', $article) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form method="POST" action="{{ route('articles.destroy', $article) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                            <button type="submit" class="text-blue-600 hover:text-blue-900" onclick="updateStatus({{ $article->id }}, '{{ $article->status }}')">
                                                {{ $article->status == 'published' ? 'Draft' : 'Publish' }}
                                            </button>
                                        

                                    </td>


                                </tr>
                            @endforeach -->
                        </tbody>
                    </table>

                    <div id="pagination-container"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
         async function showArticles(page=`http://127.0.0.1:8000/articles?page=1`){
            try {
                const response = await fetch(`${page}`);
                const data = await response.json();
                console.log(data);

                let articles = data.data;
                let tbody = document.getElementById('tbody');
                tbody.innerHTML = '';
                articles.forEach(article => {
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">${article.title}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${article.image}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${article.category.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${article.status}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${new Date(article.created_at).toISOString().split('T')[0]}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="/article/edit/${article.id}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <button type="button" class="text-blue-600 hover:text-blue-900" onclick="deleteArticle(${article.id})">
                                Delete
                            </button>
                            <button type="button" class="text-blue-600 hover:text-blue-900" onclick="updateStatus(${article.id}, '${article.status}')">
                                ${article.status == 'published' ? 'Draft' : 'Publish'}
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });

                if (data.links) {
                    console.log(data.links);
                    let pages = data.links;
                    document.getElementById('pagination-container').innerHTML = '';
                    pages.forEach(page => {
                       
                            document.getElementById('pagination-container').innerHTML += `<button class="bg-blue-500 text-white p-2" onclick="showArticles('${page.url}')">${page.label}</button>`
                        
                    });
                }
            } catch (error) {
                console.error('Error fetching articles:', error);
            }
        }
        showArticles();
        async function updateStatus(id, status) {
            console.log(id,status);

            
            let data = new FormData();
            data.append('status', status == 'published' ? 'draft' : 'published');
            data.append('_token', '{{ csrf_token() }}');
            await fetch(`/article/updateStatus/${id}`, {
                method: 'POST',
                body: data 
            })
            showArticles();

        }
        async function deleteArticle(id) {
            await fetch(`/article/delete/${id}`, {
                method: 'DELETE',
                headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'    
                }
            })
            showArticles();
        }


    </script>
</x-app-layout>
