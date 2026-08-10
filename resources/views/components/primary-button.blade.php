<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-brand-500 border border-transparent rounded-xl font-bold text-xs text-black uppercase tracking-widest hover:bg-brand-400 active:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-glow transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
