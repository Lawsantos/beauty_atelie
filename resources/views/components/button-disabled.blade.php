<span {{ $attributes }}{{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-500 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-200 focus:outline-none focus:border-gray-200 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</span>
