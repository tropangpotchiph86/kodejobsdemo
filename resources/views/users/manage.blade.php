<x-layout>
  
    {{-- Cards Displaying User Counts --}}
    <div class="flex flex-wrap -m-2 mb-6">
      <div class="w-full sm:w-1/2 md:w-1/4 p-2">
        <div class="bg-white rounded shadow p-4 text-center">
          <div class="text-lg font-semibold">Total Users</div>
          <div class="text-xl font-bold">{{ $totalUsers }}</div>
        </div>
      </div>
      <div class="w-full sm:w-1/2 md:w-1/4 p-2">
        <div class="bg-white rounded shadow p-4 text-center">
          <div class="text-lg font-semibold">Admin Users</div>
          <div class="text-xl font-bold">{{ $adminUsers }}</div>
        </div>
      </div>
      <div class="w-full sm:w-1/2 md:w-1/4 p-2">
        <div class="bg-white rounded shadow p-4 text-center">
          <div class="text-lg font-semibold">HR Users</div>
          <div class="text-xl font-bold">{{ $hrUsers }}</div>
        </div>
      </div>
      <div class="w-full sm:w-1/2 md:w-1/4 p-2">
        <div class="bg-white rounded shadow p-4 text-center">
          <div class="text-lg font-semibold">Normal Users</div>
          <div class="text-xl font-bold">{{ $normalUsers }}</div>
        </div>
      </div>
    </div>

   {{-- Filter and Add User Buttons --}}
   <div class="flex justify-between mb-4 py-10">
    <div>
        <label for="filterRole" class="mr-2">Filter User Role:</label>
        <select id="filterRole" onchange="filterUsersByRole()" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <option value="all">All</option>
            <option value="admin">Admin</option>
            <option value="HR">HR</option>
            <option value="normal">Normal User</option>
        </select>
    </div>
    <button onclick="openAddUserModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-4">
      Add User
  </button>
</div>

{{-- Add User Modal --}}
<div id="addUserModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      {{-- Modal Overlay --}}
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      
      {{-- Modal Content --}}
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                  <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                      <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                          Add New User
                      </h3>
                      <div class="mt-2">
                          <form method="POST" action="{{ route('manage.users.create') }}">
                              @csrf
                              <div class="mb-4 w-full">
                                  <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                  <input type="text" name="name" id="name" placeholder="Enter Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                              </div>
                              <div class="mb-4 w-full">
                                  <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                  <input type="email" name="email" id="email" placeholder="Enter Email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                              </div>
                              <div class="mb-4 w-full">
                                  <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                                  <input type="password" name="password" id="password" placeholder="Enter Password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                              </div>
                              <div class="mb-4 w-full">
                                  <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role:</label>
                                  <select name="role" id="role" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                      <option value="normal">Normal User</option>
                                      <option value="HR">HR</option>
                                      <option value="admin">Admin</option>
                                  </select>
                              </div>
                              <div class="flex items-center justify-between">
                                  <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                      Add User
                                  </button>
                                  <button type="button" onclick="document.getElementById('addUserModal').classList.add('hidden')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                      Cancel
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

  {{-- ... Existing Table and Pagination ... --}}
  <div class="bg-gray-50 border border-gray-200 p-5 rounded">
    <header>
      <h1 class="text-3xl text-center font-bold my-6 uppercase">
        Manage Users
      </h1>
    </header>

    <table class="w-full table-auto rounded-sm">
      <tbody>
        @unless($users->isEmpty())

        @foreach($users as $user)

        <tr class="border-gray-300">
          <td class="px-4 py-4 border-t border-b border-gray-300 text-lg">
            {{ $user->name }}
          </td>
          <td class="px-4 py-4 border-t border-b border-gray-300 text-lg">
            {{ $user->email }}
          </td>
          <td class="px-4 py-4 border-t border-b border-gray-300 text-lg">
            <!-- Dropdown for changing user role -->
            <form method="POST" action="/users/{{$user->id}}/role">
              @csrf
              @method('PATCH')
              <div class="inline-block relative w-40">
                <select name="role" onchange="this.form.submit()" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                  <option value="normal" {{ $user->role == 'normal' ? 'selected' : '' }}>Normal User</option>
                  <option value="HR" {{ $user->role == 'HR' ? 'selected' : '' }}>HR</option>
                  <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M5.516 7.548c.436 0 .84.28.993.683l.007.02 1.55 4.667c.089.27.28.449.532.449s.443-.179.532-.449l1.55-4.667c.154-.403.558-.683.994-.683h.501L10 11.386 5.516 7.548h.501zm-.501 1.22l2.483 2.109-2.483 2.111v-4.22z"/>
                  </svg>
                </div>
              </div>
            </form>
            
          </td>
          <td class="px-4 py-4 border-t border-b border-gray-300 text-lg">
            <!-- Delete User -->
            <form method="POST" action="/users/{{$user->id}}">
              @csrf
              @method('DELETE')
              <button class="text-red-500">
                <i class="fa-solid fa-trash-can"></i>
                Delete
              </button>
            </form>
          </td>
        </tr>
        @endforeach

        @else
        <tr class="border-gray-300">
          <td class="px-4 py-4 border-t border-b border-gray-300 text-lg">
            <p class="text-center">No Users Found </p>
          </td>
        </tr>
      @endunless 
      </tbody>
    </table>
    {{-- Pagination --}}
    <div class="mt-4">
      {{ $users->links() }}
     </div>
  </div>
</x-layout>

<script>

function filterUsersByRole() {
        const selectedRole = document.getElementById('filterRole').value;
        window.location.href = `?role=${selectedRole}`;
    }
    
  function openAddUserModal() {
      // Reset form fields
      document.getElementById('name').value = '';
      document.getElementById('email').value = '';
      document.getElementById('password').value = '';
      document.getElementById('role').selectedIndex = 0;

      // Show the modal
      document.getElementById('addUserModal').classList.remove('hidden');
  }
</script>