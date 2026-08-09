<a {{ $attributes->merge([ 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-emerald-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-emerald-400 active:bg-emerald-500 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
