<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles & Permissions Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Display success message -->
            @if (session('success'))
                <div id="success-alert" class="p-4 mb-4 text-sm text-dark-700 bg-gray-300 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Roles Management Section -->
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">{{ __('Roles') }}</h2>
                <!-- Button to open modal to create a new role -->
                <a  onclick="openRoleModal()">
                    <x-primary-button>
                        {{ __('Add New Role') }}
                    </x-primary-button>


                </a>
            </div>

            <!-- Roles Table -->
            <div class="overflow-hidden shadow-md sm:rounded-lg mt-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    {{ __('Role Name') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    {{ __('Permissions') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                        {{ $role->name }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-wrap text-sm text-gray-900">
                                        @foreach ($role->permissions as $permission)
                                            <span
                                                class="inline-block text-dark-700 bg-gray-100 text-xs px-2 py-1 mt-1 rounded">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                        <!-- Edit Role Permissions -->
                                        <button onclick="openEditRolePermissionsModal({{ $role->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.121 4.121a3 3 0 00-4.242 0L3 11.586V17h5.414l6.879-6.879a3 3 0 000-4.242z">
                                                </path>
                                            </svg>
                                        </button>
                                        <!-- Delete Role -->
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to delete this role?');">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Permissions Management Section -->
            <div class="mt-8">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">{{ __('Permissions') }}</h2>
                    <!-- Button to open modal to create a new permission -->
                    <a  onclick="openPermissionModal()">
                        <x-primary-button>{{ __('Add New Permission') }}</x-primary-button>
                    </a>
                </div>

                <!-- Permissions Table -->
                <div class="overflow-hidden shadow-md sm:rounded-lg mt-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        {{ __('Permission Name') }}
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                            {{ $permission->name }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                            <!-- Delete Permission -->
                                            <form action="{{ route('permissions.destroy', $permission->id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to delete this permission?');">
                                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Creation Modal -->
    <div id="roleModal" class="fixed z-10 inset-0 overflow-y-auto hidden transition-opacity duration-300 ease-in-out">
        <div class="flex items-center justify-center min-h-screen">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">
                        {{ __('Create New Role') }}
                    </h3>
                    <button type="button" onclick="closeRoleModal()"
                        class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    <div class="mt-4">
                        <input type="text" name="name" id="role_name" placeholder="Role Name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out">
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" onclick="closeRoleModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-md hover:bg-gray-300 transition ease-in-out duration-200">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition ease-in-out duration-200">
                            {{ __('Create Role') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Permission Creation Modal -->
    <div id="permissionModal"
        class="fixed z-10 inset-0 overflow-y-auto hidden transition-opacity duration-300 ease-in-out">
        <div class="flex items-center justify-center min-h-screen">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">
                        {{ __('Create New Permission') }}
                    </h3>
                    <button type="button" onclick="closePermissionModal()"
                        class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('permissions.store') }}">
                    @csrf
                    <div class="mt-4">
                        <input type="text" name="name" id="permission_name" placeholder="Permission Name"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out">
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" onclick="closePermissionModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-md hover:bg-gray-300 transition ease-in-out duration-200">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition ease-in-out duration-200">
                            {{ __('Create Permission') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div id="editRolePermissionsModal"
        class="fixed z-10 inset-0 overflow-y-auto hidden transition-opacity duration-300 ease-in-out">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
            <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Edit Role Permissions</h3>
                    <button type="button" onclick="closeEditRolePermissionsModal()"
                        class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-4">
                    <form id="rolePermissionForm" method="POST"
                        action="{{ route('roles.permissions.assign', $role->id) }}"">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="permissions">Assign Permissions</label>
                            <div id="permissions" class="mt-2 space-y-2">
                                @foreach ($permissions as $permission)
                                    <div class="flex items-center">
                                        <input type="checkbox" id="permission-{{ $permission->id }}"
                                            name="permissions[]" value="{{ $permission->id }}" class="mr-2">
                                        <label for="permission-{{ $permission->id }}" class="text-gray-800">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" onclick="closeEditRolePermissionsModal()"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-md hover:bg-gray-300 transition ease-in-out duration-200">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition ease-in-out duration-200">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
<script>
    function openRoleModal() {
        const modal = document.getElementById('roleModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
        }, 10); // Slight delay for smooth fade-in effect
    }

    function closeRoleModal() {
        const modal = document.getElementById('roleModal');
        modal.classList.remove('opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // Delayed removal for fade-out effect
    }

    function openPermissionModal() {
        const modal = document.getElementById('permissionModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
        }, 10); // Slight delay for smooth fade-in effect

    }

    function closePermissionModal() {
        const modal = document.getElementById('permissionModal');
        modal.classList.remove('opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // Delayed removal for fade-out effect
    }

    function openEditRolePermissionsModal(roleId) {
        // Fetch role data based on roleId (use AJAX or any method you prefer)
        fetch(`roles-permissions/roles/${roleId}/edit`) // Assuming you have an endpoint to get the role details
            .then(response => response.json())
            .then(data => {
                // Populate the form with the role's permissions
                const rolePermissionForm = document.getElementById('rolePermissionForm');
                rolePermissionForm.action =
                    `roles-permissions/roles/${data.id}/permissions`; // Set the form action for updating the role permissions

                // Reset all checkboxes
                const permissionCheckboxes = document.querySelectorAll('#permissions input[type="checkbox"]');
                permissionCheckboxes.forEach(checkbox => checkbox.checked = false);

                // Check the permissions for the current role
                data.permissions.forEach(permission => {
                    const checkbox = document.getElementById(`permission-${permission.id}`);
                    if (checkbox) {
                        checkbox.checked = true; // Check the permission if it exists
                    }
                });

                // Show the modal
                document.getElementById('editRolePermissionsModal').classList.remove('hidden');
            });
    }


    function closeEditRolePermissionsModal() {
        const modal = document.getElementById('editRolePermissionsModal');
        modal.classList.remove('opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
