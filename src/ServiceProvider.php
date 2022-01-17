<?php

namespace Squirrel\Blog;

use App\Traits\ModuleServiceProviderTrait;
use Squirrel\Blog\Widgets\Blog;
use Squirrel\Blog\Widgets\Category;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    use ModuleServiceProviderTrait;

    public $casts = [
        'Squirrel\Blog\Models\BlogPost' => 'Squirrel\Blog\Controllers\PostController',
    ];

    private $permissions = [
        'view'         => 'View Post',
        'create'       => 'Create Post',
        'edit'         => 'Edit Post',
        'delete'       => 'Delete Post'
    ];
    private $appendAdminMenus = [
        'content' => [
            'blog' => [
                'title'     => 'Blogs',
                'icon'      => 'file',
                'permission'=> 'blog.view',
                'children'  => [
                    'site'      => [
                        'title'     => 'All Posts',
                        'route'     => 'admin.blog.posts.index',
                        'icon'      => 'circle',
                        'permission'=> 'blog.view'
                    ],
                    'services'  => [
                        'title'     => 'Categories',
                        'route'     => 'admin.blog.categories.index',
                        'icon'      => 'circle',
                        'permission'=> 'blog.view'
                    ]
                ]
            ]
        ]
    ];

//    private $notications = [
//        [
//            'for' => 'employee',
//            'key' => 'test',
//            'title' => 'Test',
//            'type' => ['email', 'sms'],
//            'default' => ['email']
//        ]
//    ];

    private $widgets = [
        'blog-categories'   => [Blog::class, 'categories'],
        'blog-recent-posts'   => [Blog::class, 'recentPosts'],
        'blog-search'   => [Blog::class, 'search'],
    ];

    //private $theme = true;
}
