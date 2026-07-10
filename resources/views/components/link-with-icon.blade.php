@props(['active','iconType'])


<a {{ $attributes->merge(['class' => 'flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors group']) }}>
                    <x-icon-dashboard :active="$active" class="{{ $iconType }}"></x-icon-dashboard>
                    {{ $slot }} 
</a>