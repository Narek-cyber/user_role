<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users List') }}
        </h2>
    </x-slot>
    @include('messages.message')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form
                method="POST"
                action="{{ route('admin.assign.task', ['id' => $task->id]) }}"
            >
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <select
                        class="form-select"
                        aria-label="Default select example"
                        name="assign-task"
                    >
                        <option
                            selected
                            value=""
                        >
                            Select user
                        </option>
                        @if(isset($users) && !empty($users))
                            @foreach($users as $user)
                                <option
                                    {{ $task->assigned_to == $user->id ? 'selected' : '' }}
                                    value="{{ $user->id }}">
                                    {{ $user->name }} {{ $user->lastname }}
                                </option>
                            @endforeach
                        @endif
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
