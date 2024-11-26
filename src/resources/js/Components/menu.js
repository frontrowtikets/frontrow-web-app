export const menuItems = [
    {
        id: 1,
        label: "menuitems.menu.text",
        isTitle: true
    },
    {
        id: 2,
        label: "menuitems.dashboards.text",
        icon: "bx-home-circle",
        subItems: [
            {
                id: 3,
                label: "menuitems.dashboards.list.default",
                link: "/",
                parentId: 2
            },
        ]
    },
    {
        id: 6,
        isLayout: true
    },
    
    {
        id: 46,
        label: "menuitems.pages.text",
        isTitle: true
    },
    {
        id: 47,
        label: "menuitems.authentication.text",
        icon: "bx-user-circle",
        subItems: [
            {
                id: 56,
                label: "menuitems.authentication.list.login",
                link: "/auth/login-1",
                parentId: 55
            },
            {
                id: 57,
                label: "menuitems.authentication.list.login-2",
                link: "/auth/login-2",
                parentId: 55
            },
            {
                id: 58,
                label: "menuitems.authentication.list.register",
                link: "/auth/register-1",
                parentId: 55
            },
            {
                id: 59,
                label: "menuitems.authentication.list.register-2",
                link: "/auth/register-2",
                parentId: 55
            },
            {
                id: 60,
                label: "menuitems.authentication.list.recoverpwd",
                link: "/auth/recoverpw",
                parentId: 55
            },
            {
                id: 61,
                label: "menuitems.authentication.list.recoverpwd-2",
                link: "/auth/recoverpwd-2",
                parentId: 55
            },
            {
                id: 62,
                label: "menuitems.authentication.list.lockscreen",
                link: "/auth/lock-screen",
                parentId: 55
            },
            {
                id: 63,
                label: "menuitems.authentication.list.lockscreen-2",
                link: "/auth/lock-screen-2",
                parentId: 55
            },
            {
                id: 64,
                label: "menuitems.authentication.list.confirm-mail",
                link: "/auth/confirm-mail",
                parentId: 55
            },
            {
                id: 65,
                label: "menuitems.authentication.list.confirm-mail-2",
                link: "/auth/confirm-mail-2",
                parentId: 55
            },
            {
                id: 66,
                label: "menuitems.authentication.list.verification",
                link: "/auth/email-verification",
                parentId: 55
            },
            {
                id: 67,
                label: "menuitems.authentication.list.verification-2",
                link: "/auth/email-verification-2",
                parentId: 55
            },
            {
                id: 68,
                label: "menuitems.authentication.list.verification-step",
                link: "/auth/two-step-verification",
                parentId: 55
            },
            {
                id: 69,
                label: "menuitems.authentication.list.verification-step-2",
                link: "/auth/two-step-verification-2",
                parentId: 55
            }
        ]
    },
    {
        id: 52,
        label: "menuitems.utility.text",
        icon: "bx-file",
        subItems: [
            {
                id: 53,
                label: "menuitems.utility.list.starter",
                link: "/pages/starter",
                parentId: 52
            },
            {
                id: 54,
                label: "menuitems.utility.list.maintenance",
                link: "/pages/maintenance",
                parentId: 52
            },
            {
                id: 54,
                label: "menuitems.utility.list.comingsoon",
                link: "/pages/coming-soon",
                parentId: 52
            },
            {
                id: 58,
                label: "menuitems.utility.list.error404",
                link: "/pages/404",
                parentId: 52
            },
            {
                id: 59,
                label: "menuitems.utility.list.error500",
                link: "/pages/500",
                parentId: 52
            }
        ]
    },
    {
        id: 60,
        label: "menuitems.components.text",
        isTitle: true
    },
    {
        id: 104,
        label: "menuitems.multilevel.text",
        icon: "bx-share-alt",
        subItems: [
            {
                id: 105,
                label: "menuitems.multilevel.list.level1.1",
                link: "#",
                parentId: 104
            },
            {
                id: 106,
                label: "menuitems.multilevel.list.level1.2",
                parentId: 104,
                subItems: [
                    {
                        id: 107,
                        label: "menuitems.multilevel.list.level1.level2.1",
                        link: "#",
                        parentId: 106
                    },
                    {
                        id: 108,
                        label: "menuitems.multilevel.list.level1.level2.2",
                        link: "#",
                        parentId: 106
                    }
                ]
            }
        ]
    }
];
