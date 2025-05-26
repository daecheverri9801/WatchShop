export const filters = {
    formatPrice(value) {
        if (!value) return '$0';
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        }).format(value).replace('COP', '$');
    }
};