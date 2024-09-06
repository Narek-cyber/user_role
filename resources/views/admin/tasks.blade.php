<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks List') }}
        </h2>
    </x-slot>
    @include('messages.message')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="POST" action="{{ route('admin.task.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Task title</label>
                    <input type="text" class="form-control" id="title" aria-describedby="titleHelp" name="title">
                    @error('title')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                    @error('description')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Assigned To</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tasks as $key => $task)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->user->name ?? 'Unassigned'}} {{ $task->user->lastname ?? ''}}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a
                                href="{{ route('admin.assign', ['id' => $task->id]) }}"
                                style="color: blue;"
                            >
                                Assign
                            </a>
                            <a
                                href="{{ route('admin.task.status', ['id' => $task->id]) }}"
                                style="color: darkviolet;"
                            >
                                Status
                            </a>
                        </td>
                    </tr>
                @empty
                    <td
                        colspan="7"
                        class="text-center fw-bold"
                    >
                        No tasks yet
                    </td>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                <div class="d-flex">
                    @isset($tasks)
                        {{ $tasks->links() }}
                    @endisset
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

