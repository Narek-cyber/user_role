<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statuses List') }}
        </h2>
    </x-slot>
    @include('messages.message')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form
                method="POST"
                action="{{ route('user.task.status.update', ['id' => $task->id]) }}"
            >
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <select name="status">
                        @foreach($task_statuses as $statusKey => $statusLabel)
                            <option
                                value="{{ $statusKey }}"
                                {{ $task->status == $statusKey ? 'selected' : '' }}
                            >
                                {{ $statusLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Submit
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
