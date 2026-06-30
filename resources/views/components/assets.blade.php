@if (file_exists(public_path('build/manifest.json')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                    colors: {
                        ocean: { primary: '#0099CC', secondary: '#00C2A8', dark: '#007AA3' }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .btn-primary { display: inline-flex; align-items: center; justify-content: center; border-radius: 0.75rem; background: #0099CC; padding: 0.75rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: white; box-shadow: 0 10px 15px -3px rgba(0,153,204,0.25); transition: all 0.3s; }
        .btn-primary:hover { background: #007AA3; transform: translateY(-2px); }
        .btn-secondary { display: inline-flex; align-items: center; justify-content: center; border-radius: 0.75rem; background: #00C2A8; padding: 0.75rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: white; transition: all 0.3s; }
        .btn-outline { display: inline-flex; align-items: center; justify-content: center; border-radius: 0.75rem; border: 2px solid #0099CC; padding: 0.75rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: #0099CC; transition: all 0.3s; }
        .btn-outline:hover { background: #0099CC; color: white; }
        .card { border-radius: 1rem; background: white; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); transition: all 0.3s; }
        .card:hover { box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        .input-field { width: 100%; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 0.75rem 1rem; }
        .input-field:focus { outline: none; border-color: #0099CC; box-shadow: 0 0 0 3px rgba(0,153,204,0.2); }
        .section-title { font-size: 1.875rem; font-weight: 700; color: #111827; }
        .badge { display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600; }
        .dark body { background: #111827; color: #f3f4f6; }
        .dark .card { background: #1f2937; }
    </style>
@endif
