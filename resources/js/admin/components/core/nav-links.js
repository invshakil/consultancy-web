const adminPrefixSlug = 'dashboard/admin'
const adminRoutes = [
    {
        to: `/${adminPrefixSlug}/home`,
        icon: 'mdi-alpha-d-box-outline',
        slug: 'dashboard'
    },
    {
        to: `/${adminPrefixSlug}/applications`,
        icon: 'mdi-alpha-a-box-outline',
        slug: 'applications'
    },
    {
        to: `#`,
        icon: 'mdi-alpha-b-box-outline',
        slug: 'blogs',
        subLinks: [
            {
                to: `/${adminPrefixSlug}/categories`,
                icon: 'mdi-alpha-c-box-outline',
                slug: 'categories'
            },
            {
                to: `/${adminPrefixSlug}/articles`,
                icon: 'mdi-table-edit',
                slug: 'blogs'
            },
            {
                to: `/${adminPrefixSlug}/create-article`,
                icon: 'mdi-square-edit-outline',
                slug: 'new-article'
            }
        ]
    },
    {
        to: `#`,
        icon: 'mdi-alpha-j-box-outline',
        slug: 'jobs',
        subLinks: [
            {
                to: `/${adminPrefixSlug}/countries`,
                icon: 'mdi-google-maps',
                slug: 'countries'
            },
            {
                to: `/${adminPrefixSlug}/industries`,
                icon: 'mdi-robot-industrial',
                slug: 'industries'
            },
            {
                to: `/${adminPrefixSlug}/jobs`,
                icon: 'mdi-table-edit',
                slug: 'jobs'
            },
            {
                to: `/${adminPrefixSlug}/create-job`,
                icon: 'mdi-square-edit-outline',
                slug: 'new-job'
            }
        ]
    },
    {
        to: `#`,
        icon: 'mdi-alpha-s-box-outline',
        slug: 'pages',
        subLinks: [
            {
                to: `/${adminPrefixSlug}/pages`,
                icon: 'mdi-table-edit',
                slug: 'pages'
            },
            {
                to: `/${adminPrefixSlug}/news`,
                icon: 'mdi-square-edit-outline',
                slug: 'news'
            }
        ]
    },
    {
        to: `#`,
        icon: 'mdi-cog',
        slug: 'settings',
        subLinks: [
            {
                to: `/${adminPrefixSlug}/widget-settings`,
                icon: 'mdi-saw-blade',
                slug: 'widget-settings'
            },
            {
                to: `/${adminPrefixSlug}/system-settings`,
                icon: 'mdi-cog',
                slug: 'system-settings',
            },
            {
                to: `/${adminPrefixSlug}/user-profile`,
                icon: 'mdi-account',
                slug: 'user-profile'
            },
        ]
    }
]

export default adminRoutes
