@if (session('success'))
    <div {{ $attributes->merge(['class' => 'rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300']) }}>
        {{ session('success') }}
    </div>
@endif