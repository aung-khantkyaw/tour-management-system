<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.svg" type="image/svg+xml">

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<!-- Alpine Navigate Plugin -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/navigate@latest/dist/cdn.min.js" 
        onerror="this.onerror=null; this.src='https://unpkg.com/@alpinejs/navigate@3.x.x/dist/cdn.min.js'"></script>

<!-- Alpine.js Core -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.0/dist/cdn.min.js"></script>

<!-- Alpine Navigate Fallback -->
<script>
document.addEventListener('alpine:init', () => {
    if (!window.Alpine.navigate) {
        window.Alpine.navigate = (url) => window.location.href = url;
    }
});
</script>

@fluxAppearance