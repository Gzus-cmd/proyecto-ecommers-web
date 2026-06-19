import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\WebProductoController::index
* @see app/Http/Controllers/Admin/WebProductoController.php:16
* @route '/admin/productos'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/productos',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebProductoController::index
* @see app/Http/Controllers/Admin/WebProductoController.php:16
* @route '/admin/productos'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebProductoController::index
* @see app/Http/Controllers/Admin/WebProductoController.php:16
* @route '/admin/productos'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::index
* @see app/Http/Controllers/Admin/WebProductoController.php:16
* @route '/admin/productos'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::create
* @see app/Http/Controllers/Admin/WebProductoController.php:27
* @route '/admin/productos/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/productos/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebProductoController::create
* @see app/Http/Controllers/Admin/WebProductoController.php:27
* @route '/admin/productos/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebProductoController::create
* @see app/Http/Controllers/Admin/WebProductoController.php:27
* @route '/admin/productos/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::create
* @see app/Http/Controllers/Admin/WebProductoController.php:27
* @route '/admin/productos/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::store
* @see app/Http/Controllers/Admin/WebProductoController.php:44
* @route '/admin/productos'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/productos',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\WebProductoController::store
* @see app/Http/Controllers/Admin/WebProductoController.php:44
* @route '/admin/productos'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebProductoController::store
* @see app/Http/Controllers/Admin/WebProductoController.php:44
* @route '/admin/productos'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::show
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
export const show = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/productos/{producto}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebProductoController::show
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
show.url = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { producto: args }
    }

    if (Array.isArray(args)) {
        args = {
            producto: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        producto: args.producto,
    }

    return show.definition.url
            .replace('{producto}', parsedArgs.producto.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebProductoController::show
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
show.get = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::show
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
show.head = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::edit
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}/edit'
*/
export const edit = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/productos/{producto}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebProductoController::edit
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}/edit'
*/
edit.url = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { producto: args }
    }

    if (Array.isArray(args)) {
        args = {
            producto: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        producto: args.producto,
    }

    return edit.definition.url
            .replace('{producto}', parsedArgs.producto.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebProductoController::edit
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}/edit'
*/
edit.get = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::edit
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}/edit'
*/
edit.head = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::update
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
export const update = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/productos/{producto}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Admin\WebProductoController::update
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
update.url = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { producto: args }
    }

    if (Array.isArray(args)) {
        args = {
            producto: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        producto: args.producto,
    }

    return update.definition.url
            .replace('{producto}', parsedArgs.producto.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebProductoController::update
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
update.put = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::update
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
update.patch = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Admin\WebProductoController::destroy
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
export const destroy = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/productos/{producto}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Admin\WebProductoController::destroy
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
destroy.url = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { producto: args }
    }

    if (Array.isArray(args)) {
        args = {
            producto: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        producto: args.producto,
    }

    return destroy.definition.url
            .replace('{producto}', parsedArgs.producto.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebProductoController::destroy
* @see app/Http/Controllers/Admin/WebProductoController.php:0
* @route '/admin/productos/{producto}'
*/
destroy.delete = (args: { producto: string | number } | [producto: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const WebProductoController = { index, create, store, show, edit, update, destroy }

export default WebProductoController