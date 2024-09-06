<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Tasks List') }}
        </h2>
    </x-slot>
    @include('messages.message')
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
                            @if($task->status !== 'done')
                                <a
                                    href="{{ route('user.task.show', ['id' => $task->id]) }}"
                                    style="color: blue;"
                                >
                                    View
                                </a>
                                <a
                                    href="{{ route('user.task.status', ['id' => $task->id]) }}"
                                    style="color: darkviolet;"
                                >
                                    Status
                                </a>
                            @endif
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

