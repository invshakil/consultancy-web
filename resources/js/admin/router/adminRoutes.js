const routes = [
    {
        path: 'home',
        meta: {
            name: 'Dashboard',
            slug: 'dashboard',
            requiresAuth: true
        },
        component: () => import(`@/components/dash-views/Dashboard.vue`)
    },
    {
        path: 'user-profile',
        name: 'user-profile',
        meta: {
            name: 'User Profile',
            slug: 'user-profile',
            requiresAuth: true
        },
        component: () => import(`@/views/UserProfile.vue`)
    },
    {
        path: 'applications',
        name: 'applications',
        meta: {name: 'Applications', slug: 'applications', requiresAuth: true},
        component: () => import(`@/views/Applications/List.vue`)
    },
    {
        path: 'articles',
        name: 'articles',
        meta: {name: 'Articles', slug: 'articles', requiresAuth: true},
        component: () => import(`@/views/Articles/List.vue`)
    },
    {
        path: 'create-article',
        name: 'new-article',
        meta: {name: 'New Article', slug: 'new-article', requiresAuth: true},
        component: () => import(`@/views/Articles/New.vue`),
    },
    {
        path: 'articles/:slug/edit',
        name: 'edit-articles',
        meta: {name: 'Edit Article', slug: 'edit-article', requiresAuth: true},
        component: () => import(`@/views/Articles/Edit.vue`),
    },
    {
        path: 'jobs',
        name: 'jobs',
        meta: {name: 'Jobs', slug: 'jobs', requiresAuth: true},
        component: () => import(`@/views/Jobs/List.vue`)
    },
    {
        path: 'create-job',
        name: 'new-job',
        meta: {name: 'New Job', slug: 'new-job', requiresAuth: true},
        component: () => import(`@/views/Jobs/New.vue`),
    },
    {
        path: 'jobs/:slug/edit',
        name: 'edit-jobs',
        meta: {name: 'Edit Job', slug: 'edit-job', requiresAuth: true},
        component: () => import(`@/views/Jobs/Edit.vue`),
    },
    {
        path: 'create-news',
        name: 'new-news',
        meta: {name: 'New News', slug: 'new-news', requiresAuth: true},
        component: () => import(`@/views/News/New.vue`),
    },
    {
        path: 'news/:slug/edit',
        name: 'edit-news',
        meta: {name: 'Edit News', slug: 'edit-news', requiresAuth: true},
        component: () => import(`@/views/News/Edit.vue`),
    },
    {
        path: 'countries',
        name: 'countries',
        meta: {name: 'Countries', slug: 'countries', requiresAuth: true},
        component: () => import(`@/views/Countries/List.vue`),
    },
    {
        path: 'industries',
        name: 'industries',
        meta: {name: 'Industries', slug: 'industries', requiresAuth: true},
        component: () => import(`@/views/Industries/List.vue`),
    },
    {
        path: 'news',
        name: 'news',
        meta: {name: 'News', slug: 'news', requiresAuth: true},
        component: () => import(`@/views/News/List.vue`)
    },
    {
        path: 'pages',
        name: 'pages',
        meta: {name: 'Pages', slug: 'pages', requiresAuth: true},
        component: () => import(`@/views/Pages/List.vue`)
    },
    {
        path: 'create-page',
        name: 'new-page',
        meta: {name: 'New Article', slug: 'new-page', requiresAuth: true},
        component: () => import(`@/views/Pages/New.vue`),
    },
    {
        path: 'categories',
        name: 'categories',
        meta: {name: 'Categories', slug: 'categories', requiresAuth: true},
        component: () => import(`@/views/Categories/List.vue`),
    },
    {
        path: 'pages/:slug/edit',
        name: 'edit-pages',
        meta: {name: 'Edit Page', slug: 'edit-page', requiresAuth: true},
        component: () => import(`@/views/Pages/Edit.vue`),
    },
    {
        path: 'widget-settings',
        name: 'widget-settings',
        meta: {name: 'Widget Settings', slug: 'widget-settings', requiresAuth: true},
        component: () => import(`@/views/Settings/WidgetSettings.vue`),
    },
    {
        path: 'system-settings',
        name: 'system-settings',
        meta: {name: 'System Settings', slug: 'system-settings', requiresAuth: true},
        component: () => import(`@/views/Settings/SystemSettings.vue`),
    }
]

export default routes
