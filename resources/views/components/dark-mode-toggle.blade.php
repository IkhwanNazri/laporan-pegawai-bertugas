<button
    type="button"
    id="darkModeToggle"
    class="relative flex h-10 w-20 items-center rounded-full bg-gray-100 p-1 shadow-sm dark:bg-slate-800"
>
    <span
        id="themeSun"
        class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-amber-500 shadow-sm"
    >
        <x-heroicon-o-sun class="w-5 h-5" />
    </span>

    <span
        id="themeMoon"
        class="absolute right-1 flex h-8 w-8 items-center justify-center rounded-full text-gray-400"
    >
        <x-heroicon-o-moon class="w-5 h-5" />
    </span>
</button>

<script>
(function () {

    const html = document.documentElement;
    const toggle = document.getElementById('darkModeToggle');

    if (!toggle) return;

    const sun = document.getElementById('themeSun');
    const moon = document.getElementById('themeMoon');

    function setTheme(theme) {

        if (theme === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        localStorage.setItem('theme', theme);

        updateButton();
    }

    function updateButton() {

        const isDark = html.classList.contains('dark');

        if (isDark) {

            sun.classList.remove(
                'bg-white',
                'text-amber-500',
                'shadow-sm'
            );

            sun.classList.add(
                'text-gray-400'
            );

            moon.classList.remove(
                'text-gray-400'
            );

            moon.classList.add(
                'bg-slate-700',
                'text-blue-400',
                'shadow-sm'
            );

        } else {

            sun.classList.remove(
                'text-gray-400'
            );

            sun.classList.add(
                'bg-white',
                'text-amber-500',
                'shadow-sm'
            );

            moon.classList.remove(
                'bg-slate-700',
                'text-blue-400',
                'shadow-sm'
            );

            moon.classList.add(
                'text-gray-400'
            );
        }
    }

    toggle.addEventListener('click', function () {

        const currentTheme = html.classList.contains('dark')
            ? 'dark'
            : 'light';

        setTheme(
            currentTheme === 'dark'
                ? 'light'
                : 'dark'
        );

    });

    // Set theme masa page load
    const savedTheme = localStorage.getItem('theme');

    if (savedTheme === 'dark') {
        setTheme('dark');
    } else {
        setTheme('light');
    }

})();
</script>
