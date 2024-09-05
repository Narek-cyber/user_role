<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="POST" action="{{ route('admin.tasks.store') }}">
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
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
{{--                @forelse($users as $key => $user)--}}
{{--                    <td>{{$key + 1}}</td>--}}
{{--                    <td>{{$user->name}}</td>--}}
{{--                    <td>{{$user->lastname}}</td>--}}
{{--                    <td>{{$user->email}}</td>--}}
{{--                    <td>{{$user->phone}}</td>--}}
{{--                    <td>{{$user->date_of_birth}}</td>--}}
{{--                    <td>--}}
{{--                        <form--}}
{{--                            action="{{ route('admin.invite', ['id' => $user->id]) }}"--}}
{{--                            method="POST"--}}
{{--                        >--}}
{{--                            @csrf--}}
{{--                            <button--}}
{{--                                class="btn btn-primary btn-sm"--}}
{{--                                type="submit"--}}
{{--                            >--}}
{{--                                Invite--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                    </td>--}}
{{--                @empty--}}
{{--                    <td--}}
{{--                        colspan="7"--}}
{{--                        class="text-center fw-bold"--}}
{{--                    >--}}
{{--                        No users yet--}}
{{--                    </td>--}}
{{--                @endforelse--}}
                </tbody>
            </table>
            <div class="mt-3">
                <div class="d-flex">
                    @isset($users)
                        {{ $users->links() }}
                    @endisset
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

