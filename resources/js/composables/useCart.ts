import { ref, computed } from 'vue';

interface CartItem {
    sku: string;
    nombre: string;
    precio: number;
    imagen: string;
    quantity: number;
}

const cart = ref<CartItem[]>([]);

export function useCart() {
    if (typeof window !== 'undefined' && cart.value.length === 0) {
        const saved = localStorage.getItem('pv_cart');
        if (saved) {
            try {
                const parsed = JSON.parse(saved);
                cart.value = parsed.map((item: any) => ({
                    ...item,
                    precio: Number(item.precio) || 0,
                    quantity: Number(item.quantity) || 1
                }));
            } catch (e) { cart.value = []; }
        }
    }

    const save = () => {
        if (typeof window !== 'undefined') {
            localStorage.setItem('pv_cart', JSON.stringify(cart.value));
        }
    };


    const addToCart = (product: any, qty: number = 1) => {
        const item = cart.value.find(i => i.sku === product.sku);
        const price = Number(product.precio_web) || 0;

        if (item) {
            item.quantity = Number(item.quantity) + Number(qty);
        } else {
            cart.value.push({
                sku: product.sku,
                nombre: product.nombre_comercial,
                precio: price,
                imagen: product.imagen_url,
                quantity: Number(qty)
            });
        }
        save();
    };


    const removeFromCart = (sku: string) => {
        cart.value = cart.value.filter(item => item.sku !== sku);
        save();
    };

    const count = computed(() => cart.value.reduce((acc, i) => acc + i.quantity, 0));
    const total = computed(() => cart.value.reduce((acc, i) => acc + (i.precio * i.quantity), 0));

    const clearCart = () => {
        cart.value = [];
        if (typeof window !== 'undefined') {
            localStorage.removeItem('pv_cart');
        }
    };

    return { cart, addToCart, removeFromCart, clearCart, count, total };
}