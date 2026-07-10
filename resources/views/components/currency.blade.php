@props([
    'amount',
    'labelClass' => 'text-[0.65rem] font-semibold uppercase tracking-wider text-gray-400',
    'amountClass' => 'font-semibold text-gray-900 dark:text-white',
])

<span {{ $attributes->merge(['class' => 'inline-flex flex-col leading-tight']) }}>
    <span class="{{ $labelClass }}">PKR</span>
    <span class="{{ $amountClass }}">{{ \App\Support\Currency::format($amount) }}</span>
</span>
