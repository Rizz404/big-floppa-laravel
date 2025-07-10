<header
    class="bg-gradient-to-r from-teto-dark to-teto-light text-white shadow-md">
    <nav class="flex items-center justify-between px-4 md:px-12 py-4 mx-auto">
        <a href="{{ route('home') }}" class="bold text-2xl flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2"
                viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
            </svg>
            <span class="font-sans">TetoEdu</span>
        </a>
        <div class="flex items-center gap-4 md:gap-8">
            <div class="flex gap-4 items-center">
                <a href="#"
                    class="font-sans font-medium cursor-pointer hover:text-teto-accent-hover {{ request()->routeIs('my-college-majors.index') ? ' text-teto-accent-active' : ' text-white' }} transition-colors duration-300 ease-in-out flex items-center">
                    About Us
                </a>
                <a href="#"
                    class="font-sans font-medium cursor-pointer hover:text-teto-accent-hover {{ request()->routeIs('my-college-majors.index') ? ' text-teto-accent-active' : ' text-white' }} transition-colors duration-300 ease-in-out flex items-center">
                    FAQ
                </a>
                <a href="#"
                    class="font-sans font-medium cursor-pointer hover:text-teto-accent-hover {{ request()->routeIs('my-college-majors.index') ? ' text-teto-accent-active' : ' text-white' }} transition-colors duration-300 ease-in-out flex items-center">
                    Contact
                </a>
            </div>
            @auth
                @php
                    $user = Auth::user();
                    $profilePicture = $user->profile_picture;
                    $defaultAvatarSvg = '
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>';
                @endphp
                <a href="{{ route('profile.index') }}"
                    class="  font-sans font-medium cursor-pointer hover:text-teto-dark-text-muted {{ request()->routeIs('profile.index') ? ' text-teto-accent-active' : ' text-teto-dark-text' }} transition-colors duration-300 ease-in-out">
                    @if ($profilePicture)
                        <img src="{{ $profilePicture }}"
                            alt="{{ $user->username }}'s profile picture"
                            class="h-8 w-8 rounded-full object-cover">
                    @else
                        {!! $defaultAvatarSvg !!}
                    @endif
                </a>
            @else
                <div class="flex gap-2 items-center">
                    <a href="{{ route('login') }}"
                        class="font-sans font-medium cursor-pointer hover:text-teto-accent-hover {{ request()->routeIs('login') ? ' text-teto-accent-active' : ' text-white' }} transition-colors duration-300 ease-in-out flex items-center">
                        <span>Login</span>
                    </a>
                    <a href="{{ route('register') }}"
                        class="font-sans font-medium cursor-pointer hover:text-teto-accent-hover {{ request()->routeIs('register') ? ' text-teto-accent-active' : ' text-white' }} transition-colors duration-300 ease-in-out flex items-center">
                        <span>Register</span>
                    </a>
                </div>
            @endauth
        </div>
    </nav>
</header>
