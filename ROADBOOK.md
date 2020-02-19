Project roadbook
================

## Todo
- Translations


________________________________________________________________________________________________________________________

## Install
- `composer create-project --prefer-dist laravel/laravel restau`
- Create Virtualhost and database user
- Put it in `/.env`
- Edit `/config/app.php` for timezone 'Europe/Paris'
- Edit `/app/Providers/AppServiceProvider.php` to fix [too long key error](https://github.com/laravel/framework/issues/27806#issuecomment-471032843)


________________________________________________________________________________________________________________________

## Debugbar
[Github](https://github.com/barryvdh/laravel-debugbar)
- Install : `composer require barryvdh/laravel-debugbar --dev`
- Local config : `php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"` (create new file `/config/debugbar.php`)


________________________________________________________________________________________________________________________

## Authentication
[Doc](https://laravel.com/docs/6.x/authentication)
```
composer require laravel/ui --dev
php artisan ui vue --auth
npm install && npm run dev
```


________________________________________________________________________________________________________________________

## Move models
[Source](https://medium.com/@codingcave/organizing-your-laravel-models-6b327db182f9)
- Create `/app/Models` folder and move `/app/User.php` in
- Update namespaces in files :
    - `/app/Http/Controllers/Auth/RegisterController.php`
    - `/app/Models/User.php`
    - `/config/auth.php`
    - `/database/factories/UserFactory.php`


________________________________________________________________________________________________________________________

## Soft deletes
[Doc](https://laravel.com/docs/6.x/eloquent#soft-deleting)
- Create migration file : `php artisan make:migration add_soft_deletes_to_users_table` (see content in `/database/migrations/*_add_soft_deletes_to_users_table.php`)
- Add trait into `/app/Models/User.php`


________________________________________________________________________________________________________________________

## Role to users
- Create migration file : `php artisan make:migration add_role_to_users_table` (see content in `/database/migrations/*_add_role_to_users_table.php`)
- Add const and methods into `/app/Models/User.php`
- Create middleware : `php artisan make:middleware RoleMiddleware` (see content in `/app/Http/Middleware/RoleMiddleware.php`)
- Edit : `/app/Http/Kernel.php` to add middleware in the `$routeMiddleware` property
- Edit `/database/seeds/DatabaseSeeder.php`

### Helper to display role (Blade)
[Source](https://tutsforweb.com/creating-helpers-laravel/)
- Create `/app/Helpers/role.php`
- Create provider : `php artisan make:provider HelperServiceProvider` (see content in `/app/Providers/HelperServiceProvider.php`)
- Edit `/config/app.php` to add provider


________________________________________________________________________________________________________________________

## Migrate !
- `php artisan migrate:fresh --seed`


________________________________________________________________________________________________________________________

## Fix some JS / SASS / Webpack issues
[Source](https://gist.github.com/rseon/cb5f5bdad8e0db5b482f85894e749068)
- `npm install webpack-chunk-rename-plugin --save-dev`
- Create `/mergeManifest.js`
- Create `/webpack.css.mix.js`
- Create `/webpack.js.mix.js`
- Delete `/webpack.mix.js`
- Edit `/resources/views/layouts/app.blade.php`
- Update scripts in `/package.json`


________________________________________________________________________________________________________________________

## Restricted area
Our restricted area is named "manager".

- Edit `/app/Providers/RouteServiceProvider` :
    - Change const `HOME`
    - Edit method `map`
    - Add method `mapManagerRoutes`
- Create :
    - Namespace controllers in `/app/Http/Controllers/Manager` folder
    - New provider for Blade function `@admin` in `/app/Providers/BladeServiceProvider.php` and edit `/config/app.php` to add our new provider
    - The routes in `/routes/manager.php`
    - The layout in `/resources/views/layout/manager.blade.php`
    - The LatestScope  in `/app/Scopes/LatestScope.php` (and edit `/app/Models/User.php`)

### User (and admin) access
- Create the Home controller : `php artisan make:controller Manager\HomeController` (see content in `/app/Http/Controllers/Manager/HomeController.php`)
- Create `/resources/views/manager/home.blade.php`

### Only admin access
- Create the User controller : `php artisan make:controller Manager\UserController --resource --model=Models\User` (see content in `/app/Http/Controllers/Manager/UserController.php`)
- Create `/resources/views/manager/user` files
- Create the User request : `php artisan make:request Manager\UserRequest` (see content in `/app/Http/Requests/Manager/UserRequest.php`)
- Removing `show` method (optional) :
    - Remove the method from `/app/Http/Controllers/Manager/UserController.php`
    - Edit the route in `/routes/manager.php`
    - Edit method `render` in `/app/Exceptions/Handler.php` to show 404 error instead of MethodNotAllowedHttpException (warning : we won't know if its really a 404 or not for all methods...) 
    - [Source](https://stackoverflow.com/a/45500231)
- Create seeder : `php artisan make:seeder UsersTableSeeder` (see content in `/database/seeds/UsersTableSeeder.php`)
- Seed database : `php artisan db:seed --class=UsersTableSeeder`


________________________________________________________________________________________________________________________

## Restrict access for inactive users
[Source](https://stackoverflow.com/a/55720589)
- Create migration file : `php artisan make:migration add_active_to_users_table` (see content in `/database/migrations/*_add_active_to_users_table.php`)
- Create trait `/app/Traits/Eloquent/Active.php` and add it to `/app/Models/User.php`
- Add method `credentials` to `/app/Http/Controllers/Auth/LoginController`

Note : the Active trait is useful for all models ;)


________________________________________________________________________________________________________________________

## Simple CRUD with VueJS
Example : Post management

### Backend Laravel part
- Create new model `php artisan make:model Models\Post -mf` :
    - Model : `/app/Models/Post.php`
    - Factory : `/database/factories/PostFactory.php`
    - Migration : `/database/migrations/*_create_posts_table.php`
- Create the CanBeAuthor rule : `php artisan make:rule CanBeAuthor` (see content in `/app/Rules/CanBeAuthor.php`)
- Create the Post request : `php artisan make:request Manager\PostRequest` (see content in `/app/Http/Requests/Manager/PostRequest.php`)
- Create the Post resource : `php artisan make:resource Manager\PostResource` (see content in `/app/Http/Resources/Manager/PostResource.php`)
- Create the Post policy : `php artisan make:policy PostPolicy --model=Models\Post` (see content in `/app/Policies/PostPolicy.php`)
- Create the StripTags middleware : `php artisan make:middleware StripTags` (see content in `/app/Http/Middleware/StripTags.php`)
    - Add it in the property `$middleware` of file `/app/Http/Kernel.php`
- Create new API controller `php artisan make:controller Manager\PostController --api --model=Models\Post` :
    - Controller file in `/app/Http/Controllers/Manager/PostController.php`
    - Note : the `index` method is used to get the list of posts AND retrieve posts in JSON (for VueJS). We could create an API controller, but we want to KISS
- Add resource route in `/routes/manager.php`
- Create seeder : `php artisan make:seeder PostTableSeeder` (see content in `/database/seeds/PostTableSeeder.php`)
- Update database : `php artisan migrate` and seed with dataset : `php artisan db:seed --class=PostTableSeeder`


### Backend VueJS part
- Create components : `/resources/js/components/Post` files
- Edit `/resources/js/app.js` and `/resources/js/bootstrap.js`
- Edit `/webpack.mix.js`
- Run `npm run dev`


### Frontend (public)
- Edit `/app/Http/Controllers/HomeController.php`
- Create the Post controller : `php artisan make:controller PostController --model=Models\Post` (see content in `/app/Http/Controllers/PostController.php`)
- Create the Author controller : `php artisan make:controller AuthorController --model=Models\User` (see content in `/app/Http/Controllers/AuthorController.php`)
- Edit `/routes/web.php` to add routes
- Edit `/resources/views/home.blade.php` to display latest posts
- Create `/resources/views/post`
- Create `/resources/views/author.blade.php`


________________________________________________________________________________________________________________________

## Adding relations
Example : categories and relations with posts

### Create category management
- Create new model `php artisan make:model Models\Category -mcrf` :
    - Model : `/app/Models/Category.php`
    - Factory : `/database/factories/CategoryFactory.php`
    - Migration : `/database/migrations/*_create_categories_table.php`
    - Controller : `/app/Http/Controllers/CategoryController.php`
- Create the Category request : `php artisan make:request Manager\CategoryRequest` (see content in `/app/Http/Requests/Manager/CategoryRequest.php`)
- Create manager controller : `php artisan make:controller Manager\CategoryController --model=Models\Category`
- Edit `/resources/views/layouts/manager.blade.php` to add link in menu
- Edit `/routes/manager.php` to add resource route
- Create `/resources/views/manager/category`

### Add relation with posts
- Create migration file : `php artisan make:migration create_posts_categories_table` (see content in `/database/migrations/*_create_posts_categories_table.php`)
- Update `/app/Models/Post.php` to add the `categories` method


________________________________________________________________________________________________________________________

## Translations
- `php artisan make:middleware Locale` => `/app/Http/Middleware/Locale.php`
- `/app/Http/Kernel.php`
- `/resources/lang/fr.json`
- `/routes/web.php`


________________________________________________________________________________________________________________________

## List of all non-native files and folders
- `d` - folder
- `f` - file
- `m` - class method
- `p` - class property or constant

### Created
- `d` - `/app/Helpers`
- `m` - `App\Http\Controllers\Auth\LoginController@credentials`
- `d` - `/app/Http/Controllers/Manager`
- `f` - `/app/Http/Middleware/StripTags.php`
- `f` - `/app/Http/Middleware/RoleMiddleware.php`
- `d` - `/app/Requests`
- `d` - `/app/Resources`
- `d` - `/app/Models`
- `f` - `/app/Policies/PostPolicy.php`
- `f` - `/app/Providers/BladeServiceProvider`
- `f` - `/app/Providers/HelperServiceProvider`
- `m` - `App\Providers\RouteServiceProvider@mapManagerRoute`
- `d` - `/app/Rules`
- `d` - `/app/Scopes`
- `d` - `/app/Traits`
- `f` - `/config/debugbar.php`
- `f` - `/database/factories/PostFactory.php`
- `f` - `/database/migrations/*` (except the first three)
- `f` - `/database/seeds/PostTableSeeder.php`
- `f` - `/database/seeds/UsersTableSeeder.php`
- `d` - `/resources/js/components/Post`
- `f` - `/resources/js/lang/en.json`
- `f` - `/resources/views/layouts/manager.blade.php`
- `d` - `/resources/views/manager`
- `f` - `/routes/manager.php`

### Updated
- `m` - `App\Exceptions\Handler@render`
- `p` - `App\Http\Kernel::$middleware`
- `p` - `App\Http\Kernel::$routeMiddleware`
- `f` - `/app/Models/User.php`
- `m` - `App\Providers\AppServiceProvider@boot`
- `p` - `App\Providers\AuthServiceProvider::$policies`
- `p` - `App\Providers\RouteServiceProvider::HOME`
- `m` - `App\Providers\RouteServiceProvider@map`
- `f` - `/config/app.php`
    - Updated `timezone`
    - Added our providers
- `f` - `/config/auth.php` (moved user model)
- `f` - `/database/seeds/DatabaseSeeder.php`
- `f` - `/resources/js/app.js`
- `f` - `/resources/js/bootstrap.js`
- `f` - `/routes/web.php`
- `f` - `/.env`

### Deleted
- `f` - `/webpack.mix.js`

