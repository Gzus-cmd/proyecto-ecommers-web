<script setup lang="ts">
const props = defineProps<{ status: string | boolean | number; }>();

const config: Record<string, string> = {

    'Activo': 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
    'Inactivo': 'bg-rose-500/10 text-rose-500 border-rose-500/20',
    'Disponible': 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
    

    'Pendiente': 'bg-amber-500/10 text-amber-500 border-amber-500/20',
    'Pagado': 'bg-blue-500/10 text-blue-500 border-blue-500/20',
    'Enviado': 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
    'Entregado': 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
    'Cancelado': 'bg-rose-500/10 text-rose-500 border-rose-500/20',
};

const label = props.status === true || props.status === 1 ? 'Activo' : 
              props.status === false || props.status === 0 ? 'Inactivo' : props.status;
</script>

<template>
    <span :class="['rounded-full px-2.5 py-0.5 text-[9px] font-black border uppercase tracking-widest inline-block transition-colors duration-300', config[label as string] || 'bg-muted text-muted-foreground border-border']">
        {{ label }}
    </span>
</template>