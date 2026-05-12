<nav class="bg-white border-b border-gray-100 p-4">

    <div class="flex justify-between">

        <div>
            <a href="/dashboard">
                Dashboard
            </a>
        </div>

        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit">
                    Logout
                </button>
            </form>
        </div>

    </div>

</nav>