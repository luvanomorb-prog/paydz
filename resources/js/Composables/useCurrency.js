export function formatCurrency(value, currency = 'DZD') {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency,
        maximumFractionDigits: 2,
    }).format(Number(value || 0))
}
