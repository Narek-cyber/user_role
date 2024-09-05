<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <table class="table">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $key => $user)
                    <td>{{$key + 1}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->lastname}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->date_of_birth}}</td>
                    <td>
                        <form
                            action="{{ route('admin.invite', ['id' => $user->id]) }}"
                            method="POST"
                        >
                            @csrf
                            <button
                                class="btn btn-primary btn-sm"
                                type="submit"
                            >
                                Invite
                            </button>
                        </form>
                    </td>
                @empty
                    <td
                        colspan="7"
                        class="text-center fw-bold"
                    >
                        No users yet
                    </td>
                @endforelse
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

