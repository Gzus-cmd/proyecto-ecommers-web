<script setup lang="ts">
import { Plus } from 'lucide-vue-next';

interface Props {
    title: string;
    subtitle: string;
    instruction?: string;
}

withDefaults(defineProps<Props>(), {
    instruction: 'Complete todos los campos requeridos'
});
</script>

<template>
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-primary/5 p-6 rounded-2xl border border-primary/20">
        <div class="flex items-center gap-5">
            <!-- Icono con estilo circular/cuadrado redondeado -->
            <div class="p-4 bg-primary/10 rounded-xl text-primary border border-primary/20 shadow-inner">
                <Plus class="size-7" />
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-primary/70 mb-1">
                    {{ title }}
                </p>
                <h2 class="text-2xl font-bold text-foreground leading-none">
                    {{ subtitle }}
                </h2>
            </div>
        </div>

        <!-- Badge de Estado de Proceso -->
        <div class="text-right bg-background/60 px-5 py-3 rounded-xl border border-border/50 shadow-sm">
            <span class="block text-[9px] font-black uppercase text-muted-foreground tracking-widest mb-1">
                Estado del Registro
            </span>
            <span class="text-primary font-black text-xs uppercase tracking-tighter flex items-center gap-2">
                <div class="size-1.5 bg-primary rounded-full animate-pulse"></div>
                Borrador Nuevo
            </span>
        </div>
    </div>
</template>